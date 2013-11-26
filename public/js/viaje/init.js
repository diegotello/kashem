var controller,
        destinos = new Array(),
        actividades = new Array(),
        guias = new Array();
$(document).ready(function() {
    controller = "viaje";
    $('#fecha_salida').datepicker({dateFormat: "dd-mm-yy", minDate: 1});
    $('#fecha_regreso').datepicker({dateFormat: "dd-mm-yy", minDate: 1});
    $("#fecha_salida").change(function() {
        $('#fecha_regreso')
                .datepicker('destroy')
                .val('')
                .datepicker({dateFormat: "dd-mm-yy", minDate: new Date($("#fecha_salida").datepicker("getDate"))});
    });
    $('#fecha_regreso').change(function() {
        checkHoraRegreso();
    });
    $("#hora_regreso").change(function() {
        checkHoraRegreso();
    });
    if (typeof(initBusqueda) === "function")
    {
        initBusqueda();
    }
    if (typeof(initFormularioEdicion) === "function")
    {
        initFormularioEdicion();
    }
    $('#campo_busqueda').change(function() {
        cambioCampoBusqueda();
    });
});
function initBusquedaN() {
    $('#busqueda_refresh_button').attr('onClick', 'recargarListaN();');
    $.ajax(
            "/" + controller + "/campos",
            {
                method: 'get',
                async: false,
                success: function(response)
                {
                    $('#campo_busqueda').find('option[value!=""]').remove();
                    $('#campo_busqueda').append(response.lista);
                    $('#nuevo_link').attr('href', '/' + controller + '/nuevo');
                    $('#busqueda_button').attr('onClick', 'buscarN();');
                    $('#busqueda_form').show();
                }
            }
    );
}

function recargarListaN() {
    $('#valor_busqueda').val('');
    buscarN();
}

function recargarListas() {
    controller = 'destino';
    if (typeof(initBusquedaN) === "function")
    {
        initBusquedaN();
    }
    recargarListaN();
    controller = 'actividad';
    if (typeof(initBusquedaN) === "function")
    {
        initBusquedaN();
    }
    recargarListaN();
    controller = 'guia';
    if (typeof(initBusquedaN) === "function")
    {
        initBusquedaN();
    }
    recargarListaN();
}

function buscarN() {
    var search_data = $('#busqueda_form').serializeArray(),
            ref = new Object();
    ref.name = 'origen';
    ref.value = 'viaje';
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
                    var campos = $('#lista_' + controller + ' input[type = checkbox]');
                    searchArray = null;
                    switch (controller) {
                        case 'destino':
                            searchArray = destinos;
                            break;
                        case 'actividad':
                            searchArray = actividades;
                            break;
                        case 'guia':
                            searchArray = guias;
                            break;
                    }
                    $.each(campos, function() {
                        if (searchArray.indexOf($(this).val()) >= 0)
                        {
                            $(this).attr('checked', true);
                        }
                    });
                }
            }
    );
}

function cambioCampoBusqueda() {
    var campo = $('#campo_busqueda').val();
    if (campo === 'fecha_salida' || campo === 'fecha_regreso')
    {
        $('#valor_busqueda').datepicker({dateFormat: "dd-mm-yy"});
    }
    else
    {
        $('#valor_busqueda').datepicker('destroy');
    }
}

function checkHoraRegreso() {
    if ($("#fecha_salida").val() === $("#fecha_regreso").val())
    {
        if ($('#hora_regreso').val() < $('#hora_salida').val())
        {
            $('#hora_regreso').val($('#hora_salida').val());
        }
    }
}

