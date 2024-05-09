// Ajax to complete the team select (foro image)
function completeImageSelect() {
    $.ajax({
        url: "../../php/team/getNameTeam.php",
        type: "GET",
        dataType: "json",
        success: function(response) {
            fillImageSelect(response);
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud:", error);
        }
    });
}

// Function to complete the team select
function fillImageSelect(response) {
    var selectElement = $("#imageCreateForo");

    // Itera sobre los datos y crea opciones dinámicamente
    $.each(response.data, function(index, team) {
        var optionElement = $("<option></option>")
            .attr("value", team.name)
            .text(team.name);
        selectElement.append(optionElement);
    });
}

// Ajax to complete the team select (foro image)
function completeLeagueSelect() {
    $.ajax({
        url: "../../php/league/getNameLeague.php",
        type: "GET",
        dataType: "json",
        success: function(response) {
            fillLeagueSelect(response);
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud:", error);
        }
    });
}

// Function to complete the team select
function fillLeagueSelect(response) {
    var selectElement = $("#leagueCreateForo");

    // Itera sobre los datos y crea opciones dinámicamente
    $.each(response.data, function(index, team) {
        var optionElement = $("<option></option>")
            .attr("value", team.description)
            .text(team.description);
        selectElement.append(optionElement);
    });
}

// Ajax to save the new foro in database
function saveForo(nameForo, descriptionForo, imageForo, leagueForo) {
    $.ajax({
        url: "../../php/foro/createForo.php",
        type: "POST",
        dataType: "json",
        data: {
            photo: imageForo,
            name: nameForo,
            description: descriptionForo,
            name_league: leagueForo
        },
        success: function(response) {
            fillImageSelect(response);
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud:", error);
        }
    });
}


// Returns true if the name of the foro is correct
function validateName(nameForo) {
    nameForo = nameForo.trim();

    if (nameForo === "" || /^\s+$/.test(nameForo)) {
        $("#confirmModalLabel").text("Error en Nombre");
        $("#confirmModalText").text("No se admite un nombre vacío.");
        $('#confirmModal').modal('show');
        $("#nameCreateForo").addClass('border border-danger border-2');

        return false;
    }

    if (nameForo.length > 50) {
        $("#confirmModalLabel").text("Error en Nombre");
        $("#confirmModalText").text("El nombre del foro no debe superar los 50 caracteres.");
        $('#confirmModal').modal('show');
        $("#nameCreateForo").addClass('border border-danger border-2');

        return false;
    }

    $("#nameCreateForo").removeClass('border border-danger border-2');

    return true;
}

// Returns true if the description of the foro is correct
function validateDescription(descriptionForo) {
    descriptionForo = descriptionForo.trim();

    if (descriptionForo === "" || /^\s+$/.test(descriptionForo)) {
        $("#confirmModalLabel").text("Error en descripción");
        $("#confirmModalText").text("No se admite una descripción vacía.");
        $('#confirmModal').modal('show');
        $("#descriptionCreateForo").addClass('border border-danger border-2');

        return false;
    }

    if (descriptionForo.length > 150) {
        $("#confirmModalLabel").text("Error en descripción");
        $("#confirmModalText").text("La descripción del foro no debe superar los 150 caracteres.");
        $('#confirmModal').modal('show');
        $("#descriptionCreateForo").addClass('border border-danger border-2');

        return false;
    }

    $("#descriptionCreateForo").removeClass('border border-danger border-2');

    return true;
}


function cleanForm() {
    $("#nameCreateForo").val("");
    $("#nameCreateForo").removeClass('border border-danger border-2');

    $("#descriptionCreateForo").val("");
    $("#descriptionCreateForo").removeClass('border border-danger border-2');

    $("#imageCreateForo").val($("#imageCreateForo option:first").val());
    $("#leagueCreateForo").val($("#leagueCreateForo option:first").val());
}


$(document).ready(function () {
    completeImageSelect();
    completeLeagueSelect();
        
    var createForoButton = $("#createForoButton");
    var cleanFormButton = $("#cleanCreateFormButton");

    createForoButton.on("click", function() {
        var nameForo = $("#nameCreateForo").val();
        var descriptionForo = $("#descriptionCreateForo").val();
        var imageForo = $("#imageCreateForo").val();
        var leagueForo = $("#leagueCreateForo").val();

        if(validateName(nameForo) && validateDescription(descriptionForo)) {

            saveForo(nameForo, descriptionForo, imageForo, leagueForo);  
            $("#confirmModalLabel").text("Foro Creado");
            $("#confirmModalText").text("Se ha creado el foro correctamente.");
            $('#confirmModal').modal('show');
            
            cleanForm();
        }
    });

    cleanFormButton.on("click", function() {
        cleanForm();
    });

});