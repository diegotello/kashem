function guardar() {
    $.ajax(
            "/viaje/finalizar",
            {
                method: 'post',
                data: $('#terminar_viaje_form').serializeArray(),
                success: function(response)
                {
                    if (response.ok) {
                        $('#error-alert').hide();
                        $('#success-alert').show();
                        setTimeout(function() {
                            $('#success-alert').hide();
                            window.location.assign("/viaje");
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