 <script>  
       var base_url = "<?php echo base_url();?>";
       var project_id = <?php echo $projectID;?>;
       var user_id = <?php echo $userID;?>;
       var collaborationID = <?php echo $collaborationID; ?>;
       var is_author = <?php if(isset($projectManager)){
           echo (intval($userID) === intval($projectManager->id)) ? 1 :0; 
       } 
?>;
       var user_email = "<?php echo $userEmail; ?>";

</script>
<script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
	
	<script>
            
            
		var socket = io('http://192.168.1.115:3000', {
                    reconnect: true
                });


               $(window).on('beforeunload', function(){
                    socket.close();
                });
            //manage variables for working with sockets.  Used for mainly storing 'this' values
            var socketVariableManager = {};

            socket.on('connect', function() {
                socket.emit('userInfo', {
                    'userID': user_id,
                    "projectID": project_id,
                    'collaboration': collaborationID
                });
            });
            (function($, socket) {

                //receive message to remove testsheet
                socket.on('removeTestsheet', function(data) {
                    console.log('removeTestsheet');
                    if (data.success) {
                        
                        var testsheetID = '.testsheetID[value="'+data.testsheetID+'"]';
                        
                        $(testsheetID ).parent().parent().prev().fadeOut(function() {
                            $(testsheetID ).parent().parent().prev().remove();
                            $(testsheetID ).parent().parent().remove();
                        });
                    }
                });
                
                //socket - update dom when received new project description
                socket.on('updateProjDesc', function(data) {
                    var newProjectStatus = (parseInt(data.status) === 0) ? 'Open' : 'Closed';
                    var newProjectDeadline = data.deadline;
                    $('#projectStatus').text(newProjectStatus);
                    $('#projectDeadline').text(newProjectDeadline);
                    $('#edit-project.div').slideUp();
                });

                $('#save-project-btn').off('click').on('click', function(e) {
                    e.preventDefault();
                    var projectStatus = $('#toggle-project-status option:selected').val();
                    var newProjectDeadline = $('#newProjectDeadline').val();
                    socket.emit('updateProjectDescription', {
                        "deadline": newProjectDeadline,
                        "status": projectStatus,
                        "projectID": project_id
                    });
                });
                

                //create new Testsheet - socket listener
                socket.on('sendMessageNewTestsheet', function(data) {
                    console.log(data);
                    
                    var newTestsheetHTML = "<a style='width:200px;display:inline-block;' href=" + base_url +
                        "index.php/testsheet/overview/testsheetID/" + data.testsheetID + ">" + data.testsheetTitle + "</a>";
                
                    if(is_author){
                        
                     newTestsheetHTML +=   "<button type='button' style='margin-left:3px;margin-right:2px' class='btn btn-default btn-sm edit-testsheet-btn'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></button>" +
                        "<button type='button'  style='margin-left:3px;margin-right:2px' class='btn btn-default btn-sm delete-testsheet-btn'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>"
                    }  
                
                    var newTestsheet = $('<li></li>').addClass('form-li').html(newTestsheetHTML);    
                     
                    $('#testsheetlist').append(newTestsheet);
                    var hiddenEdit = $('<li></li>').addClass('form-li edit-testsheet-name').css('display', 'none').html("<div>" +
                        "<label class='form-new-label'>Change Title:</label>" + "<input type='hidden' disabled='disabled' class='testsheetID' value='" +
                        data.testsheetID + "' />" + "<input class='new-testsheet-title' type='text' value='" + data.testsheetTitle + "' />" +
                        "<button class='btn btn-primary save-titlesheet-btn'>Save</button>" + "</div>");
                    $('#testsheetlist').append(hiddenEdit);
                    newTestsheet.fadeIn();
                    $('#new-testsheet-title').val('');
                    assignBtnEventHandlers();
                });

                //event handlers
                var assignBtnEventHandlers = function() {
                    $('#edit-project-btn').off('click').on('click', function(e) {
                        e.preventDefault();
                        if ($('#edit-project-div:visible').length === 0) {
                            $(this).text('Close');
                            $('#edit-project-div').slideDown();
                        } else {
                            $(this).text('Edit');
                            $('#edit-project-div').slideUp();
                        }
                    });

                    //edit testsheet - show/hide edit box
                    $('.edit-testsheet-btn').off('click').on('click', function(e) {
                        e.preventDefault();
                        var hiddenInput = $(this).parent().next();
                        if (hiddenInput.filter(':visible').length === 0) {
                            $(hiddenInput).slideDown();
                        } else {
                            $(hiddenInput).slideUp();
                        }
                    });

                    //save new titlesheet and update DOM for all other socket listeners
                    $('.save-titlesheet-btn').off('click').on('click', function(e) {
                        e.preventDefault();
                        var testsheetID = $(this).siblings('.testsheetID').val();
                        var newTestsheetTitle = $(this).siblings('.new-testsheet-title').val();
                        socketVariableManager._updateResponsethat = this;
                        socket.emit('updateTestsheetDescription', {
                            "testsheetID": testsheetID,
                            /*"testsheetQuestion":testsheetQuestion ,*/
                            "newTestsheetTitle": newTestsheetTitle
                        });
                        
                    });

                    socket.on('resolveNewTestsheetName', function(data) {
                        
                            var testsheetID = '.testsheetID[value="'+data.testsheetID+'"]';
                            $(testsheetID).parent().parent().prev().find('a').text(data.newTestsheetTitle);
                            $(testsheetID).parent().parent().slideUp();
                        });
                        
                    //create new testsheet button 
                    $('#createTestSheetBtn').off('click').on('click', function() {
                        var testsheetTitle = $('#new-testsheet-title').val();
                        if (testsheetTitle.length === 0) {
                            alert('No testsheet title defined');
                            return;
                        }
                        var testsheetType = $('input[name="testsheetType"]:checked').val();
                        socket.emit('createTestsheet', {
                            "testsheetTitle": testsheetTitle,
                            "testsheetType": testsheetType,
                            "projectID": project_id
                        });
                    });

                
                    $('.delete-testsheet-btn').off('click').on('click', function(e) {
                        e.preventDefault();
                        var doDelete = confirm('This will delete the testsheet for all users');
                        //socketVariableManager._deletethat = this;
                        if (!doDelete) {
                            return;
                        }
                        var testsheetID = $(this).parent().next().find('.testsheetID').val();
                        socket.emit('deleteTestsheet', {
                            "testsheetID": testsheetID
                        });
                    });
                }
                $(document).ready(function() {
                    assignBtnEventHandlers();
                });
            })(jQuery, socket);
	</script>