import $ from 'jquery';
import Swal from 'sweetalert2';

$(document).ready(function () {

    $("#signUpBtn").on('click', function () {
        clearErrors();

        const firstName = $('#firstName').val().trim();
        const lastName = $('#lastName').val().trim();
        const email = $('#email').val().trim();
        const username = $('#username').val().trim();
        const password = $('#password').val();
        const confirmPassword = $('#confirmPassword').val();

        let isValid = validateFields(firstName,lastName,email,username,password,confirmPassword);
        
        if (!isValid) return;

        $.ajax({
            url: '/register-user',
            type: 'POST',
            data: {
                firstName,
                lastName,
                email,
                username,
                password,
                confirmPassword,
            },
            success: function (response) {
                console.log(response);

                Swal.fire({
                    title: 'Success!',
                    text: 'Registration successful!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                     window.location.href = '/login';
                });
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

function validateFields(firstName,lastName,email,username,password,confirmPassword){
        let isValid = true;

        if (!firstName) {
            showError('firstName', 'First name is required');
            isValid = false;
        }

        if (!lastName) {
            showError('lastName', 'Last name is required');
            isValid = false;
        }

        // First Name
        if (!firstName) {
            showError('firstName', 'First name is required');
            isValid = false;
        } else if (!validateName(firstName)) {
            showError('firstName', 'Only letters are allowed');
            isValid = false;
        }

        // Last Name
        if (!lastName) {
            showError('lastName', 'Last name is required');
            isValid = false;
        } else if (!validateName(lastName)) {
            showError('lastName', 'Only letters are allowed');
            isValid = false;
        }

        if (!validateEmail(email)) {
            showError('email', 'Enter a valid email');
            isValid = false;
        }

        if (username.length < 3) {
            showError('username', 'Username must be at least 3 characters');
            isValid = false;
        }

        if (password.length < 6) {
            showError('password', 'Password must be at least 6 characters');
            isValid = false;
        }

        // Confirm Password
        if (password !== confirmPassword) {
            showError('confirmPassword', 'Passwords do not match');
            isValid = false;
        }

        return isValid;
}

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

function validateName(name) {
    const regex = /^[A-Za-z\s]+$/;
    return regex.test(name);
}