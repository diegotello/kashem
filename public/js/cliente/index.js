function borrar(id) {
    $.ajax(
            "/clientes/borrar",
            {
                method: 'post',
                data: {id: id},
                success: function(response)
                {
                    if (response.ok) {
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                }
            }
    );
}

function edit(id) {
    $.ajax(
            "/clientes/info",
            {
                method: 'get',
                data: {id: id},
                success: function(response)
                {
                    $('#modal-title').text(response.primer_nombre + ' ' + response.primer_apellido);
                    $.each(response, function(k, v) {
                        if (k !== 'pais_id' && k !== 'departamento_id' && k !== 'municipio_id')
                        {
                            $('#' + k).val(v);
                        }
                    });
                    $('#pais_id').val(response.pais_id);
                    cambioPais($('#pais_id'), false);
                    $('#departamento_id').val(response.departamento_id);
                    cambioDepartamento($('#departamento_id'), false);
                    $('#municipio_id').val(response.municipio_id);
                    $('#cliente_id').val(response.id);
                    $('#modal').modal('show');
                }
            }
    );
}

function actualizar() {
    var isvalid = validar();
    if (isvalid.valid) {
        $.ajax(
                "/clientes/actualizar",
                {
                    method: 'post',
                    data: $('#client_form').serializeArray(),
                    success: function(response)
                    {
                        if (response.ok) {
                            $('#form-error-alert').hide();
                            $('#form-success-alert').show();
                            $('#modal').modal('hide');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                        else
                        {
                            $('#form-success-alert').hide();
                            $('#form-error-alert').empty().append(response.info).show();
                        }
                    }
                }
        );
    }
    else
    {
        $('#form-success-alert').hide();
        $('#form-error-alert').empty().append(isvalid.info).show();
    }
}