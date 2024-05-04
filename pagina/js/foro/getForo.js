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
        
    // Get the params from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const idButton = urlParams.get('id');

    // Filling the foro information
    getForo(idButton).then(function (foros) {
        if (foros != null) {
            var objForo = JSON.parse(foros);
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