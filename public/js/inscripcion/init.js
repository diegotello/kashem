var controller;

$(document).ready(function() {
    controller = "viaje";
    if (typeof(initBusqueda) === "function")
    {
        initBusqueda();
    }
});

function initBusqueda() {
    $('#busqueda_refresh_button').attr('onClick', 'recargarLista();');
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
                    $('#busqueda_form').show();
                }
            }
    );
}

function recargarLista() {
    $('#valor_busqueda').val('');
    buscar();
}

function buscar() {
    var search_data = $('#busqueda_form').serializeArray(),
            ref = new Object();
    ref.name = 'origen';
    ref.value = 'inscripcion';
    search_data.push(ref);
    $.ajax(
            "/" + controller + "/busqueda",
            {
                method: 'get',
                data: search_data,
                async: false,
                success: function(response)
                {
                    $('#lista_' + controller).empty().append(response.lista);
                }
            }
    );
}

function mostrarPagina(id) {
    $('#valor_busqueda').val('');
    $('#cliente_page').hide();
    $('#viaje_page').hide();
    $('#inscripcion_page').hide();
    $('#error-alert').hide();
    $('#success-alert').hide();
    $('#' + id).show();
    switch (id)
    {
        case 'cliente_page':
            controller = "cliente";
            if (typeof(initBusqueda) === "function")
            {
                initBusqueda();
            }
            break;
        case 'viaje_page':
            controller = "viaje";
            if (typeof(initBusqueda) === "function")
            {
                initBusqueda();
            }
            break;
        case 'inscripcion_page':
            $('#busqueda_form').hide();
            var ready = true;
            if ($('#cliente_id').val() === '')
            {
                $('#no_cliente_alert').show();
                ready = false;
            }
            else
            {
                $('#no_cliente_alert').hide();
            }
            if ($('#viaje_id').val() === '')
            {
                $('#no_viaje_alert').show();
                ready = false;
            }
            else
            {
                $('#no_viaje_alert').hide();
            }
            if (ready)
            {
                $('#inscripcion_guardar_button').show();
            }
            else
            {
                $('#inscripcion_guardar_button').hide();
            }
            break;
    }
}

function seleccionarViaje(id)
{
    $.ajax(
            "/viaje/info",
            {
                method: 'get',
                data: {id: id},
                success: function(response)
                {
                    $('#viaje_id').val(response.id);
                    $('#nombre_viaje').val(response.nombre);
                    $('#fecha_salida_viaje').val(response.fecha_salida);
                    $('#fecha_regreso_viaje').val(response.fecha_regreso);
                    $('#informacion_viaje_nombre').empty().text(response.nombre);
                    $('#informacion_viaje_salida').empty().text('las ' + response.hora_salida + ' horas del ' + response.fecha_salida);
                    $('#informacion_viaje_regreso').empty().text('las ' + response.hora_regreso + ' horas del ' + response.fecha_regreso);
                    mostrarPagina('cliente_page');
                }
            }
    );
}

function seleccionarCliente(id)
{
    $.ajax(
            "/cliente/info",
            {
                method: 'get',
                data: {id: id},
                success: function(response)
                {
                    $('#cliente_id').val(response.id);
                    $('#informacion_cliente_nombre').empty().text(response.primer_nombre + ' ' + response.primer_apellido);
                    $('#informacion_cliente_dpi').empty().text(response.dpi);
                    mostrarPagina('inscripcion_page');
                }
            }
    );
}

function guardar() {
    var inscripcion_data = new Object();
    inscripcion_data.cliente_id = $('#cliente_id').val();
    inscripcion_data.viaje_id = $('#viaje_id').val();
    inscripcion_data.costo = $('#costo').val();
    var valido = validar(inscripcion_data);
    if (valido.valid)
    {
        $.ajax(
                "/inscripcion/guardar",
                {
                    method: 'post',
                    data: inscripcion_data,
                    success: function(response)
                    {
                        if (response.ok) {
                            $('#error-alert').hide();
                            $('#success-alert').show();
                            setTimeout(function() {
                                $('#success-alert').hide();
                                window.location.assign("/inscripcion");
                            }, 1500);
                        }
                        else
                        {
                            $('#success-alert').hide();
                            $('#error-alert').empty().append(response.info).show();
                        }
                    }
                }
        );
    }
    else
    {
        $('#success-alert').hide();
        $('#error-alert').empty().append(valido.info).show();
    }
}

function validar(inscripcion_data) {
    var result = new Object();
    result.valid = false;
    result.info = "<strong>No hemos podido comunicarnos con el servidor, intenta mas tarde.</strong>";
    $.ajax(
            "/inscripcion/validarformulario",
            {
                method: 'get',
                async: false,
                data: inscripcion_data,
                success: function(response)
                {
                    //includes response.valid and response.info
                    result = response;
                }
            }
    );
    return result;
}