
// Returns true if the name of the foro is correct
function validateName(nameForo) {
    nameForo = nameForo.trim();

    if (nameForo === "" || /^\s+$/.test(nameForo)) {
        $("#confirmModalLabel").text("Datos incorrectos.");
        $("#confirmModalText").text("No se admite un nombre vacío.");

        $('#confirmModal').modal('show');
        $("#nameModifyForo").addClass('border border-danger border-2');

        return false;
    }

    if (nameForo.length > 50) {
        $("#confirmModalLabel").text("Datos incorrectos.");
        $("#confirmModalText").text("El nombre no debe superar los 50 caracteres.");

        $('#confirmModal').modal('show');
        $("#nameModifyForo").addClass('border border-danger border-2');

        return false;
    }

    $("#nameModifyForo").removeClass('border border-danger border-2');

    return true;
}

// Returns true if the description of the foro is correct
function validateDescription(descriptionForo) {
    descriptionForo = descriptionForo.trim();

    if (descriptionForo === "" || /^\s+$/.test(descriptionForo)) {
        $("#confirmModalLabel").text("Datos incorrectos.");
        $("#confirmModalText").text("No se admite una descripción vacía.");

        $('#confirmModal').modal('show');
        $("#descriptionMofidyForo").addClass('border border-danger border-2');

        return false;
    }

    if (descriptionForo.length > 150) {
        $("#confirmModalLabel").text("Datos incorrectos.");
        $("#confirmModalText").text("La descripción no debe superar los 150 caracteres.");

        $('#confirmModal').modal('show');
        $("#descriptionMofidyForo").addClass('border border-danger border-2');

        return false;
    }

    $("#descriptionMofidyForo").removeClass('border border-danger border-2');

    return true;
}
