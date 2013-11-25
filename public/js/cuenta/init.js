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
    $('#campo_busqueda').change(function() {
        cambioCampoBusqueda();
    });
});

function cambioCampoBusqueda() {
    var campo = $('#campo_busqueda').val();
    if (campo === 'renta' || campo === 'devolucion' || campo === 'fecha_salida' || campo === 'fecha_regreso')
    {
        $('#valor_busqueda').datepicker({dateFormat: "dd-mm-yy"});
    }
    else
    {
        $('#valor_busqueda').datepicker('destroy');
    }
}

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

function buscar() {
    $.ajax(
            "/" + controller + "/busqueda",
            {
                method: 'get',
                data: $('#busqueda_form').serializeArray(),
                success: function(response)
                {
                    $.each(response, function(k, v) {
                        $('#' + k).empty().append(v);
                    }
                    );
                }
            }
    );
}

function iniciarCancelacion(cid) {
    $.ajax(
            "/cuenta/info",
            {
                method: 'get',
                data: {id: cid},
                success: function(response)
                {
                    $('#modal_body').empty()
                            .append(response.html);
                    $('#modal_cancelar_boton').attr('onClick', 'cancelar(' + cid + ');');
                    $('#modal').modal('show');
                }
            }

    );
}

function cancelar(cid) {
    $.ajax(
            "/cuenta/cancelar",
            {
                method: 'get',
                data: {
                    id: cid,
                    tipo_de_pago_id: $('#tipo_de_pago_id').val()
                },
                success: function(response)
                {
                    $('#modal').modal('hide');
                    if (response.ok) {
                        $('#error-alert').hide();
                        $('#success-alert').show();
                        setTimeout(function() {
                            $('#success-alert').hide();
                            window.location.reload();
                        }, 1500);
                    }
                    else
                    {
                        $('#success-alert').hide();
                        $('#error-alert').empty().append(response.info).show();
                    }
                }
            }
    );
}

function detalles(cid) {
    $.ajax(
            "/cuenta/info",
            {
                method: 'get',
                data: {id: cid},
                success: function(response)
                {
                    $('#modal_body').empty()
                            .append(response.html);
                    $('#tipo_de_pago_id').attr('readOnly', true);
                    $('#modal_cancelar_boton').hide();
                    $('#modal').modal('show');
                }
            }

    );
}