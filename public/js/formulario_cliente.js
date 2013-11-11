$(document).ready(function() {
    $.ajax(
            "/pais/lista",
            {
                method: 'get',
                success: function(response)
                {
                    $('#pais').append(response.lista);
                }
            }
    );
});
function cambioPais(e) {
    var pais_id = $(e).val(),
            dep = $('#departamento');
    if (pais_id !== "") {
        $.ajax(
                "/departamento/lista",
                {
                    method: 'get',
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
function cambioDepartamento(e) {
    var dep_id = $(e).val(),
            mun = $('#municipio');
    if (dep_id !== "") {
        $.ajax(
                "/municipio/lista",
                {
                    method: 'get',
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
function guardar() {
    console.log($('#client_form').serialize());
}
