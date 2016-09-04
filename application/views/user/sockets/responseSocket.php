 <script>  
       var base_url = "<?php echo base_url();?>";
       var project_id = <?php echo $projectID;?>;
       var user_id = <?php echo $userID;?>;

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

                
                
                socket.on('resolveNewResponse', function(data) {
                    
                        var tsqToedit = $('.testsheetQuestionID[value="'+data.testQuestionID +'"]');
                        var inputBox = $(tsqToedit).parent().find('.response-input');
                        var responses = $(tsqToedit).parent().find('.response-container');
                        //var userEmail = $('#user-data').attr('data-user-email');
                        var html = "<li class='form-li' style='margin-bottom:0;'>" + "<input type='hidden' class='responseID' value='" +
                            data.id + "' />" +
                            "<div class='response-box' style='position:relative;padding:5px;height:50px;border:1px solid #C5C5C5;border-bottom:0;margin-bottom:0'>";
                         if(parseInt(user_id) ===parseInt(data.userID)){
                             html += "<div style='position:absolute;top:2px;right:2px'>"+
                             "<button type='button' style='margin-right:2px;margin-left:2px' class='btn btn-default btn-xs edit-response-btn'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></button>" +
                            "<button type='button' style='margin-right:2px;margin-left:2px' class='btn btn-default btn-xs delete-response-btn'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>" +
                            "</div>";
                            }
                            html += "<span style='color:#4DD435;font-size:12px;position:absolute;right:5px;bottom:0;'>" + data.user_email +
                            "</span><span class='response-content'>" + data.input + "</span>" + "</div>" +
                            "<div style='display:none;overflow:auto' class='update-response-div'>" +
                            "<textarea style='width:100%;resize:none' class='edit-response-textarea'>" + data.input + "</textarea>" +
                            "<button style='margin-bottom:12px;float:right;' class='btn btn-primary response-write float-right'>Save</button>" +
                            "</div>" + "</li>";
                        $(html).appendTo(responses);
                        $(inputBox).val('');
                        assignBtnEventHandlers();
                    });

                    //delete response socket listener
                    socket.on('removeResponse', function(data) {
                        
                            var selector = '.responseID[value="'+data.responseID+'"]';
                        $(selector).parent().fadeOut(function() {
                            $(this).remove();
                        });
                    });
                    
                    socket.on('updateQuestionStatus', function(data){
                        var selector = '.testsheetQuestionID[value="'+data.testsheetQuestionID+'"]';
                        if(data.isChecked){
                            
                            $(selector).next().find('.isQuestionComplete').prop('checked', true);
                        } else {
                            $(selector).next().find('.isQuestionComplete').prop('checked', false);
                        }
                    });
                    
                    socket.on('modifyResponse', function(data) {
                            if (data.success) {
                                var selector = '.responseID[value="'+data.responseID+'"]';
                                $(selector).siblings('.response-box').find('.response-content').text(data.newResponse);
                                $(selector).siblings('.response-box').show()
                                $(selector).siblings('.update-response-div').hide();
                            }
                        });
                        
                        
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
                    
                     //edit response comment
                    $('.edit-response-btn').off('click').on('click', function(e) {
                        e.preventDefault();
                        var hiddenInput = $(this).parent().siblings('.update-response-div');
                        var textResponse = $(this).parent().next();
                        if (hiddenInput.filter(':visible').length === 0) {
                            textResponse.hide();
                            $(hiddenInput).show();
                            var html = $(hiddenInput).find('.edit-response-textarea').val();
                            $(hiddenInput).find('.edit-response-textarea').focus().val("").val(html);
                        } else {
                            textResponse.show();
                            $(hiddenInput).hide();
                        }
                    });

                    
                    //delete response comment
                    $('.delete-response-btn').off('click').on('click', function(e) {
                        var doDelete = confirm('This will delete the response.  Do you wish to continue?');
                        
                        if (doDelete) {
                            var responseID = $(this).parent().siblings('.responseID').val();
                            socket.emit('deleteResponse', {
                                'responseID': responseID
                            });
                        }
                    });
                    
                    //update response
                    $('.response-write').off('click').on('click', function(e) {
                        e.preventDefault();
                        var responseIDInput = $(this).parent().siblings('.responseID');
                        var responseID = $(this).parent().siblings('.responseID').val();
                        var newResponse = $(this).siblings('.edit-response-textarea').val();
                        socket.emit('updateResponse', {
                            "responseID": responseID,
                            "newResponse": newResponse
                        });
                        
                    });
                    
                    $('.toggleResponses').off('click').on('click', function(e){
                        e.preventDefault();
                        
                        if($(this).hasClass('glyphicon-menu-down')){
                            $(this).removeClass('glyphicon-menu-down').addClass('glyphicon-menu-right');
                            $(this).parent().siblings('.response-container').fadeOut();
                        }else {
                            $(this).removeClass('glyphicon-menu-right').addClass('glyphicon-menu-down');
                            $(this).parent().siblings('.response-container').fadeIn();
                        }
                    });
                    //write new comment -event handler function
                $('.comment-write').off('click').on('click', function(e) {
                    
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
                
                $('.isQuestionComplete').off('change').on('change',function(e){
                    e.preventDefault();
                    
                    var isChecked = (this.checked)? true: false;
                    var testsheetQuestionID = $(this).closest('.response').siblings('.testsheetQuestionID').val();
                    
                    socket.emit('updateQuestionStatus', {
                        "testsheetQuestionID": testsheetQuestionID,
                        "isChecked":isChecked
                    });
                })
                
                   }
 
                $(document).ready(function() {
                    assignBtnEventHandlers();
                });
            })(jQuery, socket);
	</script>