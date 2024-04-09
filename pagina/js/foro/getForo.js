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
    console.log("getComment: " + idForo);
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
function fillDataForo(name, description, image_url, league) {
    // Creating the elements
    var img = document.createElement('img');
	img.src = image_url;
	img.classList.add('card-img', 'card-img-top');
	img.alt = '...';

    var title = $('<h2 class="title_foro">' + name + '</h2>');
    var text_description = $('<h4 class="card-text">' + description + '</h4>');
    var text_league = $('<h5 class="card-text">' + league + '</h5>');

    // Append the elements to DOM
    document.getElementById("div_img_content").appendChild(img);
    title.appendTo('#div_foro_title');
    text_description.appendTo('#div_foro_description');
    text_league.appendTo('#div_foro_league');
}

function createCommentCard(autor, contenido) {
    var nuevoComentario = $('<div class="comment">' +
                            '<div class="author">' + autor + '</div>' +
                            '<div class="content">' + contenido + '</div>' +
                            '</div>');
    return nuevoComentario;
}

$(document).ready(function () {
        
    // Get the params from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const idButton = urlParams.get('id');

    // Filling the foro information
    getForo(idButton).then(function (foros) {
        if (foros != null) {
            var objForo = JSON.parse(foros);
            console.log(objForo);
            console.log(objForo.data[0].name);
            fillDataForo(objForo.data[0].name, objForo.data[0].description, objForo.data[0].photo, objForo.data[0].league_description);

        } else {
            console.log("Nop");
        }
    }).catch(function (error) {
        console.error("Error al obtener foros:", error);
    }); 


    // Filling the comment section
    getComment(idButton).then(function (comments) {
        if (comments != null) {
            var objComments = JSON.parse(comments);

            console.log(objComments);
        } else {
            console.log("Nop");
        }
    }).catch(function (error) {
        console.error("Error al obtener foros:", error);
    }); 

});