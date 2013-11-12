$(document).ready(function() {
    $.ajax(
            "/rol/lista",
            {
                method: 'get',
                success: function(response)
                {
                    $('#rol_id').append(response.lista);
                }
            }
    );
});

function validar() {
    var result = new Object();
    result.valid = false;
    result.info = "<strong>No hemos podido comunicarnos con el servidor, intenta mas tarde.</strong>";
    $.ajax(
            "/usuario/validarformulario",
            {
                method: 'get',
                async: false,
                data: $('#usuario_form').serializeArray(),
                success: function(response)
                {
                    //includes response.valid and response.info
                    result = response;
                }
            }
    );
    return result;
}