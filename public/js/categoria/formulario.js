function validar() {
    var result = new Object();
    result.valid = false;
    result.info = "<strong>No hemos podido comunicarnos con el servidor, intenta mas tarde.</strong>";
    $.ajax(
            "/categoria/validarformulario",
            {
                method: 'get',
                async: false,
                data: $('#categoria_form').serializeArray(),
                success: function(response)
                {
                    //includes response.valid and response.info
                    result = response;
                }
            }
    );
    return result;
}