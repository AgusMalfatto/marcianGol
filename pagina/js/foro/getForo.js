function getForo() {
	return new Promise(function (resolve, reject) {
		var settings = {
			"url": "../../php/foro/getForo.php",
			"method": "GET",
			"timeout": 0,
		};

		$.ajax(settings).done(function (response) {
			resolve(response);
		}).fail(function (jqXHR, textStatus, errorThrown) {
			reject(errorThrown);
		});
	});
}


$(document).ready(function () {

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
});