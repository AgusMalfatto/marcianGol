
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
    
    var deactivateBtn = document.getElementById("confirmDeactivateBtn");
    var modify_foro = $("#modify_foro");
    var modify_btn = $("#modifyBtn");
    var confirmModifyBtn = $("#confirmModifyBtn");
    
    // Get the params from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const idForo = urlParams.get('id');
    
    
    deactivateBtn.addEventListener("click", function() {
        var nameForo = $("#foro_name").text();
        console.log(nameForo);
        deactivateForo(idForo, nameForo, "home.php");
    });

    modify_foro.on("click", function() {
        fillModifyForm();
    })

    modify_btn.on("click", function() {
        var idForo = $("#idModifyForo").val();
        var nameForo = $("#nameModifyForo").val();
        var descriptionForo = $("#descriptionMofidyForo").val();
        var imageForo = $("#imageModifyForo").val();
        var leagueForo = $("#leagueModifyForo").val();

        
        if(validateName(nameForo) && validateDescription(descriptionForo)) {
            $('#modifyModal').modal('show');
        }
    })
    
    confirmModifyBtn.on("click", function() {
        var last_name = $("#foro_name").text();

        var idForo = $("#idModifyForo").val();
        var nameForo = $("#nameModifyForo").val();
        var descriptionForo = $("#descriptionMofidyForo").val();
        var imageForo = $("#imageModifyForo").val();
        var leagueForo = $("#leagueModifyForo").val();

        modifyForo(idForo, nameForo, descriptionForo, imageForo, leagueForo, last_name);  
    })
    
}); 