/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function($){
   
    $('.container-admin li').click(function(){
       //rimuovo la classe active da tutti e la inserisco qua
       $('.container-admin li').removeClass('active');
       $(this).addClass('active');
       var tab = $(this).find('a').attr('href');
       tab = tab.replace('#', '');
       
       //lavoro sui container sottostanti
       $('.tab-content div').removeClass('in');
       $('.tab-content div').removeClass('active');
       
       $('#'+tab).addClass('in');
       $('#'+tab).addClass('active');
       
    });
    
    if($('.container-admin').length > 0){
        var url = window.location.href; 
        
        var temp2 = url.split('utente');        
        if(temp2.length > 1){            
            //lavoro sui container sottostanti
            $('.tab-content div').removeClass('in');
            $('.tab-content div').removeClass('active');

            $('#utente').addClass('in active');
            $('.container-admin li').removeClass('active');
            $('.container-admin li').each(function(){
                if($(this).data('name') === 'utente'){
                    $(this).addClass('active');
                }
            });
        }
        
        var temp = url.split('#');
        if(temp.length > 1){
            
            //lavoro sui container sottostanti
            $('.tab-content div').removeClass('in');
            $('.tab-content div').removeClass('active');

            $('#'+temp[1]).addClass('in active');
            $('.container-admin li').removeClass('active');
            $('.container-admin li').each(function(){
                if($(this).data('name') === temp[1]){
                    $(this).addClass('active');
                }
            });
        }
    }
    
    //ADD FILE
    $('.add-file').click(function(){
        //conto i container file
        var n = $('.container-file').length;
        //copio il container file
        var $newContainerFile = $('.container-file:first-child').clone();
        
        $newContainerFile.find('.counterable').each(function(){
            $(this).attr('name', $(this).attr('name')+'-'+n);
            $(this).val('');
        });
        
        $newContainerFile.appendTo('.container-files');
        
    });
    
    
});
