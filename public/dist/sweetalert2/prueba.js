$(document).ready(function () {
    if (document.getElementById('errores')) {
        const error = document.getElementById('errores').value;
        if (error === "No se registró, ya existe una cita pendiente en el servicio seleccionado.") {
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
                title: "Cancelado",
                icon: 'error',
                title: error,
                customClass: 'swal-pop',
            });
        }else if (error != '.') {
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
                title: 'La habitación ' + error + ' cambió de estado.',
                customClass: 'swal-pop',
            });
        }

    }

});
