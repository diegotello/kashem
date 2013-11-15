var controller;
$(document).ready(function() {
    controller = "departamento";
    if (typeof(initBusqueda) === "function")
    {
        initBusqueda();
    }
    if (typeof(initPais) === "function")
    {
        initPais();
    }
});

