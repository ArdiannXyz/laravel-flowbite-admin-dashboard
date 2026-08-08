<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Intercept form submissions for Delete and Edit
    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (!form || !(form instanceof HTMLFormElement)) return;

        // Skip if already confirmed
        if (form.dataset.swalConfirmed === 'true') return;

        // Check if form is a Delete Form
        const methodInput = form.querySelector('input[name="_method"]');
        const isDelete = (methodInput && methodInput.value.toUpperCase() === 'DELETE') || form.hasAttribute('data-confirm-delete');
        
        // Check if form is an Edit Form
        const isEdit = form.hasAttribute('data-confirm-edit');

        if (isDelete) {
            e.preventDefault();
            e.stopPropagation();

            const message = form.getAttribute('data-confirm-delete') || 'Data yang dihapus tidak dapat dikembalikan!';
            const title = form.getAttribute('data-confirm-title') || 'Konfirmasi Hapus Data';

            Swal.fire({
                title: title,
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-xl shadow-2xl dark:bg-gray-800 dark:text-white',
                    title: 'text-lg font-bold text-gray-900 dark:text-white',
                    htmlContainer: 'text-sm text-gray-600 dark:text-gray-300'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.dataset.swalConfirmed = 'true';
                    form.submit();
                }
            });
        } else if (isEdit) {
            e.preventDefault();
            e.stopPropagation();

            const message = form.getAttribute('data-confirm-edit') || 'Apakah Anda yakin ingin menyimpan perubahan data ini?';
            const title = form.getAttribute('data-confirm-title') || 'Konfirmasi Simpan Perubahan';

            Swal.fire({
                title: title,
                text: message,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-xl shadow-2xl dark:bg-gray-800 dark:text-white',
                    title: 'text-lg font-bold text-gray-900 dark:text-white',
                    htmlContainer: 'text-sm text-gray-600 dark:text-gray-300'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.dataset.swalConfirmed = 'true';
                    form.submit();
                }
            });
        }
    });

    // Session Flash Alerts Toast
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: @json(session('success')),
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            customClass: {
                popup: 'rounded-xl shadow-lg dark:bg-gray-800 dark:text-white'
            }
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: @json(session('error')),
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            customClass: {
                popup: 'rounded-xl shadow-lg dark:bg-gray-800 dark:text-white'
            }
        });
    @endif

    @if(session('info'))
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: @json(session('info')),
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true
        });
    @endif
});
</script>
