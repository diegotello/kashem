var controller;
$(document).ready(function() {
    controller = "municipio";
    if (typeof(initBusqueda) === "function")
    {
        initBusqueda();
    }
    if (typeof(initPais) === "function")
    {
        initPais();
    }
});

