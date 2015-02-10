
$(function(){
    $(".submenu").click(function(){

            if($(this).find('.folder').text()=='+'){
                $(this).find('.folder').text('-');
                $(this).css('background-color','#FAD3D3');
                $(this).next().hide();
            }else{
                $(this).find('.folder').text('+');
                $(this).css('background-color','#fff');
                $(this).next().show();
            }

         })
    })

