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
    var selectElement = $("#team_user");

    // Itera sobre los datos y crea opciones dinámicamente
    $.each(response.data, function(index, team) {
        var optionElement = $("<option></option>")
            .attr("value", team.name)
            .text(team.name);
        selectElement.append(optionElement);
    });

    
    getUser().then(function (user) {
        if (user != null) {
            var objUser = JSON.parse(user);
            console.log(objUser);
            fillUserForm(objUser);
            

        } else {
            console.log("Nop");
        }
    }).catch(function (error) {
        console.error("Error al obtener foros:", error);
    });
}

function getUser() {
    return new Promise(function (resolve, reject) {
		var settings = {
			"url": "../../php/user/getUser.php",
			"method": "GET",
			"timeout": 0,
            "datatype": JSON
		};

		$.ajax(settings).done(function (response) {
			resolve(response);
		}).fail(function (jqXHR, textStatus, errorThrown) {
			reject(errorThrown);
		});
	});
}

function fillUserForm(user) {
    var team = user.photo;
    console.log(user.name);
    team = team.split("/");
    team = team.pop();
    team = team.split(".")[0]
    console.log(team);

    $("#id_user").val(user.id_user);
    $("#name_user").val(user.name);
    $("#lastname_user").val(user.last_name);
    $("#email_user").val(user.email);
    $("#team_user").val(team);
}

$(document).ready(function() {
    // '0' if the use is going to deactivate the foro, '1' if the user is going to modify.
    var flag;

    $("#id_user").prop("disabled", true);
    $("#email_user").prop("disabled", true);
    completeImageSelect();


    $("#send_dataUser_btn").on("click", function() {
        flag = 1;

        var nameUser = $("#name_user").val();
        var lastnameUser = $("#lastname_user").val();
        var team = $("#team_user").val()

        if (validateName(nameUser, "name_user", "nombre") && validateName(lastnameUser, "lastname_user", "apellido")) {
            $("#questionModalLabel").text("Modificar Datos");
            $("#questionModalText").text("¿Desea modificar sus datos?");
            $("#confirmQuestion").modal("show");
        }

        $("#confirmQuestionBtn").on("click", function() {
            if (flag === 1) {
                modifyUser(nameUser, lastnameUser, team);
            }
        })
    })

    $("#send_deactivateUser_btn").on("click", function() {
        flag = 0;
        
        $("#questionModalLabel").text("Desactivate Cuenta");
        $("#questionModalText").text("¿Desea desactivar su cuenta?");
        $("#confirmQuestion").modal("show");

        $("#confirmQuestionBtn").on("click", function() {
            if (flag === 0) {
                deactivateUser();
            }
        })
    })

})