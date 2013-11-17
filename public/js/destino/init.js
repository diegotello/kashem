var controller;
$(document).ready(function() {
    controller = "destino";
    if (typeof(initBusqueda) === "function")
    {
        initBusqueda();
    }
    if (typeof(initPais) === "function")
    {
        initPais();
    }
});

