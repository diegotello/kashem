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
                    $('#lista').empty().append(response.lista);
                }
            }
    );
}
function borrar(id) {
    $('#delete-modal-si-button').click(
            function() {
                $.ajax(
                        "/" + controller + "/borrar",
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
    );
    $('#delete-modal').modal('show');
}

function edit(id) {
    $('#form-error-alert').hide();
    $.ajax(
            "/" + controller + "/info",
            {
                method: 'get',
                data: {id: id},
                success: function(response)
                {
                    $.each(response, function(k, v) {
                        if (k !== 'pais_id' && k !== 'departamento_id' && k !== 'municipio_id')
                        {
                            $('#' + k).val(v);
                        }
                    });
                    switch (controller) {
                        case 'cliente':
                            $('#modal-title').text(response.primer_nombre + ' ' + response.primer_apellido);
                            $('#pais_id').val(response.pais_id);
                            cambioPais($('#pais_id'), false);
                            $('#departamento_id').val(response.departamento_id);
                            cambioDepartamento($('#departamento_id'), false);
                            $('#municipio_id').val(response.municipio_id);
                            break;
                        case 'departamento':
                            $('#modal-title').text(response.nombre);
                            $('#pais_id').val(response.pais_id);
                            break;
                        case 'destino':
                            $('#modal-title').text(response.nombre);
                            $('#pais_id').val(response.pais_id);
                            cambioPais($('#pais_id'), false);
                            $('#departamento_id').val(response.departamento_id);
                            cambioDepartamento($('#departamento_id'), false);
                            $('#municipio_id').val(response.municipio_id);
                            break;
                        case 'municipio':
                            $('#modal-title').text(response.nombre);
                            $('#pais_id').val(response.pais_id);
                            cambioPais($('#pais_id'), false);
                            $('#departamento_id').val(response.departamento_id);
                            break;
                        default:
                            $('#modal-title').text(response.nombre);
                            break;
                    }
                    $('#' + controller + '_id').val(response.id);
                    $('#modal').modal('show');
                }
            }
    );
}

function actualizar() {
    var isvalid = validar();
    if (isvalid.valid) {
        $.ajax(
                "/" + controller + "/actualizar",
                {
                    method: 'post',
                    data: $('#' + controller + '_form').serializeArray(),
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