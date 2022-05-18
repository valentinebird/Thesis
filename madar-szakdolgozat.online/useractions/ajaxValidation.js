

$(document).ready(function(){
  $("#checkValidation").click(function(){
    //let username = $("#userEmail").val().trim();
    let username = $("#username").val() == undefined ? '' : $("#username").val().trim();



    //let password = $("#userPassword").val().trim();
    let password = $("#password").val() == undefined ? '' : $("#password").val().trim();

    $.ajax({
      url:'showData.php',
      type:'post',
      data:{username:username,password:password},
      success:function(response){
        $("#message").html(response);
      }
    });
  });
});