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
                            $('#' + controller + '_form').find("input[type=password], input[type=text], textarea, select").val("");
                            if (!$('#mantener_pagina_checkbox').is(':checked')) {
                                window.location.assign("/" + controller);
                            }
                            else
                            {
                                setTimeout(function() {
                                    $('#success-alert').hide();
                                }, 1500);
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