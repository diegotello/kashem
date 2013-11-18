var controller;
$(document).ready(function() {
    controller = "guia";
    if (typeof(initBusqueda) === "function")
    {
        initBusqueda();
    }
    if (typeof(initCliente) === "function")
    {
        initCliente();
    }
    if (typeof(initCategoria) === "function")
    {
        initCategoria();
    }
});

