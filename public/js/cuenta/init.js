var controller;
$(document).ready(function() {
    controller = "cuenta";
    $('#cuentas_tab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    if (typeof(initBusqueda) === "function")
    {
        initBusqueda();
    }
});

function initBusqueda() {
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
                    $('#nuevo_link').hide();
                    $('#busqueda_form').show();
                }
            }
    );
}