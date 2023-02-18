$(document).ready(function() {


    var table = $('#table_parqueadero').DataTable({
        responsive: true,
        dom: "Bfrtip",
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    });

    $('#fecha_hora_ingreso_modal').datetimepicker();
    $('#fecha_hora_salida_modal').datetimepicker();

    $("#por_horas").prop("checked", true);
    $("#por_mes").bootstrapToggle('off');
    $("#por_medio").bootstrapToggle('off');
    $("#por_dia").bootstrapToggle('off');

    $("#por_horas").change(function() {

        if ($("#por_horas").is(":checked") == true) {
            $("#por_mes").bootstrapToggle('off');
            $("#por_medio").bootstrapToggle('off');
            $("#por_dia").bootstrapToggle('off');
        }

    });

    $("#por_mes").change(function() {

        if ($("#por_mes").is(":checked") == true) {
            $('#por_horas').bootstrapToggle('off');
            $("#por_medio").bootstrapToggle('off');
            $("#por_dia").bootstrapToggle('off');
        }

    });

    $("#por_medio").change(function() {

        if ($("#por_medio").is(":checked") == true) {
            $("#por_mes").bootstrapToggle('off');
            $("#por_horas").bootstrapToggle('off');
            $("#por_dia").bootstrapToggle('off');
        }

    });

    $("#por_dia").change(function() {

        if ($("#por_dia").is(":checked") == true) {
            $("#por_mes").bootstrapToggle('off');
            $("#por_medio").bootstrapToggle('off');
            $("#por_horas").bootstrapToggle('off');
        }

    });


    $("#por_horas_modal").change(function() {

        if ($("#por_horas_modal").is(":checked") == true) {
            $("#por_mes_modal").bootstrapToggle('off');
            $("#por_medio_modal").bootstrapToggle('off');
            $("#por_dia_modal").bootstrapToggle('off');
        }

    });

    $("#por_mes_modal").change(function() {

        if ($("#por_mes_modal").is(":checked") == true) {
            $('#por_horas_modal').bootstrapToggle('off');
            $("#por_medio_modal").bootstrapToggle('off');
            $("#por_dia_modal").bootstrapToggle('off');
        }

    });

    $("#por_medio_modal").change(function() {

        if ($("#por_medio_modal").is(":checked") == true) {
            $("#por_mes_modal").bootstrapToggle('off');
            $("#por_horas_modal").bootstrapToggle('off');
            $("#por_dia_modal").bootstrapToggle('off');
        }

    });

    $("#por_dia_modal").change(function() {

        if ($("#por_dia_modal").is(":checked") == true) {
            $("#por_mes_modal").bootstrapToggle('off');
            $("#por_medio_modal").bootstrapToggle('off');
            $("#por_horas_modal").bootstrapToggle('off');
        }

    });



    //funcion guardar
    $('#guardar').click(function() {

        var codigo_ticket = $('#codigo_ticket').val();
        var placa = $('#placa').val();
        var tipo_vehiculo_id = $('#tipo_vehiculo_id').val();
        var usuario_id = $('#usuario_id').val();
        var por_horas = $("#por_horas").is(":checked");
        var por_mes = $("#por_mes").is(":checked");
        var por_medio = $("#por_medio").is(":checked");
        var por_dia = $("#por_dia").is(":checked");

        //funcion guardar
        var validaRequeridos = codigo_ticket != '' && placa != '' && tipo_vehiculo_id != 'null';

        if (validaRequeridos) {

            var datos = "FUNCION=save&codigo_ticket=" + codigo_ticket + "&placa=" + placa + "&tipo_vehiculo_id=" + tipo_vehiculo_id + "&usuario_id=" + usuario_id + "&por_horas=" + por_horas + "&por_mes=" + por_mes + "&por_dia=" + por_dia + "&por_medio=" + por_medio;

            $.ajax({
                url: 'process/parqueadero.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {

                    var json = $.parseJSON(resp);
                    if (json == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Se ingreso el vehículo al parqueadero exitosamente!',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        var url = "./process/parqueadero.process.php?FUNCION=imprimirTicket&placa=" + placa;
                        abrirpopup(url, '250', '500');


                        $('#form')[0].reset();
                        setTimeout(function() { location.reload(); }, 3000);


                    } else if (json == 2) {
                        Swal.fire(
                            'Atencion',
                            'Ya existe un vehiculo con la misma placa en el parqueadero!',
                            'warning'
                        )
                    } else if (json == 3) {
                        Swal.fire(
                            'Atencion',
                            'Ya existe un vehiculo con el mismo ticket en el parqueadero!',
                            'warning'
                        )
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Ocurrio una inconsistencia!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
            })
            return false;

        } else {
            Swal.fire(
                'Atencion',
                'Por favor digite los campos obligatorios!',
                'info'
            )
            return false;
        }
    });

    $("#table_parqueadero").on("click", ".btn-success", function() {

        var parqueadero_id = $(this).parents("tr").find("#parqueadero_id").val();
        var nombre = $(this).parents("tr").find("#nombre_parqueadero").val();

        $("#parqueadero_id").val(parqueadero_id);
        $("#nombre").val(nombre);
    });



    //funcion limpiar
    $('#limpiar').click(function() {

        $('#form')[0].reset();
        $('#buscar').val('');
        $('#base_total').val('');
        $('#impuesto_total').val('');
        $('#descuento_total').val('');
        $('#total').val('');

        $('#detalles').find("tbody").find("tr").remove();

        document.getElementById('detalles_factura').style.display = 'none';

        if (document.getElementById('guardar')) {
            document.getElementById('guardar').disabled = false;
        }

        if (document.getElementById('actualizar')) {
            document.getElementById('actualizar').disabled = true;
        }

        if (document.getElementById('eliminar')) {
            document.getElementById('eliminar').disabled = true;
        }
        return false;
    });

    $('#table_parqueadero').on('click', '.btn-primary', function() {

        var parqueadero_id = $(this).parents("tr").find("#parqueadero_id").val();
        var placa = $(this).parents("tr").find("#placa").val();
        var tipo_vehiculo_id = $(this).parents("tr").find("#tipo_vehiculo_id").val();
        var fecha_hora_ingreso = $(this).parents("tr").find("#fecha_hora_ingreso").val();
        var fecha_hora_salida = $(this).parents("tr").find("#fecha_hora_salida").val();
        var estado = $(this).parents("tr").find("#estado").val();
        var descripcion = $(this).parents("tr").find("#descripcion").val();
        var valor_servicio = $(this).parents("tr").find("#valor_servicio").val();

        var por_mes = $(this).parents("tr").find("#por_mes_mod").val();
        var por_horas = $(this).parents("tr").find("#por_horas_mod").val();
        var por_medio = $(this).parents("tr").find("#por_medio_mod").val();
        var por_dia = $(this).parents("tr").find("#por_dia_mod").val();

        $('#parqueadero_id_modal').val(parqueadero_id);
        $('#placa_modal').val(placa);
        $('#tipo_vehiculo_id_modal').val(tipo_vehiculo_id);
        $('#fecha_hora_ingreso_modal').val(fecha_hora_ingreso);
        $('#fecha_hora_salida_modal').val(fecha_hora_salida);
        $('#estado_modal').val(estado);
        $('#descripcion_modal').val(descripcion);
        $('#valor_servicio_modal').val(valor_servicio);

        if (por_mes == 1) {

            $('#por_mes_modal').bootstrapToggle('on');
            $('#por_dia_modal').bootstrapToggle('off');
            $('#por_horas_modal').bootstrapToggle('off');
            $('#por_medio_modal').bootstrapToggle('off');

        } else if (por_dia == 1) {

            $('#por_dia_modal').bootstrapToggle('on');
            $('#por_mes_modal').bootstrapToggle('off');
            $('#por_horas_modal').bootstrapToggle('off');
            $('#por_medio_modal').bootstrapToggle('off');

        } else if (por_horas == 1) {

            $('#por_horas_modal').bootstrapToggle('on');
            $('#por_mes_modal').bootstrapToggle('off');
            $('#por_dia_modal').bootstrapToggle('off');
            $('#por_medio_modal').bootstrapToggle('off');

        } else if (por_medio == 1) {

            $('#por_medio_modal').bootstrapToggle('on');
            $('#por_mes_modal').bootstrapToggle('off');
            $('#por_horas_modal').bootstrapToggle('off');
            $('#por_dia_modal').bootstrapToggle('off');

        }

    });

    //funcion actualizar servicio parqueadero
    $('#actualizar_parqueadero').click(function() {

        var parqueadero_id = $('#parqueadero_id_modal').val();
        var placa = $('#placa_modal').val();
        var tipo_vehiculo_id = $("#tipo_vehiculo_id_modal").val();
        var fecha_hora_ingreso = $("#fecha_hora_ingreso_modal").val();
        var fecha_hora_salida = $("#fecha_hora_salida_modal").val();
        var estado = $("#estado_modal").val();
        var descripcion = $("#descripcion_modal").val();
        var valor_servicio = $("#valor_servicio_modal").val();
        var usuario_id = $("#usuario_id").val();

        var por_mes = $("#por_mes_modal").is(":checked");
        var por_dia = $("#por_dia_modal").is(":checked");
        var por_medio = $("#por_medio_modal").is(":checked");
        var por_horas = $("#por_horas_modal").is(":checked");

        if (parqueadero_id > 0) {

            var validaRequeridos = parqueadero_id != '' && placa != '' && tipo_vehiculo_id != '' && fecha_hora_ingreso != '' && estado != '' && descripcion != '';

            if (validaRequeridos) {

                var datos = "FUNCION=update&parqueadero_id=" + parqueadero_id + "&placa=" + placa + "&tipo_vehiculo_id=" + tipo_vehiculo_id + "&fecha_hora_ingreso=" + fecha_hora_ingreso + "&fecha_hora_salida=" + fecha_hora_salida + "&estado=" + estado + "&descripcion=" + descripcion + "&valor_servicio=" + valor_servicio + "&usuario_id=" + usuario_id + "&por_mes=" + por_mes + "&por_horas=" + por_horas + "&por_medio=" + por_medio + "&por_dia=" + por_dia;

                $.ajax({
                    url: 'process/parqueadero.process.php',
                    type: 'POST',
                    data: datos,
                    dataType: 'json',
                    success: function(resp) {

                        var json = resp;
                        if (json != '') {

                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Servicio Parqueadero Actualizado Exitosamente!',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            setTimeout(function() { location.reload(); }, 3000);

                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Ocurrio una inconsistencia!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                })


            } else {
                Swal.fire(
                    'Atencion',
                    'Por favor digite los campos obligatorios!',
                    'info'
                )
            }

        }
    });

    //funcion eliminar
    $("#table_parqueadero").on("click", ".btn-danger", function() {

        var parqueadero_id = $(this).parents("tr").find("#parqueadero_id").val();
        var validaRequeridos = parqueadero_id != '';

        if (validaRequeridos) {

            Swal.fire({
                title: 'Estas Seguro?',
                text: "Clik en cancelar si no lo estas!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    var datos = "FUNCION=delete&parqueadero_id=" + parqueadero_id;

                    $.ajax({
                        url: 'process/parqueadero.process.php',
                        type: 'POST',
                        data: datos,
                        dataType: 'json',
                        success: function(resp) {

                            var json = $.parseJSON(resp);
                            if (json == 1) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Servicio Parqueadero Eliminado Exitosamente!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });


                                setTimeout(function() { location.reload(); }, 3000);


                            } else {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Ocurrio una inconsistencia!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }
                    });
                }
            })

            return false;

        } else {
            Swal.fire(
                'Atencion',
                'Por favor digite los campos obligatorios!',
                'info'
            )
        }

    });


    $('#table_parqueadero').on('click', '.btn-dark', function() {

        var codigo_ticket = $(this).parents("tr").find("#codigo_ticket").val();
        var placa = $(this).parents("tr").find("#placa").val();
        var estado = $(this).parents("tr").find("#estado").val();

        if (estado == 'F') {
            var url = "./process/parqueadero.process.php?FUNCION=imprimirTicketSalida&codigo_ticket=" + codigo_ticket;
            abrirpopup(url, '250', '500');
        } else if (estado == 'A') {
            var url = "./process/parqueadero.process.php?FUNCION=imprimirTicket&placa=" + placa;
            abrirpopup(url, '250', '500');
        }


    });

    //validacion vencimiento mensualidad
    setTimeout(function() {
        validaVencimientoMensual();
    }, 50000);




});

