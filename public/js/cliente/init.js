var controller;
$(document).ready(function() {
    $('#fecha_nacimiento').datepicker({dateFormat: "dd-mm-yy"});
    controller = "cliente";
    if (typeof(initBusqueda) === "function")
    {
        initBusqueda();
    }
    if (typeof(initPais) === "function")
    {
        initPais();
    }
});

