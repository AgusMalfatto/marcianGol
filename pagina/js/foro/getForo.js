function getForo() {
	return new Promise(function(resolve, reject) {
		var settings = {
		"url": "../../php/foro/getForo.php",
		"method": "GET",
		"timeout": 0,
		};

		$.ajax(settings).done(function(response) {
			resolve(response);
		}).fail(function(jqXHR, textStatus, errorThrown) {
			reject(errorThrown);
		});
	});
}

function createForoCard(nombre, descripcion, imagenUrl) {
    // Create tags
    var cardDiv = document.createElement('div');
    cardDiv.classList.add('card', 'm-3');
    cardDiv.style.width = '18rem';

    var img = document.createElement('img');
    img.src = imagenUrl;
    img.classList.add('card-img', 'card-img-top');
    img.alt = '...';

    var cardBodyDiv = document.createElement('div');
    cardBodyDiv.classList.add('card-body');

    var title = document.createElement('h5');
    title.classList.add('card-title');
    title.textContent = nombre;

    var description = document.createElement('p');
    description.classList.add('card-text');
    description.textContent = descripcion;

    var enlace = document.createElement('a');
    enlace.href = "showForo.php";
    enlace.target = '_blank';
    enlace.rel = 'noopener noreferrer';
    enlace.classList.add('btn-card', 'btn', 'btn-primary');
    enlace.textContent = 'Entrar';

    // joining elements
    cardBodyDiv.appendChild(title);
    cardBodyDiv.appendChild(description);
    cardBodyDiv.appendChild(enlace);

    cardDiv.appendChild(img);
    cardDiv.appendChild(cardBodyDiv);

    return cardDiv;
  }

function fillForos(foros) {

	var sectionForo = $("#foros_div");

	foros.data.forEach(foro => {
		var newCard = createForoCard(foro.name, foro.description, foro.photo);
		sectionForo.append(newCard);
	}); 
	  
}

$(document).ready(function() {
	getForo().then(function(foros) {
		if (foros != null) {
			var objForos = JSON.parse(foros);
			fillForos(objForos);
		} else {
			console.log("Nop");
		}
	}).catch(function(error) {
		console.error("Error al obtener foros:", error);
	});
});
