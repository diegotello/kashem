var controller;
$(document).ready(function() {
    controller = "viaje";
    $('#fecha_salida').datepicker({dateFormat: "dd-mm-yy"});
    $('#fecha_regreso').datepicker({dateFormat: "dd-mm-yy"});
    if (typeof(initBusqueda) === "function")
    {
        initBusqueda();
    }
});

