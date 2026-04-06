import { $ } from "jquery";
import Swal from 'sweetalert2';

$(document).ready(function () {
    $(document).on('click', '.getQuizCode', function () {
        let code = $(this).siblings('.quiz-code').val();

        navigator.clipboard.writeText(code).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Copied!',
                text: `Quiz code "${code}" copied to clipboard`,
                timer: 1500,
                showConfirmButton: false
            });
        }).catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Failed to copy',
                text: 'Please copy manually.'
            });
        });
    });

    $(document).on('click', '.delete-quiz-btn', function (e) {
        e.preventDefault();

        let form = $(this).closest('.delete-quiz-form');

         Swal.fire({
            title: 'Are you sure?',
            text: "This question will be permanently deleted.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function () {
                        form.closest('.quiz-card').remove();
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);

                        Swal.fire(
                            'Error!',
                            'Failed to delete question.',
                            'error'
                        );
                    }
                });
            }
        });
        console.log("test");
    });
});