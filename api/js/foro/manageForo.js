
function fillModifyForm() {
    var nameForo = $("#foro_name").text();
    var descriptionForo = $("#foro_description").text();
    var imageForo = $("#foro_image").attr("src");
    var leagueForo = $("#foro_league").text();
    var idForo = $("#id_foro").text();

    var imageForo = imageForo.split("/");
    var imageForo = imageForo.pop(); // Obtiene la última parte del array, que es el nombre del archivo con la extensión
    var imageForo = imageForo.split(".")[0];
    
    $("#idModifyForo").val(idForo);
    $("#nameModifyForo").val(nameForo);
    $("#descriptionMofidyForo").val(descriptionForo);
    $("#imageModifyForo").val(imageForo);
    $("#leagueModifyForo").val(leagueForo);

}


$(document).ready(function () {

    // '0' if the use is going to deactivate the foro, '1' if the user is going to modify.
    var flag;
    
    var deactivateBtn = $("#deactivate_foro");
    var deactivateConfirmBtn = document.getElementById("confirmQuestionBtn");

    // Open and fill modal
    var modify_foro = $("#modify_foro");

    // Capture the new data, validate and ask user to confirm
    var modify_btn = $("#modifyFormBtn");

    // Execute the modification
    var confirmModifyBtn = $("#confirmQuestionBtn");
    
    // Get the params from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const idForo = urlParams.get('id');
    
    deactivateBtn.on("click", function() {
        flag = 0;
        $("#questionModalLabel").text("Desactivar Foro");
        $("#questionModalText").text("¿Está seguro que desea desactivar el foro? Una vez desactivado no se podrá reactivar.");
        $("#confirmQuestion").modal("show");
    })
    
    deactivateConfirmBtn.addEventListener("click", function() {
        if (flag === 0){
            var nameForo = $("#foro_name").text();
            
            deactivateForo(idForo, nameForo, "home.php");    
        }
        
    });

    modify_foro.on("click", function() {
        fillModifyForm();
    })

    modify_btn.on("click", function() {
        flag = 1;
        var idForo = $("#idModifyForo").val();
        var nameForo = $("#nameModifyForo").val();
        var descriptionForo = $("#descriptionMofidyForo").val();
        var imageForo = $("#imageModifyForo").val();
        var leagueForo = $("#leagueModifyForo").val();

        
        if(validateName(nameForo) && validateDescription(descriptionForo)) {
            $("#questionModalLabel").text("Modificar Foro");
            $("#questionModalText").text("¿Desea modificar el foro?");
            $('#confirmQuestion').modal('show');
        }
    })
    
    confirmModifyBtn.on("click", function() {
        if (flag === 1) {
            var last_name = $("#foro_name").text();

            var idForo = $("#idModifyForo").val();
            var nameForo = $("#nameModifyForo").val();
            var descriptionForo = $("#descriptionMofidyForo").val();
            var imageForo = $("#imageModifyForo").val();
            var leagueForo = $("#leagueModifyForo").val();

            modifyForo(idForo, nameForo, descriptionForo, imageForo, leagueForo, last_name);
        }
          
    })
    
}); 