(function($){
	
	$(document).ready(function(){
		console.log('dom loaded');
		
		$('.toggle-edit-row').unbind().on('click', function(e){
			e.preventDefault();
			toggleEditRow(this);
				
		});
		
		$('.submit-newDesc-btn').unbind().on('click', function(e){
			e.preventDefault();
			submitQuestionEdits(this);
		});
                
                $('#change-device-desc').unbind().on('click', function(e){
			e.preventDefault();
			submitDeviceEdits(this);
		});
                
                $('.delete-device-row').unbind().on('click', function(e){
			e.preventDefault();
			deleteDevice(this);
		});
                
                $('.delete-question').unbind().on('click', function(e){
			e.preventDefault();
			deleteQuestion(this);
		});
		
	});
	
        var deleteQuestion = function(trigger){
            
            if(!confirm('This will delete the question - do you wish to continue?')){
                return;
            }
            var deviceID = $(trigger).parent().parent().next().find('.question-id').eq(0).val();
		var baseURL = $('#base_url').val();
		
		$.ajax({
			url: baseURL +'index.php/api/question/delete/'+deviceID,
			method: 'post',
			success: function(data){
				
				if(data.status==='success'){
					$(trigger).parent().parent().next().remove();
                                        $(trigger).parent().parent().remove();
				}
				
			},
			error : function(){
				console.log('error with code');
			}
		});
        }
        
        var deleteDevice = function(trigger){
            
            if(!confirm('This will delete the device - do you wish to continue?')){
                return;
            }
            var deviceID = $(trigger).parent().parent().next().find('.device-id').eq(0).val();
		var baseURL = $('#base_url').val();
		
		$.ajax({
			url: baseURL +'index.php/api/device/delete/'+deviceID,
			method: 'post',
			success: function(data){
				
				if(data.status==='success'){
					$(trigger).parent().parent().next().remove();
                                        $(trigger).parent().parent().remove();
				}
				
			},
			error : function(){
				console.log('error with code');
			}
		});
        }
        
	var toggleEditRow = function(trigger){
		
		var editTr = $(trigger).parent().parent().next();
		
		if($(editTr).css('display') === 'none'){
                    $(trigger).text('Hide');
			$(editTr).slideDown();
		} else {
                        $(trigger).text('Edit');
			$(editTr).slideUp();
		}
	}
	
	var submitQuestionEdits = function(trigger){
		
		var newDesc = $(trigger).siblings('textarea').filter('.newDescription').val();
                var newCategory = $(trigger).siblings('.newCategory').find('option:selected').val()
		var questionID = $(trigger).siblings('input').filter('.question-id').eq(0).val();
		var baseURL = $('#base_url').val();
		
		$.ajax({
			url: baseURL +'index.php/api/question/update/'+questionID,
			data: {
				newDesc: newDesc,
                                newCategory: newCategory
			},
			method: 'post',
			success: function(data){
				
				if(data.status==='success'){
					$(trigger).parent().parent().prev().find('.questionDesc').text(data.msg);
				}
                                
                                window.location.reload(false); 
				
			},
			error : function(){
				console.log('error with code');
			}
		});
		
	}

    var submitDeviceEdits = function(trigger){
		
		var newDesc = $(trigger).siblings('input').filter('.newDescription').val();
		var deviceID = $(trigger).siblings('input').filter('.device-id').eq(0).val();
		var baseURL = $('#base_url').val();
		
		$.ajax({
			url: baseURL +'index.php/api/device/update/'+deviceID,
			data: {
				newDesc: newDesc
			},
			method: 'post',
			success: function(data){
				
				if(data.status==='success'){
					$(trigger).parent().parent().prev().find('.deviceDesc').text(data.msg);
				}
				
			},
			error : function(){
				console.log('error with code');
			}
		});
		
	}
})(jQuery);