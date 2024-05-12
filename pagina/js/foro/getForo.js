
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
function createCommentCard(comment, id_userSession, is_admin) {

    /* Creating contents cards */
    var commentCard = document.createElement('div');
    commentCard.classList.add('card', 'm-3', 'content');

    var userNameCard = document.createElement('div');
    userNameCard.classList.add('m-1', 'author');
    userNameCard.style.display = 'flex';

    var contentCard = document.createElement('div');
    contentCard.classList.add('m-1');

    var likesCard = document.createElement('div');
    likesCard.classList.add('m-3', 'd-flex', 'align-items-center');

    /* Creating info tags */
    var nameTag = document.createElement('h5');
    nameTag.classList.add('card-title');
    nameTag.textContent = comment.name + ", " + comment.last_name + " | " + comment.date_comment;
    nameTag.textContent = comment.name + ", " + comment.last_name + " | " + comment.date_comment;nameTag.style.flex = '1'
    
    var contentTag = document.createElement('p');
    contentTag.classList.add('card-text');
    contentTag.textContent = comment.description;

    var likesTag = document.createElement('p');
    likesTag.classList.add('card-text', 'm-0', 'mr-2');
    likesTag.textContent = comment.Likes;
    var idLikesTag = "idLikesTag_" + comment.id_comment;
    likesTag.setAttribute('id', idLikesTag);

    var likeButton = document.createElement('button');
    likeButton.classList.add('btn', 'd-flex', 'align-items-center', 'btn_reaction');
    var idButton = "reaction_" + comment.id_comment;
    likeButton.setAttribute("id", idButton);
    var likesIcon = document.createElement('i');
    var idIcon = "iconId_" + comment.id_comment;
    likesIcon.setAttribute("id", idIcon);
    
    if(comment.Reaction === "1") {
        likesIcon.classList.add('las', 'la-heart', 'la-2x');
    } else {
        likesIcon.classList.add('lar', 'la-heart', 'la-2x');
    }

    /* Append */
    userNameCard.appendChild(nameTag);

    // Create the trash icon if the user is the creator of the comment or if is admin
    if((id_userSession === comment.id_user) || (is_admin)) {
        var trashButton = document.createElement('button');
        var trashButtonId = "trashCommentBtn_" + comment.id_comment;
        trashButton.setAttribute("id", trashButtonId);
        trashButton.classList.add('trash_btn_class', 'btn', 'd-flex', 'align-items-center');
        var trashIcon = document.createElement('i');
        trashIcon.classList.add('las', 'la-trash', 'la-2x');
        trashIcon.style.marginLeft = '35px';
        
        trashButton.appendChild(trashIcon);
        userNameCard.appendChild(trashButton);
    }
    contentCard.appendChild(contentTag);
    likeButton.appendChild(likesIcon);
    likesCard.appendChild(likeButton);
    likesCard.appendChild(likesTag);

    commentCard.appendChild(userNameCard);
    commentCard.appendChild(contentCard);
    commentCard.appendChild(likesCard);

    return commentCard;
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

            var id_userSession = objComment.id_userSession;
            var is_admin = objComment.admin;

            /* Creating cards for each comment */
            objComment.data.forEach(comment => {
                var commentCard = createCommentCard(comment, id_userSession, is_admin);
                document.getElementById('content-comment').appendChild(commentCard);
            })
        } else {
            console.log("Error");
        }
    }).catch(function (error) {
        console.error("Error al obtener foros:", error);
    }); 

});