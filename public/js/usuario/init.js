var controller;
$(document).ready(function() {
    controller = "usuario";
    if (typeof(initBusqueda) === "function")
    {
        initBusqueda();
    }
    if (typeof(initRol) === "function")
    {
        initRol();
    }
});

