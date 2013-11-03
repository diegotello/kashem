function login()
{
    $.ajax(
    "/auth/login",
        {
            method:'post',
            data: {
                username:$('#login_username').val(),
                password:$('#login_password').val()
                },
            dataType: 'json',
            success: function(response)
                    {
                        console.log(response);
                        if(response.success)
                        {
                            $('#login_form_alert').hide();
                            window.location='/index';
                        }
                        else
                        {
                            $('#login_form_alert')
                                .empty()
                                .append(response.info)
                                .show();
                        }
                    }
        }
    );
}