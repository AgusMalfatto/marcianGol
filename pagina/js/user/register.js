$(document).ready(function () {
    var singUpForm = document.getElementById("singUpForm");

    var loginBtn = document.getElementById("loginBtn");
    var registerBtn = document.getElementById("registerBtn");
    

    var email = document.getElementById("email");
    var password = document.getElementById("password");


    registerBtn.disabled = true;




    singUpForm.onkeyup = function () {

        if (email.value !== "" && password.value !== "") {
            registerBtn.disabled = false;

        } else {
            registerBtn.disabled = true;

        }
    };

    $('#registerBtn').click(function (event) {
        // event.preventDefault();

        // var loginForm = new FormData($('#loginForm')[0]);
        // var objAjax = $.ajax({
        //     type: "post",
        //     url: "../../php/session/processLogin.php",
        //     enctype: 'multipart/form-data',

        //     data: {

        //         email: email.value,
        //         password: password.value
                

        //     },
        //     success: function (respuestaDelServer) {
                
        //     }

        // });

    });

    $('#loginBtn').click(function (event) {
        event.preventDefault();

        window.location.href = "login.php";

    });


});
