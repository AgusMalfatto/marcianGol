// Ajax to get user data
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

// Ajax to add new comment to the database
function createComment(comment) {
    return new Promise(function (resolve, reject){
        var id_foro = $("#id_foro").text();
        var settings = {
            "url": "../../php/comment/addComment.php",
            "method": "POST",
            "timeout": 0,
            "data": {
                "id_foro": id_foro,
                "description": comment
            }
        };
        $.ajax(settings).done(function(response) {
            resolve(response);
                $("#commentTextareaForo").val("");
                $("#commentForoModal").modal("hide");

        }).fail(function (jqXHR, textStatus, errorThrown) {
            reject(errorThrown);
        });
    });
}

// Ajax to update the like interaction
function updateLike(id_comment) {
    return new Promise(function (resolve, reject) {

        var settings = {
            "url": "../../php/comment/like.php",
            "method": "POST",
            "timeout": 0,
            "data": {
                id_comment: id_comment
            }
        };

        $.ajax(settings).done(function (response) {
            resolve(response);
            
        }).fail(function (jqXHR, textStatus, errorThrown) {
            reject(errorThrown);
        });
    });
}

// Function to manage the like process
function manageLike(id_comment) {
    updateLike(id_comment).then(function(response) {
        response = JSON.parse(response);

        var iconId = "#iconId_" + id_comment;
        var likesTagId = "#idLikesTag_" + id_comment;
        
        // If the result is a like or get back of the like
        if (response.reaction) {
            // Paint the heart and update count likes
            $(iconId).attr('class', 'las la-heart la-2x');
            $(likesTagId).text(response.count_likes);
        } else {
            // Clean the heart and update count likes
            $(iconId).attr('class', 'lar la-heart la-2x');
            $(likesTagId).text(response.count_likes);
        }
    })
}

// Function to manage the new comment process
function manageComment(newComment, id_comment) {
    var dateNow = new Date();
    dateNow = dateNow.toISOString().slice(0, 10);
    
    var comment = {
        "description": newComment,
        "date_comment": dateNow,
        "Likes": 0,
        "id_comment": id_comment
    };    

    getUser().then(function (user) {
        user = JSON.parse(user);

        comment.name = user.name;
        comment.last_name = user.last_name;
        comment.id_user = user.id_user;
        
        // Create comment card and add to comment section
        var commentCard = createCommentCard(comment, user.id_user, user.admin);
        $("#content-comment").prepend(commentCard);
    });
    
}

// Ajax to get filter comments from the database of one foro
function getFilterComments(id_foro, filterText = "", order_by = "") {
    return new Promise(function (resolve, reject){
        var settings = {
            "url": "../../php/comment/getComment.php",
            "method": "GET",
            "timeout": 0,
            "data": {
                "id_foro": id_foro
            }
        };

        if (filterText.length > 0) {
            settings.data.filter_text = filterText;
        }
        if (order_by.length > 0) {
            settings.data.order_by = order_by;
        }

        $.ajax(settings).done(function(response) {
            response = JSON.parse(response);
            resolve(response);

        }).fail(function (jqXHR, textStatus, errorThrown) {
            reject(errorThrown);
        });
    });
}

// Function to add cards of every comments of the foro
function fillBodyCommentsSection(comments) {
    /* Creating cards for each comment */
    document.getElementById('content-comment').innerHTML = "";
    comments.data.forEach(comment => {
        var commentCard = createCommentCard(comment, comments.id_userSession, comments.admin);
        document.getElementById('content-comment').appendChild(commentCard);
    })
}

// Ajax to deactivate a comment
function deactivateComment(id_comment) {
    return new Promise(function (resolve, reject) {
        var settings = {
            "url": "../../php/comment/deactivateComment.php",
            "method": "POST",
            "timeout": 0,
            "data": {
                id_comment: id_comment
            }
        };

        $.ajax(settings).done(function (response) {
            response = JSON.parse(response);
            resolve(response);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            reject(errorThrown);
        })
    })
}


$(document).ready(function() {

    // Manage the like button interaction
    $(document).on("click", ".btn_reaction", function() {
        // Getting the ID of the comment
        var id_comment = $(this).attr('id');
        var id_comment = id_comment.split("_");
        id_comment = id_comment.pop();

        manageLike(parseInt(id_comment));
    })  

    // Manage the new comment button interaction
    $("#add_comment_btn").on("click", function() {
        $("#commentForoModal").modal("show");

        $("#confirmCommentForo").off("click").on("click", function() {
            var newComment = $("#commentTextareaForo").val();

            if(validateComment(newComment)) {
                createComment(newComment).then(function (result) {
                    result = JSON.parse(result);
                    manageComment(newComment, result.id_newComment);
                })
            }
        });
    });

    // Manage the filter button interaction
    $('#filter_btn').on('click', function() {
        var filterText = $("#inputFilterComment").val();
        var orderText = $("#selectOrderComment").val();
        var id_foro = $("#id_foro").text();

        getFilterComments(id_foro, filterText, orderText).then(function(comments) {
            fillBodyCommentsSection(comments);
        })
    });

    // Manage the clean filter button interaction
    $("#clean_filter_btn").on("click", function () {
        $("#inputFilterComment").val("");
        $("#selectOrderComment").val("");
        var id_foro = $("#id_foro").text();
        getFilterComments(id_foro).then(function(comments) {
            fillBodyCommentsSection(comments);
        })
    })

    // Manage the delete comment button interaction
    $(document).on("click", ".trash_btn_class", function() {
        var id_comment = $(this).attr("id");
        id_comment = id_comment.split("_");
        id_comment = id_comment.pop();

        $("#questionModalLabel").text("Eliminar Comentario");
        $("#questionModalText").text("¿Desea eliminar el comentario?");
        $("#confirmQuestion").modal("show");

        // If the user confirm to delete the comment
        $("#confirmQuestionBtn").on("click", function () {
            deactivateComment(id_comment).then(function(response) {
                if (response.success) {
                    $("#confirmModalLabel").text("Comentario Eliminado");
                    $("#confirmModalText").text("El comentario se eliminó exitosamente.");
                } else {
                    $("#confirmModalLabel").text("Error al eliminar");
                    $("#confirmModalText").text("Ups, hubo un error al eliminar el comentario. Por favor contacte con soporte.");
                }
                $("#confirmModal").modal("show");
                $("#confirmQuestion").modal("hide");
                // Evento que se dispara cuando el modal se cierra
                $('#confirmModal').on('hidden.bs.modal', function () {
                    // Redireccionar una vez que el modal se haya cerrado
                    location.reload();
                });
            })
        })
    })

})