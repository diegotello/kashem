var controller;
var equiposeleccionado = new Array();

$(document).ready(function() {
    controller = "cliente";
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
    ref.value = 'alquiler';
    search_data.push(ref);

    $.ajax(
            "/" + controller + "/busqueda",
            {
                method: 'get',
                data: search_data,
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
            break;
        case 'alquiler_page':
            $('#busqueda_form').hide();
            break;
    }
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
                    $('#id_cliente').val(response.id);
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