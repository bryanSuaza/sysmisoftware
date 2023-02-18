$(document).ready(function() {


    $('#placa').keypress(function(e) {

        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') {

            var placa = $(this).val();

            var datos = "FUNCION=salidaVehiculo&placa=" + placa;

            $.ajax({
                url: 'process/parqueadero.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',

                success: function(resp) {

                    var json = resp;
                    if (json != '' && json != null && json != 2 && json != 3 && json != 4) {

                        var codigo_ticket = json[0]['codigo_ticket'];
                        var valor_hora = json[0]['valor_hora'];
                        var tipo_vehiculo_id = json[0]['tipo_vehiculo_id'];
                        var fecha_hora_ingreso = json[0]['fecha_hora_ingreso'];
                        var fecha_hora_salida = json[0]['fecha_hora_salida'];
                        var horas = json[0]['horas'];
                        var dias = json[0]['dias'];
                        var medios_dias = json[0]['medios_dias'];
                        var valor_servicio = json[0]['valor_servicio'];

                        if (medios_dias > 0 && !horas > 0) {
                            horas = 6;
                        }

                        const formatterPeso = new Intl.NumberFormat('es-CO', {
                            style: 'currency',
                            currency: 'COP',
                            minimumFractionDigits: 0
                        })


                        Swal.fire({
                            title: 'Valor Servicio :  ' + '<div style="color:#28db00">' + formatterPeso.format(valor_servicio) + '</div>',
                            text: '¿Estas seguro que deseas liquidar el servicio referente al vehiculo: ' + placa + '?',
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Aceptar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.value) {
                                var datos = "FUNCION=updateServicio&codigo_ticket=" + codigo_ticket + "&valor_servicio=" + valor_servicio + "&fecha_hora_salida=" + fecha_hora_salida + "&horas=" + horas + "&dias=" + dias + "&medios_dias=" + medios_dias;

                                $.ajax({
                                    url: 'process/parqueadero.process.php',
                                    type: 'POST',
                                    data: datos,
                                    dataType: 'json',
                                    success: function(resp) {

                                        var json = resp;

                                        if (json > 0) {
                                            Swal.fire({
                                                position: 'top-end',
                                                icon: 'success',
                                                title: 'Liquidacion del servicio exitosa!',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });

                                            $("#codigo_ticket").val(codigo_ticket);
                                            $("#valor_hora").val(valor_hora);
                                            $("#tipo_vehiculo_id").val(tipo_vehiculo_id);
                                            $("#fecha_hora_ingreso").val(fecha_hora_ingreso);
                                            $("#fecha_hora_salida").val(fecha_hora_salida);
                                            $("#horas").val(horas);
                                            $("#dias").val(dias);
                                            $("#medios_dias").val(medios_dias);
                                            $("#valor_servicio").val(valor_servicio);

                                            var url = "./process/parqueadero.process.php?FUNCION=imprimirTicketSalida&placa=" + placa;
                                            abrirpopup(url, '250', '500');


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
                        });


                    } else if (json == 2) {
                        Swal.fire(
                            'Atención',
                            'El vehículo ' + placa + ' no se encuentra en el parqueadero o ya finalizó su servicio',
                            'warning'
                        )
                    } else if (json == 3) {

                        Swal.fire(
                            'Atención',
                            'El tipo de vehículo de placa:  ' + placa + ' no tiene configurada las tarifas!',
                            'warning'
                        )

                    } else if (json == 4) {

                        Swal.fire(
                            'Atención',
                            'El vehículo de placa:  ' + placa + ' ingresó por tipo de servicio mensual por tanto el sistema lo liquida automaticamente!',
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

            e.preventDefault();
            return false;
        }

    });

    //funcion guardar
    $('#guardar').click(function() {

        var placa = $('#placa').val();

        //funcion guardar
        var validaRequeridos = placa != '';

        if (validaRequeridos) {

            var datos = "FUNCION=salidaVehiculo&placa=" + placa;

            $.ajax({
                url: 'process/parqueadero.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {

                    var json = resp;
                    if (json != '' && json != null && json != 2 && json != 3 && json != 4) {

                        var codigo_ticket = json[0]['codigo_ticket'];
                        var valor_hora = json[0]['valor_hora'];
                        var tipo_vehiculo_id = json[0]['tipo_vehiculo_id'];
                        var fecha_hora_ingreso = json[0]['fecha_hora_ingreso'];
                        var fecha_hora_salida = json[0]['fecha_hora_salida'];
                        var horas = json[0]['horas'];
                        var dias = json[0]['dias'];
                        var medios_dias = json[0]['medios_dias'];
                        var valor_servicio = json[0]['valor_servicio'];

                        const formatterPeso = new Intl.NumberFormat('es-CO', {
                            style: 'currency',
                            currency: 'COP',
                            minimumFractionDigits: 0
                        })

                        Swal.fire({
                            title: 'Valor Servicio ' + '<td style="color:#28db00">' + formatterPeso.format(valor_servicio) + "</td>",
                            text: "¿Estas seguro que deseas liquidar el servicio referente al vehiculo: " + placa + "?",
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Aceptar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.value) {
                                var datos = "FUNCION=updateServicio&codigo_ticket=" + codigo_ticket + "&valor_servicio=" + valor_servicio + "&fecha_hora_salida=" + fecha_hora_salida + "&horas=" + horas + "&dias=" + dias + "&medios_dias=" + medios_dias;

                                $.ajax({
                                    url: 'process/parqueadero.process.php',
                                    type: 'POST',
                                    data: datos,
                                    dataType: 'json',
                                    success: function(resp) {

                                        var json = resp;

                                        if (json > 0) {
                                            Swal.fire({
                                                position: 'top-end',
                                                icon: 'success',
                                                title: 'Liquidacion del servicio exitosa!',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });

                                            $("#codigo_ticket").val(codigo_ticket);
                                            $("#valor_hora").val(valor_hora);
                                            $("#tipo_vehiculo_id").val(tipo_vehiculo_id);
                                            $("#fecha_hora_ingreso").val(fecha_hora_ingreso);
                                            $("#fecha_hora_salida").val(fecha_hora_salida);
                                            $("#horas").val(horas);
                                            $("#dias").val(dias);
                                            $("#medios_dias").val(medios_dias);
                                            $("#valor_servicio").val(valor_servicio);

                                            var url = "./process/parqueadero.process.php?FUNCION=imprimirTicketSalida&placa=" + placa;
                                            abrirpopup(url, '250', '500');


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
                        });



                    } else if (json == 2) {
                        Swal.fire(
                            'Atencion',
                            'El vehículo ' + placa + ' no se encuentra en el parqueadero o ya finalizó su servicio',
                            'warning'
                        )
                    } else if (json == 3) {

                        Swal.fire(
                            'Atención',
                            'El tipo de vehículo de placa:  ' + placa + ' no tiene configurada las tarifas!',
                            'warning'
                        )

                    } else if (json == 4) {

                        Swal.fire(
                            'Atención',
                            'El vehículo de placa:  ' + placa + ' ingresó por tipo de servicio mensual por tanto el sistema lo liquida automaticamente!',
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


    $('#imprimir_salida').click(function() {

        var codigo_ticket = $('#codigo_ticket').val();

        if (codigo_ticket > 0 && codigo_ticket != '') {
            var url = "./process/parqueadero.process.php?FUNCION=imprimirTicketSalida&codigo_ticket=" + codigo_ticket;
            abrirpopup(url, '250', '500');
        } else {

            Swal.fire(
                'Atencion',
                'Por favor liquide un servicio de parqueadero!',
                'info'
            )

        }

        return false;

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

function abrirpopup(url, ancho, alto) {

    //Ajustar horizontalmente
    var x = (screen.width / 2) - (ancho / 2);
    //Ajustar verticalmente
    var y = (screen.height / 2) - (alto / 2);
    window.open(url, 'popup', 'width=' + ancho + ', height=' + alto + ', left=' + x + ', top=' + y + '');
}