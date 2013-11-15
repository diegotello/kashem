function guardar() {
    var isvalid = validar();
    if (isvalid.valid) {
        $.ajax(
                "/" + controller + "/guardar",
                {
                    method: 'post',
                    data: $('#' + controller + '_form').serializeArray(),
                    success: function(response)
                    {
                        if (response.ok) {
                            $('#error-alert').hide();
                            $('#success-alert').show();
                            $('#' + controller + '_form').find("input[type=text], textarea").val("");
                            if (!$('#mantener_pagina_checkbox').is(':checked')) {
                                window.location.assign("/" + controller);
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