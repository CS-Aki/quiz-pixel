import $ from 'jquery';
import Swal from 'sweetalert2';

$(document).ready(function () {

    // ──────────────────────────────────────────
    // Set Password Modal - Submit
    // ──────────────────────────────────────────
    $("#savePasswordBtn").on('click', function () {
        clearPasswordErrors();

        const password        = $('#modalPassword').val();
        const confirmPassword = $('#modalPasswordConfirm').val();

        const isValid =     (password, confirmPassword);
        if (!isValid) return;

        $.ajax({
            url: '/set-password',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                password,
                password_confirmation: confirmPassword,
            },
            success: function (response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Password set successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.reload();
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

    // ──────────────────────────────────────────
    // Logout
    // ──────────────────────────────────────────
    $("#logoutBtn").on('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Logging out...',
            text: 'Are you sure you want to logout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, logout',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#00b074',
        }).then((result) => {
            if (result.isConfirmed) {
                $('#logoutForm').submit();
            }
        });
    });

});

// ──────────────────────────────────────────
// Password Validation (from registration.js)
// ──────────────────────────────────────────
function validatePasswordFields(password, confirmPassword) {
    let isValid = true;

    if (!password) {
        showPasswordError('modalPassword', 'Password is required');
        isValid = false;
    } else if (password.length < 6) {
        showPasswordError('modalPassword', 'Password must be at least 6 characters');
        isValid = false;
    }

    if (!confirmPassword) {
        showPasswordError('modalPasswordConfirm', 'Please confirm your password');
        isValid = false;
    } else if (password !== confirmPassword) {
        showPasswordError('modalPasswordConfirm', 'Passwords do not match');
        isValid = false;
    }

    return isValid;
}

function showPasswordError(field, message) {
    $(`#${field}`).addClass('border-red-500');
    $(`#${field}Error`).text(message);
}

function clearPasswordErrors() {
    $('#modalPassword, #modalPasswordConfirm').removeClass('border-red-500');
    $('#modalPasswordError, #modalPasswordConfirmError').text('');
}