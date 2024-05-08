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
                    var nameForo = document.getElementById('foro_name').textContent;

                    $("#avisoModalLabel").text("Foro Desactivado");
                    document.getElementById("avisoTexto").textContent = "Se desactivó correctamente el foro: '" + nameForo + "'.";
                    
                    // Evento que se dispara cuando el modal se cierra
                    $('#confirmModal').on('hidden.bs.modal', function () {
                        // Redireccionar una vez que el modal se haya cerrado
                        window.location.href = 'home.php';
                    });
                } else {
                    var nameForo = document.getElementById('foro_name').textContent;

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

// Returns true if the name of the foro is correct
function validateName(nameForo) {
    nameForo = nameForo.trim();

    if (nameForo === "" || /^\s+$/.test(nameForo)) {
        document.getElementById("avisoTexto").textContent = "No se admite un nombre vacío.";
        document.getElementById("avisoModalLabel").textContent = "Datos incorrectos";

        $('#confirmModal').modal('show');
        $("#nameModifyForo").addClass('border border-danger border-2');

        return false;
    }

    if (nameForo.length > 50) {
        document.getElementById("avisoTexto").textContent = "El nombre del foro no debe superar los 50 caracteres.";
        document.getElementById("avisoModalLabel").textContent = "Datos incorrectos";

        $('#confirmModal').modal('show');
        $("#nameModifyForo").addClass('border border-danger border-2');

        return false;
    }

    $("#nameModifyForo").removeClass('border border-danger border-2');

    return true;
}

// Returns true if the description of the foro is correct
function validateDescription(descriptionForo) {
    descriptionForo = descriptionForo.trim();

    if (descriptionForo === "" || /^\s+$/.test(descriptionForo)) {
        document.getElementById("avisoTexto").textContent = "No se admite una descripción vacía.";
        document.getElementById("avisoModalLabel").textContent = "Datos incorrectos";

        $('#confirmModal').modal('show');
        $("#descriptionMofidyForo").addClass('border border-danger border-2');

        return false;
    }

    if (descriptionForo.length > 50) {
        document.getElementById("avisoTexto").textContent = "La descripción del foro no debe superar los 150 caracteres.";
        document.getElementById("avisoModalLabel").textContent = "Datos incorrectos";

        $('#confirmModal').modal('show');
        $("#descriptionMofidyForo").addClass('border border-danger border-2');

        return false;
    }

    $("#descriptionMofidyForo").removeClass('border border-danger border-2');

    return true;
}


function modifyForo(idForo, nameForo, descriptionForo, imageForo, leagueForo) {
    var data = {
        id_foro: idForo,
        name: nameForo,
        description: descriptionForo,
        photo: imageForo,
        name_league: leagueForo
    }
    return new Promise(function (resolve, reject) {
		$.ajax({
            url: "../../php/foro/modifyForo.php",
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
                    var nameForo = document.getElementById('foro_name').textContent;

                    $("#avisoModalLabel").text("Foro Modificado");
                    document.getElementById("avisoTexto").textContent = "Se modificó correctamente el foro: '" + nameForo + "'.";
                } else {
                    var nameForo = document.getElementById('foro_name').textContent;

                    $("#avisoModalLabel").text("Error al modificar");
                    document.getElementById("avisoTexto").textContent = "Lo siento, hubo un error al modificar el foro. Contáctese con soporte";
                }
                
                $('#confirmModal').modal('show');
                $('#modifyForoModal').modal('hide');
                
                // Evento que se dispara cuando el modal se cierra
                $('#confirmModal').on('hidden.bs.modal', function () {
                    // Redireccionar una vez que el modal se haya cerrado
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


function fillModifyForm() {
    var nameForo = $("#foro_name").text();
    var descriptionForo = $("#foro_description").text();
    var imageForo = $("#foro_image").attr("src");
    var leagueForo = $("#foro_league").text();
    var idForo = $("#id_foro").text();

    var imageForo = imageForo.split("/");
    var imageForo = imageForo.pop(); // Obtiene la última parte del array, que es el nombre del archivo con la extensión
    var imageForo = imageForo.split(".")[0];
    
    $("#idModifyForo").val(idForo);
    $("#nameModifyForo").val(nameForo);
    $("#descriptionMofidyForo").val(descriptionForo);
    $("#imageModifyForo").val(imageForo);
    $("#leagueModifyForo").val(leagueForo);

}


$(document).ready(function () {
    
    var deactivateBtn = document.getElementById("confirmDeactivateBtn");
    var modify_foro = $("#modify_foro");
    var modify_btn = $("#modifyBtn");
    var confirmModifyBtn = $("#confirmModifyBtn");
    
    // Get the params from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const idForo = urlParams.get('id');
    
    
    deactivateBtn.addEventListener("click", function() {
        deactivateForo(idForo);
    });

    modify_foro.on("click", function() {
        fillModifyForm();
    })

    modify_btn.on("click", function() {
        var idForo = $("#idModifyForo").val();
        var nameForo = $("#nameModifyForo").val();
        var descriptionForo = $("#descriptionMofidyForo").val();
        var imageForo = $("#imageModifyForo").val();
        var leagueForo = $("#leagueModifyForo").val();

        
        if(validateName(nameForo) && validateDescription(descriptionForo)) {
            $('#modifyModal').modal('show');
        }
    })
    
    confirmModifyBtn.on("click", function() {
        var idForo = $("#idModifyForo").val();
        var nameForo = $("#nameModifyForo").val();
        var descriptionForo = $("#descriptionMofidyForo").val();
        var imageForo = $("#imageModifyForo").val();
        var leagueForo = $("#leagueModifyForo").val();

        modifyForo(idForo, nameForo, descriptionForo, imageForo, leagueForo);  
    })
    
}); 