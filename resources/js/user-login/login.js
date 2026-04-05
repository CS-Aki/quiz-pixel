import $ from 'jquery';

$(document).ready(function () {
    $('#signInBtn').on('click', function () {
       const username = $('#username').val();
       const password = $('#password').val();

        $.ajax({
            url: '/login-user',
            type: 'POST',
            data: {
                username: username,
                password: password
            },
            success: function (response) {
                console.log(response);
            },
            error: function (xhr) {
                console.log('Error:', xhr);
                // $('#ajaxResult').html(`
                //     <div class="text-red-600">
                //         AJAX failed
                //     </div>
                // `);
            }
        });
    });
});