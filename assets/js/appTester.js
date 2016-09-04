/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function($){
	
	$(document).ready(function(){
            
            
            $('.edit-category-btn').off('click').on('click',function(e){
                e.preventDefault();
                if($(this).closest('li').next().is(':visible')){
                    //$(this).text('Close');
                    $(this).closest('li').next().slideUp();
                    $(this).closest('li').next().find('.categoryID').attr('disabled', 'disabled');
                    $(this).closest('li').next().find('.testsheetID').attr('disabled','disabled');
                } else {
                    //$(this).text('Edit');
                    $(this).closest('li').next().slideDown();
                    $(this).closest('li').next().find('.categoryID').removeAttr('disabled');
                    $(this).closest('li').next().find('.testsheetID').removeAttr('disabled');
                }
            });
            
            $('.edit-question-btn').off('click').on('click',function(e){
                e.preventDefault();
                if($(this).closest('li').next().is(':visible')){
                    //$(this).text('Close');
                    $(this).closest('li').next().slideUp();
                    $(this).closest('li').next().find('.categoryID').attr('disabled', 'disabled');
                    $(this).closest('li').next().find('.questionID').attr('disabled','disabled');
                    $(this).closest('li').next().find('.testsheetID').attr('disabled','disabled');
                } else {
                    //$(this).text('Edit');
                    $(this).closest('li').next().slideDown();
                    $(this).closest('li').next().find('.categoryID').removeAttr('disabled');
                    $(this).closest('li').next().find('.questionID').removeAttr('disabled');
                    $(this).closest('li').next().find('.testsheetID').removeAttr('disabled');
                }
            });
            
            $('.delete-question-btn').off('click').on('click',function(e){
                e.preventDefault();
                
                var doDelete = confirm('Do you wish to delete this question?  All responses will be deleted!');
                
                if(doDelete){
                    $(this).parent().submit();
                }
            });
            
            $('.delete-category-btn').off('click').on('click',function(e){
                e.preventDefault();
                
                var doDelete = confirm('Do you wish to delete this category?  All created questions and responses will be deleted!');
                
                if(doDelete){
                    $(this).parent().submit();
                }
            });
            /*
            $('.edit-testsheet-btn').off('click').on('click', function(e){
                e.preventDefault();
                var hiddenInput = $(this).parent().next();
                if(hiddenInput.filter(':visible').length === 0){
                    $(hiddenInput).slideDown();
                }else {
                    $(hiddenInput).slideUp();
                }
            })*/
            
        });
        
})(jQuery);