var controller;
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
    $('#campo_busqueda').change(function() {
        cambioCampoBusqueda();
    });
});

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

