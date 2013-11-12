$(document).ready(function() {
    $.ajax(
            "/pais/lista",
            {
                method: 'get',
                success: function(response)
                {
                    $('#pais_id').append(response.lista);
                }
            }
    );
});

function cambioPais(e, async) {
    if (async === null) {
        async = true;
    }
    var pais_id = $(e).val(),
            dep = $('#departamento_id');
    if (pais_id !== "") {
        $.ajax(
                "/departamento/lista",
                {
                    method: 'get',
                    async: async,
                    data: {
                        pais_id: pais_id
                    },
                    success: function(response)
                    {
                        dep.find('option[value!=""]').remove();
                        dep.append(response.lista);
                    }
                }
        );
    }
    else
    {
        dep.find('option[value!=""]').remove();
    }
}

function validar() {
    var result = new Object();
    result.valid = false;
    result.info = "<strong>No hemos podido comunicarnos con el servidor, intenta mas tarde.</strong>";
    $.ajax(
            "/municipio/validarformulario",
            {
                method: 'get',
                async: false,
                data: $('#municipio_form').serializeArray(),
                success: function(response)
                {
                    //includes response.valid and response.info
                    result = response;
                }
            }
    );
    return result;
}