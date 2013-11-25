var controller;
$(document).ready(function() {
    controller = "cuenta";
    $('#cuentas_tab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    if (typeof(initBusqueda) === "function")
    {
        initBusqueda();
    }
    $('#campo_busqueda').change(function() {
        cambioCampoBusqueda();
    });
});

function cambioCampoBusqueda() {
    var campo = $('#campo_busqueda').val();
    if (campo === 'renta' || campo === 'devolucion' || campo === 'fecha_salida' || campo == 'fecha_regreso')
    {
        $('#valor_busqueda').datepicker({dateFormat: "dd-mm-yy"});
    }
    else
    {
        $('#valor_busqueda').datepicker('destroy');
    }
}

function initBusqueda() {
    $.ajax(
            "/" + controller + "/campos",
            {
                method: 'get',
                success: function(response)
                {
                    $('#campo_busqueda').find('option[value!=""]').remove();
                    $('#campo_busqueda').append(response.lista);
                    $('#nuevo_link').attr('href', controller + '/nuevo');
                    $('#busqueda_button').attr('onClick', 'buscar();');
                    $('#nuevo_link').hide();
                    $('#busqueda_form').show();
                }
            }
    );
}

function buscar() {
    $.ajax(
            "/" + controller + "/busqueda",
            {
                method: 'get',
                data: $('#busqueda_form').serializeArray(),
                success: function(response)
                {
                    $.each(response, function(k, v) {
                        $('#' + k).empty().append(v);
                    }
                    );
                }
            }
    );
}