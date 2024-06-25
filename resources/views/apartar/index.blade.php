{{-- <link href='https://unpkg.com/@fullcalendar/core@4.3.1/main.min.css' rel='stylesheet' />
<link href='https://unpkg.com/@fullcalendar/timeline@4.3.0/main.min.css' rel='stylesheet' />
<link href='https://unpkg.com/@fullcalendar/resource-timeline@4.3.0/main.min.css' rel='stylesheet' /> --}}
<link rel="stylesheet" href="{{ asset('fullcalendar/core@4.3.1/main.min.css') }}">
<link rel="stylesheet" href="{{ asset('fullcalendar/timeline@4.3.0/main.min.css') }}">
<link rel="stylesheet" href="{{ asset('fullcalendar/resource-timeline@4.3.0/main.min.css') }}">
<style>
    .fc-toolbar {
        text-transform: uppercase;
    }
</style>
@extends('layout.admin')
@section('Contenido')
    @include('reserva.registro.cliente_modal')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="row ">
        <div class="col-md-12">
            <div id='calendar'></div>
        </div>
    </div>
    @include('apartar.create')
    @include('apartar.edit')
    @include('apartar.detail')
    @push('scripts')
        {{-- <script src='https://unpkg.com/@fullcalendar/core@4.3.1/main.min.js'></script> --}}
        {{-- <script src='https://unpkg.com/@fullcalendar/interaction@4.3.0/main.min.js'></script> --}}
        {{-- <script src='https://unpkg.com/@fullcalendar/timeline@4.3.0/main.min.js'></script> --}}
        {{-- <script src='https://unpkg.com/@fullcalendar/resource-common@4.3.1/main.min.js'></script> --}}
        {{-- <script src='https://unpkg.com/@fullcalendar/resource-timeline@4.3.0/main.min.js'></script> --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.3.1/locales/es.js"></script> --}}

        <script src="{{ asset('fullcalendar/core@4.3.1/main.min.js') }}"></script>
        <script src="{{ asset('fullcalendar/interaction@4.3.0/main.min.js') }}"></script>
        <script src="{{ asset('fullcalendar/timeline@4.3.0/main.min.js') }}"></script>
        <script src="{{ asset('fullcalendar/resource-common@4.3.1/main.min.js') }}"></script>
        <script src="{{ asset('fullcalendar/resource-timeline@4.3.0/main.min.js') }}"></script>

        <script src="{{ asset('fullcalendar/core@4.3.1/es.js') }}"></script>
        <script src="{{ asset('moment/moment.main.js') }}"></script>
        <script src="{{ asset('moment/moment-timezone.js') }}"></script>
        <script>
            const data = @json($habitaciones);

            var calendar = null;
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                calendar = new FullCalendar.Calendar(calendarEl, {
                    // El enlace aparecerá en la esquina inferior izquierda si la clave del producto no está configurada
                    schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                    // 'interacción': evento de arrastre
                    plugins: ['interaction', 'resourceTimeline'],
                    // Establecer formato de hora utc
                    // timeZone: 'UTC',
                    selectable: true,
                    // Establecer el año de visualización predeterminado resourceTimelineDay, mes resourceTimelineWeek, day resourceTimelineMonth
                    defaultView: 'resourceTimelineMonth',
                    // Establecer chino
                    locale: 'es',
                    // Establecer la altura del calendario
                    height: 650,
                    // Establecer el año y mes iniciales
                    //defaultDate: '2019-06-12',
                    editable: true,

                    // Cambia el botón de año y mes
                    header: {
                        // botón izquierdo
                        left: 'prev,next',
                        center: 'title',
                        // Controlar año, mes y día
                        right: 'resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth'
                        // right: 'resourceTimelineMonth'
                    },

                    eventClick: function(info) {
                        console.log(info);
                        // Verificamos si el registro es una reserva o alquiler
                        if (info.event.extendedProps.estado === 'reserva') {
                            $("#idApartar").val(info.event.id);
                            $("#Num_Hab_e").val(info.event.extendedProps.Num_Hab);
                            $("#FechReserva_e").val(moment(info.event.start).format('YYYY-MM-DD'));
                            $("#HoraEntrada_e").val(moment(info.event.start).format('HH:mm:ss'));
                            $("#FechSalida_e").val(moment(info.event.end).format('YYYY-MM-DD'));
                            $("#horaSalida_e").val(moment(info.event.end).format('HH:mm:ss'));
                            $("#IdCliente_e").val(info.event.extendedProps.IdCliente);
                            $('#IdCliente_e').selectpicker('refresh');
                            // Condicional para mostrar el botón de alquilar en el formulario edit
                            var b_alquilar = document.getElementById("b_alquilar");
                            const fechaActual = new Date();
                            if (moment(fechaActual).format('YYYY-MM-DD') === moment(info.event.start)
                                .format('YYYY-MM-DD')) {
                                b_alquilar.style.display = "block";
                            } else {
                                b_alquilar.style.display = "none";
                            }
                            console.log(info.event.end);
                            $("#agenda_modal_edit").modal();
                        } else {
                            $("#Num_Hab_d").val(info.event.extendedProps.Num_Hab);
                            $("#FechReserva_d").val(moment(info.event.start).format('YYYY-MM-DD'));
                            $("#HoraEntrada_d").val(moment(info.event.start).format('HH:mm:ss'));
                            $("#FechSalida_d").val(moment(info.event.end).format('YYYY-MM-DD'));
                            $("#horaSalida_d").val(moment(info.event.end).format('HH:mm:ss'));
                            $("#IdCliente_d").val(info.event.extendedProps.IdCliente);
                            $("#agenda_modal_detail").modal();
                            console.log(info.event.end);
                        }

                    },
                    eventResize: function(info) {
                        if (info.event.extendedProps.estado === 'alquiler') {
                            calendar.refetchEvents();
                        } else {
                            update_data(info);
                        }

                    },
                    eventDrop: function(info) {
                        if (info.event.extendedProps.estado === 'alquiler') {
                            calendar.refetchEvents();
                        } else {
                            update_data(info);
                        }
                    },
                    // eventDragStop: function(info){
                    //     console.log(info.event.extendedProps.Num_Hab);
                    //     alert("dss")
                    // },
                    select: function(arg) {
                        var view = calendar.view;

                        var fechaActual = moment(new Date()).format('YYYY-MM-DD 00:00:00');
                        var fechaSeleccionada = moment(arg.start).format('YYYY-MM-DD HH:mm:ss');
                        console.log(fechaActual);
                        if (fechaSeleccionada >= fechaActual) {
                            // var new_date = moment(arg.start, "YYYY-MM-DD").add(1, 'days');
                            // let fecIn = moment(new_date).format("YYYY-MM-DD");
                            let fecIn = moment(arg.start).format("YYYY-MM-DD");
                            let horIn = moment(arg.start).format("HH:mm:ss");
                            let fecOut = moment(arg.end).format("YYYY-MM-DD");

                            let horOut = moment(arg.end).format("HH:mm:ss");
                            if (view.type === 'resourceTimelineMonth') {
                                horIn = "09:00:00";
                                horOut = "22:00:00";
                                var new_date = moment(arg.end, "YYYY-MM-DD").subtract(1, 'days');
                                fecOut = moment(new_date).format("YYYY-MM-DD");
                            }
                            $("#Num_Hab").val(arg.resource.id);

                            $("#FechReserva").val(fecIn);
                            $("#HoraEntrada").val(horIn);
                            $("#FechSalida").val(fecOut);
                            $("#horaSalida").val(horOut);

                            $("#agenda_modal").modal();
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Advertencia',
                                html: 'Seleccione una fecha posterior o igual a la fecha actual <br> ' +
                                    moment(new Date()).format('DD/MM/YYYY'),
                            })
                        }
                    },
                    // resourceLabelText: 'Habitación',
                    resourceAreaWidth: '20%',
                    resourceColumns: [{
                            labelText: 'Habitación',
                            field: 'title',
                        },
                        {
                            labelText: 'Tipo',
                            field: 'tipo',
                        }
                    ],
                    resources: data,
                    events: 'listar',
                });
                calendar.render();
            });
        </script>
        <script>
            function guardar() {
                var fd = new FormData(document.getElementById("formulario_agenda"));
                console.log(fd);
                $.ajax({
                    url: "/apartar/guardar",
                    type: "POST",
                    data: fd,
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType,
                    success: function(e) {
                        if (e.success === true) {
                            // Mandamos un Toast
                            toast(e, 'success');
                            // Refrescamos Calendario
                            calendar.refetchEvents();
                            // Limpiamos Campo y cerramos modal
                            limpiar();
                        } else if (e.status === "error") {
                            toast(e, 'error');
                        }
                    },
                    error: function(jqXhr, json, errorThrown) {
                        limpiar_campos();
                        var errors = jqXhr.responseJSON;
                        var errorsHtml = '';

                        $.each(errors['errors'], function(index, value) {
                            console.log(index);
                            $("#" + index).html(value);
                            // errorsHtml += '<ul class="list-group"><li class="list-group-item alert alert-danger">' + value + '</li></ul>';
                        });
                        //I use SweetAlert2 for this
                        // Swal.fire({
                        //     title: "Error " + jqXhr.status + ': ' + errorThrown,// this will output "Error 422: Unprocessable Entity"
                        //     html: errorsHtml,
                        //     width: 'auto',
                        //     confirmButtonText: 'Try again',
                        //     cancelButtonText: 'Cancel',
                        //     confirmButtonClass: 'btn',
                        //     cancelButtonClass: 'cancel-class',
                        //     showCancelButton: true,
                        //     closeOnConfirm: true,
                        //     closeOnCancel: true,
                        //     type: 'error'
                        // }, function(isConfirm) {
                        //     if (isConfirm) {
                        //         $('#openModal').click();//this is when the form is in a modal
                        //     }
                        // });
                    }

                })


            }
            // ----------------------------------------------------
            function editar() {
                var fd = new FormData(document.getElementById("formulario_agenda_edit"));
                $.ajax({
                    url: "/apartar/editar",
                    type: "POST",
                    data: fd,
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    success: function(e) {
                        if (e.success === true) {
                            // Mandamos un Toast
                            toast(e, 'success');

                            // Limpiamos Campo y cerramos modal
                            limpiar_edit();
                            // Refrescamos Calendario
                            calendar.refetchEvents();
                        } else if (e.status === "error") {
                            toast(e, 'error');
                        }
                    }

                })
            }


            // -----------------------------------------------
            function update_data(info) {
                var fd = new FormData(document.getElementById("formulario_agenda_edit"));
                fd.append("idApartar", info.event.id);
                fd.append("FechReserva", moment(info.event.start.toISOString()).format(
                    "YYYY-MM-DD"));
                fd.append("HoraEntrada", moment(info.event.start.toISOString()).format(
                    "HH:mm:ss"));
                fd.append("FechSalida", moment(info.event.end.toISOString()).format(
                    "YYYY-MM-DD"));
                fd.append("horaSalida", moment(info.event.end.toISOString()).format(
                    "HH:mm:ss"));
                if (info.newResource != null) {
                    fd.append("Num_Hab", info.newResource.id);
                } else {
                    fd.append("Num_Hab", info.event.extendedProps.Num_Hab);
                }
                fd.append("IdCliente", info.event.extendedProps.IdCliente);

                // console.log(info.newResource.id);
                // console.log(fd);
                // console.log(info.event.extendedProps.estado)
                // edit(fd);
                $.ajax({
                    url: "/apartar/editar",
                    type: "POST",
                    data: fd,
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    success: function(e) {
                        if (e.success === true) {
                            // Mandamos un Toast
                            toast(e, 'success');

                            // Limpiamos Campo y cerramos modal
                            limpiar_edit();
                            // Refrescamos Calendario

                        } else if (e.status === "error") {
                            toast(e, 'error');
                        }
                        calendar.refetchEvents();

                    }

                })
            }
            // ------------------------------------------------------------
            function eliminar() {
                var fd = new FormData(document.getElementById("formulario_agenda_edit"));

                $.ajax({
                    url: "/apartar/eliminar",
                    type: "POST",
                    data: fd,
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    success: function(e) {
                        if (e.success === true) {
                            // Mandamos un Toast
                            toast(e, 'success');
                            // Limpiamos Campo y cerramos modal
                            limpiar_edit();
                            // Refrescamos Calendario

                        } else if (e.status === "error") {
                            toast(e, 'error');
                        }
                        calendar.refetchEvents();

                    }

                })
            }
            // -------------------------------------------------------------
            function alquilar() {
                var fd = new FormData(document.getElementById("formulario_agenda_edit"));

                var url = '{{ route('alq_reserva', ':id') }}';
                url = url.replace(':id', fd.get('idApartar'));
                window.location.href = url;
                // var d = '{{ URL::action('UsuarioController@show', 0) }}' + data_nombre
                // window.location.href = d;
                // $.ajax({
                //     url: "/apartar/alquilar",
                //     type: "POST",
                //     data: fd,
                //     processData: false,
                //     contentType: false,
                //     success: function(e) {
                //         if (e.success === true) {
                //             toast(e, 'success');
                //             limpiar_edit();
                //             calendar.refetchEvents();
                //         } else if (e.status === "error") {
                //             toast(e, 'error');
                //         }
                //     }

                // })
            }

            // -------------------------------------------------------------
            function toast(e, type) {
                const Toast = Swal.mixin({
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
                Toast.fire({
                    icon: type,
                    title: e.message,
                    customClass: 'swal-pop',
                })
            }


            // -------------------------------------------------------------
            function limpiar() {
                $("#agenda_modal").modal('hide');
                $("#IdCliente").val("");
            }

            function limpiar_edit() {
                $("#agenda_modal_edit").modal('hide');
                $("#IdCliente_message_e").val("");
            }

            function limpiar_campos() {
                $("#IdCliente").html("");
            }

            // Para el Formulario del Cliente
            const selectCliente = document.getElementById('selectCliente');
            const selectCliente_e = document.getElementById('selectCliente_e');

            function obtenerClientes(idCliente = '') {
                let ruta = '{{ route('obtenerClientes') }}';
                ruta = ruta + `?IdCliente=${idCliente}`;
                console.log(ruta)
                fetch(ruta)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            selectCliente.innerHTML = data.select;
                            selectCliente_e.innerHTML = data.select2;
                            $('#IdCliente').selectpicker('refresh');
                            $('#IdCliente_e').selectpicker('refresh');
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener los clientes:', error);
                    });
            }
            obtenerClientes();

            function limpiaValidacionCliente() {
                document.getElementById('idTipDoc-error').innerHTML = "";
                document.getElementById('NumDocumento-error').innerHTML = "";
                document.getElementById('Nombre-error').innerHTML = "";
                document.getElementById('Correo-error').innerHTML = "";
                document.getElementById('Celular-error').innerHTML = "";
                document.getElementById('Direccion-error').innerHTML = "";
                document.getElementById('nroMatricula-error').innerHTML = "";
            }

            function limpiarValorCliente() {
                document.getElementById('idTipDoc').value = "";
                document.getElementById('NumDocumento').value = "";
                document.getElementById('Nombre').value = "";
                document.getElementById('Correo').value = "";
                document.getElementById('Celular').value = "";
                document.getElementById('Direccion').value = "";
                document.getElementById('nroMatricula').value = "";
            }

            let inputNombre = document.getElementById('Nombre');
            inputNombre.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });

            document.querySelector('#formCliente').addEventListener('submit', function(e) {
                let form = this;
                let fd = new FormData(form);
                e.preventDefault();
                let myButton = document.getElementById('enviarCliente');
                myButton.disabled = true;
                myButton.style.opacity = 0.7;
                myButton.textContent = 'Procesando ...';

                // Realizar la solicitud AJAX
                fetch("{{ route('guardarCliente') }}", {
                        method: 'POST',
                        body: fd,
                    })
                    .then(response => response.json())
                    .then(data => {
                        limpiaValidacionCliente();
                        if (data.success) {
                            limpiarValorCliente();
                            obtenerClientes(data.idCliente);
                            Snackbar.show({
                                text: 'Cliente guardado exitosamente',
                                actionText: 'CERRAR',
                                pos: 'bottom-right',
                                actionTextColor: '#27AE60',
                                duration: 6000
                            });
                            $('#modal-add').modal('hide');
                            myButton.disabled = false;
                            myButton.style.opacity = 1;
                            myButton.textContent = 'Guardar';
                        } else {
                            data.errors.forEach(error => {
                                document.getElementById(error.field + '-error').innerHTML = error.message;
                            });
                            myButton.disabled = false;
                            myButton.style.opacity = 1;
                            myButton.textContent = 'Guardar';
                        }

                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        </script>
    @endpush
@endsection
