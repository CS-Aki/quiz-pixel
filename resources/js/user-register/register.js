import $ from 'jquery';

$(document).ready(function () {
    $("#signUpBtn").on('click', function() {
        console.log("clicking");
        
        const firstName = $('#firstName').val();
        const lastName = $('#lastName').val();
        const email = $('#email').val();
        const username = $('#username').val();
        const password = $('#password').val();
        const confirmPassword = $('#confirmPassword').val();

        $.ajax({
            url: '/register-user',
            type: 'POST',
            data: {
                firstName: firstName,
                lastName: lastName,
                email: email,
                username: username,
                password: password,
                confirmPassword: confirmPassword,
            },
            success: function (response) {
                console.log(response);
            },
            error: function (xhr) {

            }
        });
    });
});