
// Returns true if the name of the user is correct
function validateName(nameUser, id_input, input_place) {
    nameUser = nameUser.trim();
    id_input = "#" + id_input;
    if (nameUser === "" || /^\s+$/.test(nameUser)) {
        $("#confirmModalLabel").text("Datos incorrectos");
        $("#confirmModalText").text("No se admite un " + input_place + " vacío.");

        $('#confirmModal').modal('show');
        $(id_input).addClass('border border-danger border-2');

        return false;
    }

    if (nameUser.length > 50) {
        $("#confirmModalLabel").text("Datos incorrectos");
        $("#confirmModalText").text("Su " + input_place + " no debe superar los 50 caracteres.");

        $('#confirmModal').modal('show');
        $(id_input).addClass('border border-danger border-2');

        return false;
    }

    $(id_input).removeClass('border border-danger border-2');

    return true;
}

