function destroySession() {
    $.ajax({
        url: "../../php/session/destroySession.php",
        type: "POST",
        success: function(response) {
            window.location.href = "../../design/user/login.php";
        },
        error: function(xhr, status, error) {
            // Acciones a realizar en caso de error
            console.log("Error en la solicitud AJAX:", error);
        }
    });
}

function deactivateUser() {
	return new Promise(function (resolve, reject) {
		$.ajax({
            url: "../../php/user/deactivateUser.php",
            type: "POST",
            datatype: JSON,
            success: function(response) {
                try {
                    response = JSON.parse(response);
                } catch (error) {
                    response.success = false;
                }
                console.log(response.success);

                if (response.success) {

                    $("#confirmModalLabel").text("Cuenta desactivada");
                    $("#confirmModalText").text("Sus fue desactivada exitosamente.");
                    $("#confirmModal").modal("show");

                    // Evento que se dispara cuando el modal se cierra
                    $('#confirmModal').on('hidden.bs.modal', function () {
                        destroySession();
                    });
                } else {

                    $("#confirmModalLabel").text("Error al desactivar");
                    $("#confirmModalText").text("Lo siento, hubo un error al desactivar su cuenta. Contáctese con soporte.");
                    $("#confirmModal").modal("show");

                }
            },
            error: function(xhr, status, error) {
                // Acciones a realizar en caso de error
                console.log("Error en la solicitud AJAX:", error);
            }
        });
	});
}


function modifyUser(nameUser, lastname, team) {
    var data = {
        name: nameUser,
        last_name: lastname,
        team_name: team
    }
    return new Promise(function (resolve, reject) {
		$.ajax({
            url: "../../php/user/modifyUser.php",
            type: "POST",
            datatype: JSON,
            data: JSON.stringify(data), 
            success: function(response) {
                try {
                    response = JSON.parse(response);
                } catch (error) {
                    response.success = false;
                }

                if (response.success) {

                    $("#confirmModalLabel").text("Datos Modificados");
                    $("#confirmModalText").text("Sus datos se modificaron correctamente.");
                } else {

                    $("#confirmModalLabel").text("Error al modificar");
                    $("#confirmModalText").text("Lo siento, hubo un error al modificar sus datos. Contáctese con soporte.");
                }
                
                $('#confirmModal').modal('show');
                $('#confirmQuestion').modal('hide');
                
                // Evento que se dispara cuando el modal se cierra
                $('#confirmModal').on('hidden.bs.modal', function () {
                    // Recargar una vez que el modal se haya cerrado
                    location.reload();
                });
            },
            error: function(xhr, status, error) {
                // Acciones a realizar en caso de error
                console.log("Error en la solicitud AJAX:", error);
            }
        });
	});
}
