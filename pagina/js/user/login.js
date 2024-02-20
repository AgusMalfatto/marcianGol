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
        var datosLoginForm = $('#loginForm').serialize();

        var objAjax = $.ajax({
            type: "post",
            url: "../../php/session/processLogin.php",
            data: datosLoginForm,
            success: function (respuesta) {
                var data = JSON.parse(respuesta);
                alert(data.success);
                if (data.success == true) {
                    alert("ENTRAMOSSSS");
                    window.location.href = "../../design/foro/home.php";
                }else{
                    alert("Login failed. Please check your credentials.");
                }
                
            }

        });

    });

    $('#registerBtn').click(function (event) {
        event.preventDefault();

        window.location.href = "register.html";

    });


});
