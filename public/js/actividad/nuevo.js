function guardar() {
    var isvalid = validar();
    if (isvalid.valid) {
        $.ajax(
                "/actividad/guardar",
                {
                    method: 'post',
                    data: $('#actividad_form').serializeArray(),
                    success: function(response)
                    {
                        if (response.ok) {
                            $('#error-alert').hide();
                            $('#success-alert').show();
                            $('#actividad_form').find("input[type=text], textarea").val("");
                            if (!$('#mantener_pagina_checkbox').is(':checked')) {
                                window.location.assign("/actividad");
                            }
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
    else
    {
        $('#success-alert').hide();
        $('#error-alert').empty().append(isvalid.info).show();
    }
}