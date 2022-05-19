$(document).ready(function(){
    $("#checkValidation").click(function(){
        //let username = $("#userEmail").val().trim();
        let username = $("#username").val() == undefined ? '' : $("#username").val().trim();



        //let password = $("#userPassword").val().trim();
        let password = $("#password").val() == undefined ? '' : $("#password").val().trim();

        $.ajax({
            url:'authenticate.php',
            type:'post',
            data:{username:username,password:password},

            success:function(response){
                if(response==='1'){
                    location.replace("index.html")
                }else{
                    $("#message").html(typeof(response));
                }


            }




        });
    });
});