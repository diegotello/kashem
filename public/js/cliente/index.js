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