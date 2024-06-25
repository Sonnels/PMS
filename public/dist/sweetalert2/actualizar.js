$(document).ready(function () {
    $('.actualizar_ajax').unbind().click(function () {
        var $button = $(this);

        var row = $(this).parents('tr');
        var $form = $(this).parents('form');
        var $url = $form.attr('action');
        var $dat = $form.serialize();
        var $method = $form.attr('method');

        var data_nombre = $button.attr('data-nombre').split('_');

        Swal.fire({

                title             : "Necesitamos de tu Confirmación",
                html              : "Se anulará el ingreso extra con los siguientes datos:<br>" +
                                    "<table class='table'><tr><td align='left'>Importe</td><td>" + data_nombre[0] + "</td><tr>"
                                    + "<tr><td align='left'>Recibido de </td><td>"+ data_nombre[1] +"</td></tr>"
                                    + "<tr><td align='left'>Motivo: </td><td>" + data_nombre[2] +"</td></tr>"
                                    +"</table>"
                                    +"<span style='color: #36BE80; font-weight: bold'>¿Está Usted de Acuerdo?</span>",
                icon              : "warning",
                cancelButtonClass : 'btn btn-danger',
                confirmButtonClass: 'btn btn-success',
                cancelButtonColor : '#DD6B55',
                confirmButtonColor: '#3085d6',
                confirmButtonText : "¡Aceptar!",
                cancelButtonText  : "Cancelar",
                showCancelButton  : true,
                closeOnConfirm    : false,
                closeOnCancel     : false,
                // customClass: 'swal-wide',
        })
        .then((value) => {
          if (value.isConfirmed) {
            $.ajax({
                url     : $url,
                type    : $method,
                dataType: 'json',
                data    : $dat,
                success : function ($data) {
                    if ($data.success == true) {

                        row.fadeOut();
                        // $("#table_refresh").load(" #table_refresh");
                        const Toast = Swal.mixin ({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            onOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                              }
                        });
                        Toast.fire ({
                            icon: 'success',
                            title: $data.message,
                            customClass: 'swal-pop',
                        })

                    } else {
                            const Toast = Swal.mixin ({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                onOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                  }
                            });
                            Toast.fire ({
                                title: "Cancelado",
                                icon: 'error',
                                title: $data.message,
                                customClass: 'swal-pop',
                            })


                    }
                }
            });

            } else {

            // Swal.fire({
            //     title             : "Cancelado",
            //     text              : "Tu registro está seguro :)",
            //     type              : "error",
            //     timer             : 2000,
            //     confirmButtonColor: '#3085d6'
            // });

            const Toast = Swal.mixin ({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                  }
            });
            Toast.fire ({
                title: "Cancelado",
                icon: 'error',
                title: 'Se canceló la eliminación.',
                customClass: 'swal-pop',
            })

            }
            $button.children('i').attr('class', 'fa fa-trash').removeAttr('disabled');


        });

        return false;
    })
});
