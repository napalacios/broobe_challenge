function setMensajeInput(id_input_feedback, mensaje){

    $('#' + id_input_feedback).html('');
    $('#' + id_input_feedback).append(mensaje);

}

var Toast = Swal.mixin({
    toast: true,
    position: 'bottom-end',
    showConfirmButton: false,
    timer: 3000
});