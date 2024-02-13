$(document).ready(function () {
    $("#team_name").empty();
    var objOption0 = document.createElement("option");
    objOption0.setAttribute("value", "0");
    objOption0.innerHTML = "Seleccione su equipo";
    document.getElementById("team_name").appendChild(objOption0);

    var objOption1 = document.createElement("option");
    objOption1.setAttribute("value", "Arsenal");
    objOption1.innerHTML = "Arsenal";
    document.getElementById("team_name").appendChild(objOption1);

    // --------------

    var singUpForm = document.getElementById("singUpForm");

    var loginBtn = document.getElementById("loginBtn");
    var registerBtn = document.getElementById("registerBtn");


    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var confirmPassword = document.getElementById("confirmPassword");
    var name = document.getElementById("name");
    var lastName = document.getElementById("last_name");
    var teamName = document.getElementById("team_name");

    

    

    registerBtn.disabled = true;

    singUpForm.onkeyup = function () {

        if (teamName.value !== 0 && email.value !== "" && password.value !== "" && confirmPassword.value !== ""
            && name.value !== "" && lastName.value !== "") {
            registerBtn.disabled = false;
            

        } else {
            registerBtn.disabled = true;

        }
    };

    $('#registerBtn').click(function (event) {
        event.preventDefault();
        var datosSingUpForm = $('#singUpForm').serialize();

        var objAjax = $.ajax({
            type: "post",
            url: "../../php/user/registerUser.php",
            data: datosSingUpForm,
            success: function (respuesta) {
                var data = JSON.parse(respuesta);
                if (data.success == true) {
                    alert("aka estoi, se registro bien la concha de tu madre 8=D");
                    
                    window.location.href = "../../design/user/login.php";
                } else {
                    alert("Login failed. Please check your credentials.");
                }

            }, error: function (error) {
                console.log(error);
            }

        });

    });

    $('#loginBtn').click(function (event) {
        event.preventDefault();

        window.location.href = "login.php";

    });


});
