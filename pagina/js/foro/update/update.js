function deactivateForo(idForo, nameForo, location) {
	return new Promise(function (resolve, reject) {
		$.ajax({
            url: "../../php/foro/deactivateForo.php", // URL del script PHP que manejará la solicitud
            type: "POST", // Método de envío de la solicitud
            data: {id_foro: idForo}, // Datos a enviar
            success: function(response) {

                try {
                    response = JSON.parse(response);
                } catch (error) {
                    response.success = false;
                }
                
                if (response.success) {

                    $("#avisoModalLabel").text("Foro Desactivado");
                    document.getElementById("avisoTexto").textContent = "Se desactivó correctamente el foro: '" + nameForo + "'.";
                    
                    // Evento que se dispara cuando el modal se cierra
                    $('#confirmModal').on('hidden.bs.modal', function () {
                        // Redireccionar una vez que el modal se haya cerrado
                        window.location.href = location;
                    });
                } else {
                    $("#avisoModalLabel").text("Error al modificar");
                    document.getElementById("avisoTexto").textContent = "Lo siento, hubo un error al desactivar el foro. Contáctese con soporte";
                }

                $('#confirmModal').modal('show');
                $('#deactivateModal').modal('hide');
            },
            error: function(xhr, status, error) {
                // Acciones a realizar en caso de error
                console.log("Error en la solicitud AJAX:", error);
            }
        });
	});
}
