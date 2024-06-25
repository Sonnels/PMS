$(document).ready(function () {
    if (document.getElementById('registro')) {
        const error = document.getElementById('registro').value;
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            Toast.fire({
                icon: 'success',
                title: 'La Habitación Nro ' + error + ' acaba de cambiar de estado Satisfactoriamente.',
                customClass: 'swal-pop',
            });
    }
});
