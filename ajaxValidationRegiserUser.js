$(document).ready(function () {
    $("#register").click(function () {
        let username = $("#username").val() == undefined ? '' : $("#username").val().trim();
        let email = $("#email").val() == undefined ? '' : $("#email").val().trim();
        let password = $("#password").val() == undefined ? '' : $("#password").val().trim();
        let password_re = $("#password_re").val() == undefined ? '' : $("#password_re").val().trim();

        $.ajax({
            url: 'register_user.php',
            type: 'post',
            data: {username: username, email: email, password: password, password_re: password_re},


            success: function (response) {
                if (response === '1') {
                    location.replace("index.php")
                } else {
                    $("#message").html(response);
                }

            }

        });
    });
});