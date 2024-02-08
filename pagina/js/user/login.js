$(document).ready(function () {
    var loginForm = document.getElementById("loginForm");

    var loginBtn = document.getElementById("loginBtn");
    var registerBtn = document.getElementById("registerBtn");
    var forgotPassBtn = document.getElementById("forgotPassBtn");

    var email = document.getElementById("email");
    var password = document.getElementById("password");


    loginBtn.disabled = true;




    loginForm.onkeyup = function () {

        if (email.value !== "" && password.value !== "") {
            loginBtn.disabled = false;

        } else {
            loginBtn.disabled = true;

        }
    };

    $('#loginBtn').click(function (event) {
        event.preventDefault();

        var loginForm = new FormData($('#loginForm')[0]);
        var objAjax = $.ajax({
            type: "post",
            url: "../../php/session/processLogin.php",
            enctype: 'multipart/form-data',

            data: {

                email: email.value,
                password: password.value
            },
            success: function (respuestaDelServer) {
                
            }

        });

    });

    $('#registerBtn').click(function (event) {
        event.preventDefault();

        window.location.href = "register.html";

    });


});
