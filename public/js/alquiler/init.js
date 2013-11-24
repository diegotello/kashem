var controller;
var equiposeleccionado = new Array();

$(document).ready(function() {
    controller = "cliente";
    if (typeof(initBusqueda) === "function")
    {
        initBusqueda();
    }
    $('#renta').datepicker({dateFormat: "dd-mm-yy", minDate: 1});
    $('#devolucion').datepicker({dateFormat: "dd-mm-yy", minDate: 1});
    $("#renta").change(function() {
        $('#devolucion')
                .datepicker('destroy')
                .val('')
                .datepicker({dateFormat: "dd-mm-yy", minDate: new Date($("#renta").datepicker("getDate"))});
    });
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
    ref.value = 'alquiler';
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
                    var campos = $('#lista_equipo input[type = checkbox]');
                    $.each(campos, function() {
                        if (equiposeleccionado.indexOf($(this).val()) >= 0)
                        {
                            $(this).attr('checked', true);
                        }
                    });
                }
            }
    );
}

function mostrarPagina(id) {
    $('#valor_busqueda').val('');
    $('#cliente_page').hide();
    $('#equipo_page').hide();
    $('#alquiler_page').hide();
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
        case 'equipo_page':
            controller = "equipo";
            if (typeof(initBusqueda) === "function")
            {
                initBusqueda();
            }
            recargarLista();
            revisarEquipoSeleccionado();
            $('#equipo_seleccionado').val(equiposeleccionado.length);
            break;
        case 'alquiler_page':
            controller = "equipo";
            recargarLista();
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
            if ($('#equipo_seleccionado').val() === '0')
            {
                $('#no_equipo_alert').show();
                ready = false;
            }
            else
            {
                $('#no_equipo_alert').hide();
            }
            if (ready)
            {
                $('#alquiler_guardar_button').show();
            }
            else
            {
                $('#alquiler_guardar_button').hide();
            }
            $('#lista_equipo_final').empty();
            $.each(equiposeleccionado, function() {
                var el = $('#equipo_alquiler_row_' + this).clone();
                el.find('input[type=checkbox]').attr('disabled', true);
                el.attr('id', '');
                $('#lista_equipo_final').append(el);
            });
            break;
    }
}

function revisarEquipoSeleccionado() {
    var equipos = $('#lista_equipo').find('input[type=checkbox]');
    equiposeleccionado = new Array();
    $.each(equipos, function() {
        if ($(this).is(':checked'))
        {
            equiposeleccionado.push($(this).val());
        }
    });
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
                    $('#nombre_cliente').val(response.primer_nombre + ' ' + response.primer_apellido);
                    $('#dpi_cliente').val(response.dpi);
                    $('#cliente_id').val(response.id);
                    $('#informacion_cliente_nombre').empty().text(response.primer_nombre + ' ' + response.primer_apellido);
                    $('#informacion_cliente_dpi').empty().text(response.dpi);
                    mostrarPagina('equipo_page');
                }
            }
    );
}

function seleccionarEquipo(e) {
    var checkbox = $(e);
    if (checkbox.is(':checked'))
    {
        equiposeleccionado.push(checkbox.val());
    }
    else
    {
        var index = equiposeleccionado.indexOf(checkbox.val());
        equiposeleccionado.splice(index, 1);
    }
    $('#equipo_seleccionado').val(equiposeleccionado.length);
}

function terminarSeleccionEquipo() {
    mostrarPagina('alquiler_page');
}

function guardar() {
    var alquiler_data = new Object();
    alquiler_data.cliente_id = $('#cliente_id').val();
    alquiler_data.equipo = equiposeleccionado;
    alquiler_data.renta = $('#renta').val();
    alquiler_data.devolucion = $('#devolucion').val();
    alquiler_data.deposito = $('#deposito').val();
    alquiler_data.comentario = $('#comentario').val();
    alquiler_data.costo = $('#costo').val();
    var valido = validar(alquiler_data);
    if (valido.valid)
    {
        $.ajax(
                "/alquiler/guardar",
                {
                    method: 'post',
                    data: alquiler_data,
                    success: function(response)
                    {
                        if (response.ok) {
                            $('#error-alert').hide();
                            $('#success-alert').show();
                            setTimeout(function() {
                                $('#success-alert').hide();
                                window.location.assign("/alquiler");
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

function validar(alquiler_data) {
    var result = new Object();
    result.valid = false;
    result.info = "<strong>No hemos podido comunicarnos con el servidor, intenta mas tarde.</strong>";
    $.ajax(
            "/alquiler/validarformulario",
            {
                method: 'get',
                async: false,
                data: alquiler_data,
                success: function(response)
                {
                    //includes response.valid and response.info
                    result = response;
                }
            }
    );
    return result;
}