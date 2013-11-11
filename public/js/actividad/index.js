function borrar(id) {
    $.ajax(
            "/actividad/borrar",
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
            "/actividad/info",
            {
                method: 'get',
                data: {id: id},
                success: function(response)
                {
                    $('#modal-title').text(response.nombre);
                    $.each(response, function(k, v) {
                        $('#' + k).val(v);
                    });
                    $('#actividad_id').val(response.id);
                    $('#modal').modal('show');
                }
            }
    );
}

function actualizar() {
    var isvalid = validar();
    if (isvalid.valid) {
        $.ajax(
                "/actividad/actualizar",
                {
                    method: 'post',
                    data: $('#actividad_form').serializeArray(),
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