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
    var selectElement = $("#imageModifyForo");

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
    var selectElement = $("#leagueModifyForo");

    // Itera sobre los datos y crea opciones dinámicamente
    $.each(response.data, function(index, team) {
        var optionElement = $("<option></option>")
            .attr("value", team.description)
            .text(team.description);
        selectElement.append(optionElement);
    });
}