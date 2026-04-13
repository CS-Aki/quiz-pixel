$(document).ready(function () {
    const { csrfToken, updateUrl, passwordUrl, destroyUrl } = window.ProfileConfig;

    $('#avatarInput').on('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            $('#avatarPreview').html(`<img src="${e.target.result}" class="w-full h-full object-cover rounded-full"/>`);
        };
        reader.readAsDataURL(file);
    });

    function saveProfile() {
        $('.field-error').text('');
        $('#profileSuccess').addClass('hidden');
        $('#profileError').addClass('hidden');

        const formData = new FormData($('#profileForm')[0]);

        $.ajax({
            url: updateUrl,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            success: () => {
                $('#profileSuccess').removeClass('hidden');
            },
            error: (xhr) => {
                const data = xhr.responseJSON || {};
                if (xhr.status === 422) {
                    $.each(data.errors || {}, (key, messages) => {
                        $(`#err_${key}`).text(messages[0]);
                    });
                } else {
                    $('#profileError').text(data.message || 'Something went wrong.').removeClass('hidden');
                }
            }
        });
    }

    function changePassword() {
        $('#err_current_password, #err_new_password, #err_confirm_password').text('');
        $('#passwordSuccess').addClass('hidden');
        $('#passwordError').addClass('hidden');

        const newPassword     = $('#newPassword').val();
        const confirmPassword = $('#confirmPassword').val();

        if (newPassword !== confirmPassword) {
            $('#err_confirm_password').text('Passwords do not match.');
            return;
        }

        const payload = {
            new_password: newPassword,
            new_password_confirmation: confirmPassword,
        };

        const currentEl = $('#currentPassword');
        if (currentEl.length) payload.current_password = currentEl.val();

        $.ajax({
            url: passwordUrl,
            method: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify(payload),
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            success: () => {
                $('#passwordSuccess').removeClass('hidden');
                currentEl.val('');
                $('#newPassword, #confirmPassword').val('');
            },
            error: (xhr) => {
                const data = xhr.responseJSON || {};
                if (xhr.status === 422) {
                    $.each(data.errors || {}, (key, messages) => {
                        $(`#err_${key}`).text(messages[0]);
                    });
                } else {
                    $('#passwordError').text(data.message || 'Something went wrong.').removeClass('hidden');
                }
            }
        });
    }

    function deleteAccount() {
        $('#deleteError').addClass('hidden');

        if ($('#deleteConfirmInput').val().trim() !== 'DELETE') {
            $('#deleteError').text('Please type DELETE to confirm.').removeClass('hidden');
            return;
        }

        $.ajax({
            url: destroyUrl,
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            success: () => {
                window.location.href = '/';
            },
            error: (xhr) => {
                const data = xhr.responseJSON || {};
                $('#deleteError').text(data.message || 'Something went wrong.').removeClass('hidden');
            }
        });
    }

    // Expose functions to global scope so onclick="" attributes in the blade still work
    window.saveProfile    = saveProfile;
    window.changePassword = changePassword;
    window.deleteAccount  = deleteAccount;

});