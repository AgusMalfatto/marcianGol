function deactivateForo(idForo) {
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
                    document.getElementById("avisoTexto").textContent = "Se desactivó correctamente el foro.";
                    
                    // Evento que se dispara cuando el modal se cierra
                    $('#confirmModal').on('hidden.bs.modal', function () {
                        // Redireccionar una vez que el modal se haya cerrado
                        window.location.href = 'foro_admin.php';
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

// Función para crear una fila de la tabla
function crearFila(datos) {
    var imageForo = datos.photo.split("/");
    var imageForo = imageForo.pop(); // Obtiene la última parte del array, que es el nombre del archivo con la extensión
    var imageForo = imageForo.split(".")[0];

    var id_deactivate_btn = "deactivate_btn_" + datos.id_foro;
    var id_modify_btn = "modify_btn_" + datos.id_foro;

    var fila = $("<tr>");
    fila.append("<td>" + datos.id_foro + "</td>");
    fila.append("<td>" + datos.name + "</td>");
    fila.append("<td>" + datos.description + "</td>");
    fila.append("<td>" + imageForo + "</td>");
    fila.append("<td>" + datos.league_description + "</td>");
    fila.append("<td>" + datos.date_creation + "</td>");
    fila.append("<td>" + datos.active + "</td>");
    
    if (datos.active === 1) {
        fila.append('<td><button class="btn-deactivate btn btn-danger" id="' + id_deactivate_btn + '">Desactivar</button></td>');
        fila.append('<td><button type="button" class="btn-modify btn btn-primary" id="' + id_modify_btn + '" data-toggle="modal" data-target="#modifyForoModal">Modificar</button></td>');
        fila.append('<td><a href="showForo.php?id=' + datos.id_foro + '" type="button" class="btn-modify btn btn-primary" id="' + id_modify_btn + '">Ver Foro</a></td>');
    } else {
        fila.append('<td><button class="btn btn-danger disabled">Desactivar</button></td>');
        fila.append('<td><button class="btn-modify btn btn-primary disabled">Modificar</button></td>');
        fila.append('<td><button class="btn-modify btn btn-primary disabled">Ver Foro</button></td>');
    }
    
    return fila;
}

// Agregar filas a la tabla
$(document).ready(function() {
    var tableBody = $("#tabla-body");
    var id_foro;

    // Parameter = 1 so the function gets all the foros (actives and non-actives)
    getForo(1).then(function (foros) {
		if (foros != null) {
			var objForos = JSON.parse(foros);
			
			console.log(objForos);
            for (var i = 0; i < objForos.data.length; i++) {
                var fila = crearFila(objForos.data[i]);
                tableBody.append(fila);
            }

		} else {
			console.log("Nop");
		}
	}).catch(function (error) {
		console.error("Error al obtener foros:", error);
	});

    // Display modal modify foro
    $(document).on("click", ".btn-modify", function() {

        // Get the ID of the foro clicked
        var id_foro_modify = $(this).attr("id");
        id_foro_modify = id_foro_modify.split("_");
        id_foro_modify = id_foro_modify[id_foro_modify.length - 1];

        $('#modifyForoModal').modal('show');
    })
    
    $(document).on("click", ".btn-deactivate", function() {
        // Get the ID of the foro clicked
        var id_foro_modify = $(this).attr("id");
        id_foro_modify = id_foro_modify.split("_");
        id_foro_modify = id_foro_modify[id_foro_modify.length - 1];
        id_foro = id_foro_modify;
        
        $('#deactivateModal').modal('show');
    })

    $("#confirmDeactivateBtn").on("click", function() {
        deactivateForo(id_foro);
    })
    
});