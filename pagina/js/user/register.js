$(document).ready(function () {

    // vacio las opciones del select de eleccion de equipo
    $("#team_name").empty();
    $("#errorMessage").empty();
    $("#errorMessage").addClass("oculto");

    // al cargar la pagina traigo las opciones de equipos para el select
    $.ajax({
        url: '../../php/team/getNameTeam.php',
        type: 'POST',


        success: function (respuesta) {

            var objOption0 = document.createElement("option");
            objOption0.setAttribute("value", "0");
            objOption0.innerHTML = "Seleccione su equipo";
            document.getElementById("team_name").appendChild(objOption0);


            objJson = JSON.parse(respuesta);
            objJson.data.forEach(function (teamName) {
                var objOpcion = document.createElement("option");
                objOpcion.setAttribute("value", teamName.name);
                objOpcion.innerHTML = teamName.name;
                document.getElementById("team_name").appendChild(objOpcion);
            })
        }, error: function (error) {
            console.log(error);
        }
    });




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

        if (!validarEmail(email.value)) {
            $("#errorMessage").empty();
            $("#errorMessage").text("El email no es correcto"); // Establecer el contenido del mensaje de error
            $("#errorMessage").removeClass("oculto");

        } else if (password.value !== confirmPassword.value) {
            $("#errorMessage").empty();
            $("#errorMessage").text("Las contraseñas no coinciden");
            $("#errorMessage").removeClass("oculto");

        } else if (!validarContraseña(password.value)) {
            $("#errorMessage").empty();
            $("#errorMessage").text("La contraseña no cumple con lo requerido: debe contener 1 mayuscula, 1 minuscula, un numero y la menos 8 caracteres");
            $("#errorMessage").removeClass("oculto");

        } else if (name.value === "") {
            $("#errorMessage").empty();
            $("#errorMessage").text("El campo nombre esta vacio");
            $("#errorMessage").removeClass("oculto");

        } else if (lastName.value === "") {
            $("#errorMessage").empty();
            $("#errorMessage").text("El campo apellido esta vacio");
            $("#errorMessage").removeClass("oculto");

        } else if (teamName.value === "0") {
            $("#errorMessage").empty();
            $("#errorMessage").text("Seleccione su equipo de preferencia");
            $("#errorMessage").removeClass("oculto");

        } else {

            var datosSingUpForm = $('#singUpForm').serialize();

            var objAjax = $.ajax({
                type: "post",
                url: "../../php/user/registerUser.php",
                data: datosSingUpForm,
                success: function (respuesta) {
                    var data = JSON.parse(respuesta);
                    if (data.success == true) {
                        
                        window.location.href = "../../design/user/login.php";
                    } else {
                        $("#errorMessage").empty();
                        $("#errorMessage").text(data.message);
                        $("#errorMessage").removeClass("oculto");
                    }

                }, error: function (error) {
                    console.log(error);
                }

            });


        }

    });



});

$('#loginBtn').click(function (event) {
    event.preventDefault();

    window.location.href = "login.php";

});


function validarContraseña(contraseña) {
    // Expresión regular para validar que la contraseña tenga al menos una mayúscula, una minúscula y un número
    var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
    return regex.test(contraseña);
};

function validarEmail(email) {
    // Expresión regular para validar direcciones de correo electrónico
    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
};

