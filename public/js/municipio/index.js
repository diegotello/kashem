function borrar(id) {
    $.ajax(
            "/municipio/borrar",
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
            "/municipio/info",
            {
                method: 'get',
                data: {id: id},
                success: function(response)
                {
                    $('#modal-title').text(response.nombre);
                    $.each(response, function(k, v) {
                        if (k !== 'pais_id' && k !== 'departamento_id')
                        {
                            $('#' + k).val(v);
                        }
                    });
                    $('#pais_id').val(response.pais_id);
                    cambioPais($('#pais_id'), false);
                    $('#departamento_id').val(response.departamento_id);
                    $('#municipio_id').val(response.id);
                    $('#modal').modal('show');
                }
            }
    );
}

function actualizar() {
    var isvalid = validar();
    if (isvalid.valid) {
        $.ajax(
                "/municipio/actualizar",
                {
                    method: 'post',
                    data: $('#municipio_form').serializeArray(),
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