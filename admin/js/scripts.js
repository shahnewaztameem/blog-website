tinymce.init({selector:'textarea'});


//select all checkboxes
$(document).ready(function(){
   $('#selectAllBoxex').click(function(event){
     if(this.checked){
         $('.checkBoxes').each(function(){
             this.checked = true;
         });
     }
    else{
        $('.checkBoxes').each(function(){
             this.checked = false;
        });
    }
   });
    //load animations
    var div_box = "<div id='load-screen'><div id='loading'></div></div>";
    $("body").prepend(div_box);
    $('#load-screen').delay(700).fadeOut(600,function(){
       $(this).remove(); 
    });
    
});

//load online users
function loadOnlineUsers() {
    $.get("functions.php?onlineusers=result",function(data){
        $(".users-online").text(data);
    });
}
setInterval(function(){
    loadOnlineUsers();
},300);

