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
                    $('#modal_cancelar_boton').show().attr('onClick', 'cancelar(' + cid + ');');
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
                    tipo_de_pago_id: $('#tipo_de_pago_id').val(),
                    numero_cheque: $('#numero_cheque').val(),
                    numero_autorizacion: $('#numero_autorizacion').val(),
                    numero_tarjeta: $('#numero_tarjeta').val(),
                    emisor: $('#emisor').val(),
                    banco: $('#banco').val()
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
                    $('#tipo_de_pago_id').attr('disabled', true);
                    $('#numero_cheque').attr('readOnly', true);
                    $('#numero_autorizacion').attr('readOnly', true);
                    $('#numero_tarjeta').attr('readOnly', true);
                    $('#emisor').attr('readOnly', true);
                    $('#banco').attr('readOnly', true);
                    cambioTipoPago();
                    $('#modal_cancelar_boton').hide();
                    $('#modal').modal('show');
                }
            }

    );
}

function cambioTipoPago() {
    var tipoPagoId = $('#tipo_de_pago_id').val();
    console.log(tipoPagoId);
    switch (tipoPagoId) {
        case '1':
            $('#numero_cheque_row').hide();
            $('#numero_tarjeta_row').hide();
            $('#numero_autorizacion_row').hide();
            $('#emisor_row').hide();
            $('#banco_row').hide();
            break;
        case '2':
            $('#numero_cheque_row').show();
            $('#numero_tarjeta_row').hide();
            $('#numero_autorizacion_row').hide();
            $('#emisor_row').hide();
            $('#banco_row').show();
            break;
        case '3':
        case '4':
            $('#numero_cheque_row').hide();
            $('#numero_tarjeta_row').show();
            $('#numero_autorizacion_row').show();
            $('#emisor_row').show();
            $('#banco_row').hide();
            break;
    }
}