function initFormularioEdicion() {
    var id = $('#viaje_id').val();
    $('#guardar_viaje_button').attr('onClick', 'actualizar();');
    if (id != null)
    {
        $.ajax(
                "/viaje/info",
                {
                    method: 'get',
                    data: {id: id},
                    async: false,
                    success: function(response)
                    {
                        $('#nombre').val(response.nombre);
                        $('#fecha_salida').val(response.fecha_salida);
                        $('#hora_salida').val(response.hora_salida);
                        $('#fecha_regreso').val(response.fecha_regreso);
                        $('#hora_regreso').val(response.hora_regreso);
                        destinos = response.destinos;
                        actividades = response.actividades;
                        guias = response.guias;
                        recargarListas();
                        $('#busqueda_form').hide();
                    }
                }
        );
    }
}