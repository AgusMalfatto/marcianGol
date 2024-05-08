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

// Ajax to get the foro with idButton from database
function getForo(idForo) {
	return new Promise(function (resolve, reject) {
		var settings = {
			"url": "../../php/foro/getForo.php",
			"method": "GET",
			"timeout": 0,
            "data": {id_foro: idForo}
		};

		$.ajax(settings).done(function (response) {
			resolve(response);
		}).fail(function (jqXHR, textStatus, errorThrown) {
			reject(errorThrown);
		});
	});
}

// Ajax to get all the active comments of the foro (idForo)
function getComment(idForo) {
    return new Promise(function (resolve, reject) {
		var settings = {
			"url": "../../php/comment/getComment.php",
			"method": "GET",
			"timeout": 0,
            "data": {id_foro: idForo}
		};

		$.ajax(settings).done(function (response) {
			resolve(response);
		}).fail(function (jqXHR, textStatus, errorThrown) {
			reject(errorThrown);
		});
	});
}

// Filling the template with the foro data
function fillDataForo(nameForo, description, image_url, league, id_foro) {

    // Append the elements to DOM
    $("#foro_image").attr("src", image_url);
    $("#foro_name").text(nameForo);
    $("#foro_description").text(description);
    $("#foro_league").text(league);
    $("#id_foro").text(id_foro);
}

// Create comment card and add to the DOM
function createCommentCard(comment) {

    /* Creating contents cards */
    var commentCard = document.createElement('div');
    commentCard.classList.add('card', 'm-3', 'content');

    var userNameCard = document.createElement('div');
    userNameCard.classList.add('card', 'm-3', 'author');

    var contentCard = document.createElement('div');
    contentCard.classList.add('card', 'm-3');

    var likesCard = document.createElement('div');
    likesCard.classList.add('card', 'm-3');

    /* Creating info tags */
    var nameTag = document.createElement('h5');
    nameTag.classList.add('card-title');
    nameTag.textContent = comment.name + ", " + comment.last_name + " | " + comment.date_comment;
    
    var contentTag = document.createElement('p');
    contentTag.classList.add('card-text');
    contentTag.textContent = comment.description;

    var likesTag = document.createElement('p');
    likesTag.classList.add('card-text');
    likesTag.textContent = comment.Likes;
    var likesIcon = document.createElement('i');
    likesIcon.classList.add('las', 'la-thumbs-up');

    /* Append */
    userNameCard.appendChild(nameTag);
    contentCard.appendChild(contentTag);
    likesCard.appendChild(likesIcon);
    likesCard.appendChild(likesTag);

    commentCard.appendChild(userNameCard);
    commentCard.appendChild(contentCard);
    commentCard.appendChild(likesCard);

    document.getElementById('content-comment').appendChild(commentCard);
}


$(document).ready(function () {
    completeImageSelect();
    completeLeagueSelect();

    $("#idModifyForo").prop('disabled', true);
        
    // Get the params from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const idButton = urlParams.get('id');

    // Filling the foro information
    getForo(idButton).then(function (foros) {
        if (foros != null) {
            var objForo = JSON.parse(foros);
            fillDataForo(objForo.data[0].name, objForo.data[0].description, objForo.data[0].photo, objForo.data[0].league_description, objForo.data[0].id_foro);

        } else {
            console.log("Nop");
        }
    }).catch(function (error) {
        console.error("Error al obtener foros:", error);
    }); 


    // Filling the comment section
    getComment(idButton).then(function (comments) {
        if (comments != null) {
            var objComment = JSON.parse(comments);

            /* Creating cards for each comment */
            objComment.data.forEach(comment => {
                createCommentCard(comment);
            })
        } else {
            console.log("Error");
        }
    }).catch(function (error) {
        console.error("Error al obtener foros:", error);
    }); 

});