import $ from 'jquery';
import Swal from 'sweetalert2';

$(document).ready(function () {
    $('#signInBtn').on('click', function () {
        clearErrors();
        const email = $('#email').val();
        const password = $('#password').val();

        let isValid = true;

        if (!validateEmail(email)) {
            showError('email', 'Enter a valid email');
            isValid = false;
        }

        if (!isValid) return;

        $.ajax({
            url: '/login-user',
            type: 'POST',
            data: {
                email: email,
                password: password
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Login Successful!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = '/user-dashboard';
                    });
                } else {
                     showError(response.field, response.message);
                }
            },
            error: function (xhr) {
                Swal.fire({
                    title: 'Error!',
                    text: xhr.responseJSON?.message || 'Something went wrong',
                    icon: 'error'
                });
            }
        });
    });
});

function showError(field, message) {
    $(`#${field}`).addClass('border-red-500');
    $(`#${field}Error`).text(message);
}

function clearErrors() {
    $('.error').text('');
    $('input').removeClass('border-red-500');
}

function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}