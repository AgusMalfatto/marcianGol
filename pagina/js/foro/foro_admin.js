


// Function to create the rows
function crearFila(datos) {
    var imageForo = datos.photo.split("/");
    var imageForo = imageForo.pop();
    var imageForo = imageForo.split(".")[0];

    var id_deactivate_btn = "deactivate_btn_" + datos.id_foro;
    var id_modify_btn = "modify_btn_" + datos.id_foro;

    // Creating rows
    var row = $("<tr>");
    row.append("<td>" + datos.id_foro + "</td>");
    row.append("<td>" + datos.name + "</td>");
    row.append("<td>" + datos.description + "</td>");
    row.append("<td>" + imageForo + "</td>");
    row.append("<td>" + datos.league_description + "</td>");
    row.append("<td>" + datos.date_creation + "</td>");
    row.append("<td>" + datos.active + "</td>");
    
    if (datos.active === 1) {
        row.append('<td><button class="btn-deactivate btn btn-danger" id="' + id_deactivate_btn + '">Desactivar</button></td>');
        row.append('<td><button type="button" class="btn-modify btn btn-primary" id="' + id_modify_btn + '" data-toggle="modal" data-target="#modifyForoModal">Modificar</button></td>');
        row.append('<td><a href="showForo.php?id=' + datos.id_foro + '" type="button" class="btn-modify btn btn-primary" id="' + id_modify_btn + '">Ver Foro</a></td>');
    } else {
        row.append('<td><button class="btn btn-danger disabled">Desactivar</button></td>');
        row.append('<td><button class="btn-modify btn btn-primary disabled">Modificar</button></td>');
        row.append('<td><button class="btn-modify btn btn-primary disabled">Ver Foro</button></td>');
    }
    
    return row;
}

// Function to fill the modify form with the foro information
function fillModifyForm(foro) {

    $("#idModifyForo").val(foro.id_foro);
    $("#nameModifyForo").val(foro.name);
    $("#descriptionMofidyForo").val(foro.description);
    $("#imageModifyForo").val(foro.team);
    $("#leagueModifyForo").val(foro.league);

}


$(document).ready(function() {
    completeImageSelect();
    completeLeagueSelect();

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

    $("#idModifyForo").prop('disabled', true);
    // Display modify modal
    $(document).on("click", ".btn-modify", function() {
        
        var modify_btn = $("#modifyBtn");
        var confirmModifyBtn = $("#confirmModifyBtn");

        // Get the ID of the foro clicked
        var id_foro_modify = $(this).attr("id");
        id_foro_modify = id_foro_modify.split("_");
        id_foro_modify = id_foro_modify[id_foro_modify.length - 1];

        var fila = $(this).closest('tr');
        var foro_data = {
            id_foro: id_foro_modify,
            name: fila.find('td:eq(1)').text(),
            description: fila.find('td:eq(2)').text(),
            team: fila.find('td:eq(3)').text(),
            league: fila.find('td:eq(4)').text(),
        }

        fillModifyForm(foro_data);
        $('#modifyForoModal').modal('show');

        modify_btn.on("click", function() {
            var idForo = $("#idModifyForo").val();
            var nameForo = $("#nameModifyForo").val();
            var descriptionForo = $("#descriptionMofidyForo").val();
            var imageForo = $("#imageModifyForo").val();
            var leagueForo = $("#leagueModifyForo").val();
    
            
            if(validateName(nameForo) && validateDescription(descriptionForo)) {
                $('#modifyModal').modal('show');
            }
        });
        
        confirmModifyBtn.on("click", function() {
            var idForo = $("#idModifyForo").val();
            var nameForo = $("#nameModifyForo").val();
            var descriptionForo = $("#descriptionMofidyForo").val();
            var imageForo = $("#imageModifyForo").val();
            var leagueForo = $("#leagueModifyForo").val();
    
            modifyForo(idForo, nameForo, descriptionForo, imageForo, leagueForo, foro_data.name);  
        });
    });
    
    // Display deactive modal
    $(document).on("click", ".btn-deactivate", function() {
        // Get the ID of the foro clicked
        var id_foro_modify = $(this).attr("id");
        id_foro_modify = id_foro_modify.split("_");
        id_foro_modify = id_foro_modify[id_foro_modify.length - 1];
        id_foro = id_foro_modify;

        var fila = $(this).closest('tr');
        var nameForo = fila.find('td:eq(1)').text();
        
        $('#deactivateModal').modal('show');

        $("#confirmDeactivateBtn").on("click", function() {
            deactivateForo(id_foro, nameForo, "foro_admin.php");
        })
    })

    
});