function ingresarVehiculo() {

    window.location.href = "inicio.php?page=ingresarVehiculo";

}

function reporte() {

    window.location.href = "inicio.php?page=listaVehiculos";

}

function reporteParqueadero() {

    window.location.href = "inicio.php?page=reporteParqueadero";

}

function salidaVehiculo() {

    window.location.href = "inicio.php?page=salidaVehiculo";

}

function abrirpopup(url, ancho, alto) {

    //Ajustar horizontalmente
    var x = (screen.width / 2) - (ancho / 2);
    //Ajustar verticalmente
    var y = (screen.height / 2) - (alto / 2);
    window.open(url, 'popup', 'width=' + ancho + ', height=' + alto + ', left=' + x + ', top=' + y + '');
}

function validaVencimientoMensual() {

    var datos = "FUNCION=validarMensualidad";

    $.ajax({
        url: 'process/parqueadero.process.php',
        type: 'POST',
        data: datos,
        dataType: 'json',
        success: function(resp) {

            var json = resp;
            if (json != '') {

                var placas = "";

                for (var i = 0; i < json.length; i++) {

                    var vencidos = json[i]['vencidos'];
                    var placa = vencidos['placa'];

                    placas = placas + "<br>" + placa;

                }

                Swal.fire(
                    'Atencion',
                    'Las siguientes placas tienen la mensualidad vencida! ' + placas,
                    'info'
                )


            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Ocurrio una inconsistencia!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }
    });

}