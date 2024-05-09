// Ajax to get all the foros from database
function getForo(active = 0) {
	return new Promise(function (resolve, reject) {
		var settings;
		if (active === 0) {
			settings = {
				"url": "../../php/foro/getForo.php",
				"method": "GET",
				"timeout": 0,
			};
		} else {
			settings = {
				"url": "../../php/foro/getForo.php",
				"method": "GET",
				"timeout": 0,
				"data": {
					active_foro: active
				}
			};
		}


		$.ajax(settings).done(function (response) {
			resolve(response);
		}).fail(function (jqXHR, textStatus, errorThrown) {
			reject(errorThrown);
		});
	});
}

function createForoCard(id_foro, nombre, descripcion, imagenUrl, date_creation) {
	// Create tags
	var headDiv = document.createElement('div');


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
	enlace.href = "showForo.php?id=" + id_foro;
	enlace.rel = 'noopener noreferrer';
	// 'btn-foro-id' is used to manage the foros id between the htmls.
	enlace.classList.add('btn-card', 'btn', 'btn-primary', 'btn-foro-id');
	enlace.textContent = 'Entrar';


	// Calcular la fecha actual
	var fecha_actual = new Date();
	// Convertir la fecha de creación del foro a un objeto Date
	var fecha_creacion_foro = new Date(date_creation);
	// Calcular la diferencia en milisegundos
	var diferencia_tiempo = fecha_actual.getTime() - fecha_creacion_foro.getTime();
	// Convertir la diferencia en días
	var diferencia_dias = diferencia_tiempo / (1000 * 3600 * 24);


	// Si el foro se creó hoy, agrega el ícono "new"
	if (diferencia_dias <= 1) {
		var newIcon = document.createElement('span');
		newIcon.classList.add('badge', 'bg-success', 'rounded-pill');
		newIcon.textContent = 'NEW FORO';
		headDiv.appendChild(newIcon);
	}


	// joining elements
	cardDiv.appendChild(headDiv);
	cardBodyDiv.appendChild(title);
	cardBodyDiv.appendChild(description);
	cardBodyDiv.appendChild(enlace);

	cardDiv.appendChild(img);
	cardDiv.appendChild(cardBodyDiv);

	return cardDiv;
}

function createTrendForoCard(id_foro, nombre, descripcion, imagenUrl, date_creation) {
	// Create tags
	var cardDiv = document.createElement('div');
	cardDiv.classList.add('m-3', 'd-flex', 'justify-content-between', 'trend-card');
	cardDiv.style.width = '30%'; // Set cardDiv width to 60%

	var cardImgDiv = document.createElement('div');
	cardImgDiv.classList.add('col-md-4'); // Use Bootstrap grid classes for 4 columns

	var img = document.createElement('img');
	img.src = imagenUrl;
	img.classList.add('card-img', 'card-img-top');
	img.alt = '...';

	var cardContentDiv = document.createElement('div');
	cardContentDiv.classList.add('col-md-4'); // Use Bootstrap grid classes for 8 columns

	var cardBodyDiv = document.createElement('div');
	cardBodyDiv.classList.add('card-body');

	var title = document.createElement('h5');
	title.classList.add('card-title');
	title.textContent = nombre;

	var description = document.createElement('p');
	description.classList.add('card-text');
	description.textContent = descripcion;

	var date = document.createElement('p');
	date.classList.add('card-text');
	date.textContent = date_creation;

	var enlace = document.createElement('a');
	enlace.href = "showForo.php";
	enlace.target = '_blank';
	enlace.rel = 'noopener noreferrer';
	// 'btn-foro-id' is used to manage the foros id between the htmls.
	enlace.classList.add('btn-card', 'btn', 'btn-primary', 'btn-foro-id');
	enlace.textContent = 'Entrar';

	// Joining elements
	cardBodyDiv.appendChild(title);
	cardBodyDiv.appendChild(description);
	cardBodyDiv.appendChild(date);
	cardBodyDiv.appendChild(enlace);

	cardContentDiv.appendChild(cardBodyDiv);

	cardImgDiv.appendChild(img);
	cardDiv.appendChild(cardImgDiv);
	cardDiv.appendChild(cardContentDiv);

	return cardDiv;
}

function fillForos(foros) {

	var sectionForo = $("#foros_div");

	foros.data.forEach(foro => {
		var newCard = createForoCard(foro.id_foro, foro.name, foro.description, foro.photo, foro.date_creation);
		sectionForo.append(newCard);
	});

}


$(document).ready(function () {
	// Filling all the foros
	getForo().then(function (foros) {
		if (foros != null) {
			var objForos = JSON.parse(foros);

			fillForos(objForos);

		} else {
			console.log("Nop");
		}
	}).catch(function (error) {
		console.error("Error al obtener foros:", error);
	});

	// Filling trend foro
	getForo().then(function (foros) {
		if (foros != null) {
			var objForos = JSON.parse(foros);

			var trendCard = createTrendForoCard(objForos.data[0].id_foro, objForos.data[0].name, objForos.data[0].description, objForos.data[0].photo, objForos.data[0].date_creation);
			$("#trend-div").append(trendCard);
		} else {
			console.log("Nop");
		}
	}).catch(function (error) {
		console.error("Error al obtener foros:", error);
	});
});
