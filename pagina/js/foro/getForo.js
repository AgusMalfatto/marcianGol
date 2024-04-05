function getForo(idButton) {
	return new Promise(function (resolve, reject) {
		var settings = {
			"url": "../../php/foro/getForo.php",
			"method": "GET",
			"timeout": 0,
            "data": {id_foro: idButton}
		};

		$.ajax(settings).done(function (response) {
			resolve(response);
		}).fail(function (jqXHR, textStatus, errorThrown) {
			reject(errorThrown);
		});
	});
}

function fillDataForo(name, description, image_url, league) {
    var divTitle = $('<h2 class="title_foro">' + name + '</h2>');
    
    console.log(divTitle);
    console.log(name);
    divTitle.appendTo('#div_foro_title');                   
}

// Función para crear un nuevo comentario
function crearNuevoComentario(autor, contenido) {
    var nuevoComentario = $('<div class="comment">' +
                            '<div class="author">' + autor + '</div>' +
                            '<div class="content">' + contenido + '</div>' +
                            '</div>');
    return nuevoComentario;
}

$(document).ready(function () {

    // Agregar event listener al contenedor para escuchar clicks en botones
    $('#foros_div').on('click', 'a', function(event) {

        var idButton = $(this).attr('id');
        
        getForo(idButton).then(function (foros) {
            if (foros != null) {
                var objForo = JSON.parse(foros);
                console.log(objForo);
                console.log(objForo.data[0].name);
                fillDataForo(objForo.data[0].name, objForo.data[0].description, objForo.data[0].image_url, objForo.data[0].league);
                //fillForo(objForo);
    
            } else {
                console.log("Nop");
            }
        }).catch(function (error) {
            console.error("Error al obtener foros:", error);
        }); 
    });
  
});