function mostrarPagina(id) {
    $('#viaje_page').hide();
    $('#destino_page').hide();
    $('#actividad_page').hide();
    $('#guia_page').hide();
    $('#guardar_page').hide();
    $('#' + id).show();
    switch (id) {
        case 'viaje_page':
            $('#busqueda_form').hide();
            break;
        case 'destino_page':
            controller = 'destino';
            if (typeof(initBusquedaN) === "function")
            {
                initBusquedaN();
            }
            $('#informacion_viaje_nombre').empty().text($('#nombre').val());
            $('#informacion_viaje_salida').empty().text($('#fecha_salida').val() + ' a las ' + tConvert($('#hora_salida').val()));
            $('#informacion_viaje_regreso').empty().text($('#fecha_regreso').val() + ' a las ' + tConvert($('#hora_regreso').val()));
            break;
        case 'actividad_page':
            controller = 'actividad';
            if (typeof(initBusquedaN) === "function")
            {
                initBusquedaN();
            }
            break;
        case 'guia_page':
            controller = 'guia';
            if (typeof(initBusquedaN) === "function")
            {
                initBusquedaN();
            }
            break;
        case 'guardar_page':
            recargarListas();
            $('#busqueda_form').hide();
            var ready = true;
            if ($('#nombre').val() === ''
                    || $('#fecha_salida').val() === ''
                    || $('#hora_salida').val() === ''
                    || $('#fecha_regreso').val() === ''
                    || $('#hora_regreso').val() === '')
            {
                $('#no_viaje_alert').show();
                ready = false;
            }
            else
            {
                $('#no_viaje_alert').hide();
            }
            if (destinos.length < 1)
            {
                $('#no_destino_alert').show();
                ready = false;
            }
            else
            {
                $('#no_destino_alert').hide();
            }
            if (actividades.length < 1)
            {
                $('#no_actividad_alert').show();
                ready = false;
            }
            else
            {
                $('#no_actividad_alert').hide();
            }
            if (guias.length < 1)
            {
                $('#no_guia_alert').show();
                ready = false;
            }
            else
            {
                $('#no_guia_alert').hide();
            }
            if (ready)
            {
                $('#guardar_viaje_button').show();
            }
            else
            {
                $('#guardar_viaje_button').hide();
            }
            $('#lista_destino_final').empty();
            $.each(destinos, function() {
                var el = $('#destino_viaje_row_' + this).clone();
                el.find('input[type=checkbox]').attr('disabled', true);
                el.attr('id', '');
                $('#lista_destino_final').append(el);
            });
            $('#lista_actividad_final').empty();
            $.each(actividades, function() {
                var el = $('#actividad_viaje_row_' + this).clone();
                el.find('input[type=checkbox]').attr('disabled', true);
                el.attr('id', '');
                $('#lista_actividad_final').append(el);
            });
            $('#lista_guia_final').empty();
            $.each(guias, function() {
                var el = $('#guia_viaje_row_' + this).clone();
                el.find('input[type=checkbox]').attr('disabled', true);
                el.attr('id', '');
                $('#lista_guia_final').append(el);
            });
            break;
    }
}

function terminarSeleccionDestino() {
    mostrarPagina('actividad_page');
}

function terminarSeleccionActividad() {
    mostrarPagina('guia_page');
}

function terminarSeleccionGuia() {
    mostrarPagina('guardar_page');
}

function tConvert(time) {
    time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];
    if (time.length > 1) {
        time = time.slice(1);
        time[3] = ' ';
        time[5] = +time[0] < 12 ? 'AM' : 'PM';
        time[0] = +time[0] % 12 || 12;
    }
    return time.join('');
}

function seleccionarDestino(e) {
    var checkbox = $(e);
    if (checkbox.is(':checked'))
    {
        destinos.push(checkbox.val());
    }
    else
    {
        var index = destinos.indexOf(checkbox.val());
        destinos.splice(index, 1);
    }
}

function seleccionarActividad(e) {
    var checkbox = $(e);
    if (checkbox.is(':checked'))
    {
        actividades.push(checkbox.val());
    }
    else
    {
        var index = actividades.indexOf(checkbox.val());
        actividades.splice(index, 1);
    }
}

function seleccionarGuia(e) {
    var checkbox = $(e);
    if (checkbox.is(':checked'))
    {
        guias.push(checkbox.val());
    }
    else
    {
        var index = guias.indexOf(checkbox.val());
        guias.splice(index, 1);
    }
}

function validarN() {
    var result = new Object();
    result.valid = false;
    result.info = "<strong>No hemos podido comunicarnos con el servidor, intenta mas tarde.</strong>";
    $.ajax(
            "/viaje/validarformulario",
            {
                method: 'get',
                async: false,
                data: $('#viaje_form').serializeArray(),
                success: function(response)
                {
                    //includes response.valid and response.info
                    result = response;
                }
            }
    );
    return result;
}

function guardar() {
    var isvalid = validarN();
    if (isvalid.valid) {
        $.ajax(
                "/viaje/guardar",
                {
                    method: 'post',
                    data: $('#viaje_form').serializeArray(),
                    success: function(response)
                    {
                        if (response.ok) {
                            $('#error-alert').hide();
                            $('#success-alert').show();
                            setTimeout(function() {
                                $('#success-alert').hide();
                                window.location.assign("/viaje");
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
        $('#error-alert').empty().append(isvalid.info).show();
    }
}

function editV(id) {
    window.location.assign("/viaje/editar?id=" + id);
}

function actualizar() {
    var isvalid = validarN();
    if (isvalid.valid) {
        $.ajax(
                "/viaje/actualizar",
                {
                    method: 'post',
                    data: $('#viaje_form').serializeArray(),
                    success: function(response)
                    {
                        if (response.ok) {
                            $('#error-alert').hide();
                            $('#success-alert').show();
                            setTimeout(function() {
                                $('#success-alert').hide();
                                window.location.assign("/viaje");
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
        $('#error-alert').empty().append(isvalid.info).show();
    }
}