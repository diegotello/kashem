function initPais() {
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
}
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
        cambioDepartamento(dep);
    }
}
function cambioDepartamento(e, async) {
    if (async === null) {
        async = true;
    }
    var dep_id = $(e).val(),
            mun = $('#municipio_id');
    if (dep_id !== "") {
        $.ajax(
                "/municipio/lista",
                {
                    method: 'get',
                    async: async,
                    data: {
                        departamento_id: dep_id
                    },
                    success: function(response)
                    {
                        mun.find('option[value!=""]').remove();
                        mun.append(response.lista);
                    }
                }
        );
    }
    else
    {
        mun.find('option[value!=""]').remove();
    }
}
function validar() {
    var result = new Object();
    result.valid = false;
    result.info = "<strong>No hemos podido comunicarnos con el servidor, intenta mas tarde.</strong>";
    $.ajax(
            "/" + controller + "/validarformulario",
            {
                method: 'get',
                async: false,
                data: $('#' + controller + '_form').serializeArray(),
                success: function(response)
                {
                    //includes response.valid and response.info
                    result = response;
                }
            }
    );
    return result;
}