 <script>  
       var base_url = "<?php echo base_url();?>";
       var project_id = <?php echo $projectID;?>;
       var user_id = <?php echo $userID;?>;
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
                    'collaboration': 1
                });
            });
            (function($, socket) {
                $('#save-project-btn').off('click').on('click', function() {
                    var projectStatus = $('#toggle-project-status option:selected').val();
                    var newProjectDeadline = $('#newProjectDeadline').val();
                    socket.emit('updateProjectDescription', {
                        "deadline": newProjectDeadline,
                        "status": projectStatus,
                        "projectID": project_id
                    });
                });

                //write new comment -event handler function
                $('.comment-write').off('click').on('click', function(e) {
                    socketVariableManager._that = this;
                    e.preventDefault();
                    var input = $(this).siblings('.response-input').val();
                    
                    var testsheetQuestionID = $(this).parent().siblings('.testsheetQuestionID').val();
                    //send message to socket
                    socket.emit('createResponse', {
                        "response": input,
                        "testsheetQuestionID": testsheetQuestionID,
                        "projectID": project_id,
                        'userID': user_id,
                        'input':input,
                        'user_email' : user_email
                    });
                    //receive socket message update HTML
                    
                });
                
                socket.on('resolveNewResponse', function(data) {
                    
                        var tsqToedit = $('.testsheetQuestionID[value="'+data.testQuestionID +'"]');
                        var inputBox = $(tsqToedit).parent().find('.response-input');
                        var responses = $(tsqToedit).parent().find('.response-container');
                        //var userEmail = $('#user-data').attr('data-user-email');
                        var html = "<li class='form-li' style='margin-bottom:0;'>" + "<input type='hidden' class='response-id' value='" +
                            data.id + "' />" +
                            "<div class='response-box' style='position:relative;padding:5px;height:50px;border:1px solid #C5C5C5;border-bottom:0;margin-bottom:0'>" +
                            "<div style='position:absolute;top:2px;right:2px'>" +
                            "<button type='button' style='margin-right:2px;margin-left:2px' class='btn btn-default btn-xs edit-response-btn'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></button>" +
                            "<button type='button' style='margin-right:2px;margin-left:2px' class='btn btn-default btn-xs delete-response-btn'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>" +
                            "</div>" + "<span style='color:#4DD435;font-size:12px;position:absolute;right:5px;bottom:0;'>" + data.user_email +
                            "</span><span class='response-content'>" + data.input + "</span>" + "</div>" +
                            "<div style='display:none;overflow:auto' class='update-response-div'>" +
                            "<textarea style='width:100%;resize:none' class='edit-response-textarea'>" + data.input + "</textarea>" +
                            "<button style='margin-bottom:12px;float:right;' class='btn btn-primary response-write float-right'>Save</button>" +
                            "</div>" + "</li>";
                        $(html).appendTo(responses);
                        $(inputBox).val('');
                        assignBtnEventHandlers();
                    });

                //receive message to remove testsheet
                socket.on('removeTestsheet', function(data) {
                    console.log('removeTestsheet');
                    if (data.success) {
                        $(socketVariableManager._deletethat).parent().fadeOut(function() {
                            $(socketVariableManager._deletethat).parent().next().remove();
                            $(socketVariableManager._deletethat).parent().remove();
                        });
                    }
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

                //socket - update dom when received new project description
                socket.on('updateProjDesc_1', function(data) {
                    var newProjectStatus = (parseInt(data.status) === 0) ? 'Open' : 'Closed';
                    var newProjectDeadline = data.deadline;
                    $('#projectStatus').text(newProjectStatus);
                    $('#projectDeadline').text(newProjectDeadline);
                    $('#edit-project.div').slideUp();
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

                    //delete response socket listener
                    socket.on('removeResponse', function(data) {
                        $(socketVariableManager._deleteResponseThis).parent().parent().parent().fadeOut(function() {
                            $(this).remove();
                        });
                    })

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

                    //edit response comment
                    $('.edit-response-btn').off('click').on('click', function(e) {
                        e.preventDefault();
                        var hiddenInput = $(this).parent().parent().next();
                        if (hiddenInput.filter(':visible').length === 0) {
                            $(hiddenInput).slideDown();
                            var html = $(hiddenInput).find('.edit-response-textarea').val();
                            $(hiddenInput).find('.edit-response-textarea').focus().val("").val(html);
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
                            $(socketVariableManager._updateResponsethat).parent().parent().prev().find('a').text(data.newTestsheetTitle);
                            $(socketVariableManager._updateResponsethat).parent().parent().slideUp();
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

                    //delete response comment
                    $('.delete-response-btn').off('click').on('click', function(e) {
                        var doDelete = confirm('This will delete the response.  Do you wish to continue?');
                        socketVariableManager._deleteResponseThis = this;
                        if (doDelete) {
                            var responseID = $(this).parent().parent().siblings('.response-id').val();
                            socket.emit('deleteResponse', {
                                'responseID': responseID
                            });
                        }
                    });
                    
                    //update response
                    $('.response-write').off('click').on('click', function(e) {
                        e.preventDefault();
                        socketVariableManager._newResponse = this;
                        var responseIDInput = $(this).parent().siblings('.response-id');
                        var responseID = $(this).parent().siblings('.response-id').val();
                        var newResponse = $(this).siblings('.edit-response-textarea').val();
                        socket.emit('updateResponse', {
                            "responseID": responseID,
                            "newResponse": newResponse
                        });
                        socket.on('modifyResponse', function(data) {
                            if (data.success) {
                                $(responseIDInput).next().find('.response-content').text(newResponse);
                                $(socketVariableManager._newResponse).parent().slideUp();
                            }
                        });
                    });
                    $('.delete-testsheet-btn').off('click').on('click', function(e) {
                        e.preventDefault();
                        var doDelete = confirm('This will delete the testsheet for all users');
                        socketVariableManager._deletethat = this;
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