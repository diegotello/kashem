function borrar(id) {
    $.ajax(
            "/usuario/borrar",
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
            "/usuario/info",
            {
                method: 'get',
                data: {id: id},
                success: function(response)
                {
                    $('#modal-title').text(response.nombre);
                    $.each(response, function(k, v) {
                        $('#' + k).val(v);
                    });
                    $('#usuario_id').val(response.id);
                    $('#modal').modal('show');
                }
            }
    );
}

function actualizar() {
    var isvalid = validar();
    if (isvalid.valid) {
        $.ajax(
                "/usuario/actualizar",
                {
                    method: 'post',
                    data: $('#usuario_form').serializeArray(),
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