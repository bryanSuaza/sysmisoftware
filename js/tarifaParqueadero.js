$(document).ready(function() {

    if (document.getElementById('guardar')) {
        document.getElementById('guardar').disabled = false;
    }

    if (document.getElementById('actualizar')) {
        document.getElementById('actualizar').disabled = true;
    }

    if (document.getElementById('eliminar')) {
        document.getElementById('eliminar').disabled = true;
    }

    //busqueda inteligente
    $('#buscar').autocomplete({
        source: function(data, cb) {

            var datos = "FUNCION=serch&busqueda=" + data.term;

            $.ajax({
                url: 'process/tarifaParqueadero.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {
                    var d = $.map(resp, function(tarifas_parqueadero_id) {
                        return {
                            label: tarifas_parqueadero_id,
                            value: tarifas_parqueadero_id
                        }
                    });

                    cb(d);
                }
            });
        },

        select: function(event, ui) {

            $('#form')[0].reset();

            var tarifas = ui.item.value;
            var arrayTarifas = tarifas.split(' ');
            var tarifas_parqueadero_id = arrayTarifas[0];

            var datos = "FUNCION=getDate&tarifas_parqueadero_id=" + tarifas_parqueadero_id;

            $.ajax({
                url: 'process/tarifaParqueadero.process.php',
                type: 'POST',
                data: datos,
                success: function(resp) {

                    var json = $.parseJSON(resp);

                    if (json != '') {

                        var tarifas_parqueadero_id = json['tarifas_parqueadero_id'];
                        var tipo_vehiculo_id = json['tipo_vehiculo_id'];
                        var valor_hora_diurna = json['valor_hora_diurna'];
                        var valor_hora_nocturna = json['valor_hora_nocturna'];
                        var valor_medio_dia = json['valor_medio_dia'];
                        var valor_dia = json['valor_dia'];
                        var valor_mes = json['valor_mes'];
                        var tiempo_cobro = json['tiempo_cobro'];
                        var estado = json['estado'];


                        $('#tarifas_parqueadero_id').val(tarifas_parqueadero_id);
                        $('#tipo_vehiculo_id').val(tipo_vehiculo_id);
                        $('#valor_hora_diurna').val(valor_hora_diurna);
                        $('#valor_hora_nocturna').val(valor_hora_nocturna);
                        $('#valor_medio_dia').val(valor_medio_dia);
                        $('#valor_dia').val(valor_dia);
                        $('#valor_mes').val(valor_mes);
                        $('#tiempo_cobro').val(tiempo_cobro);
                        $('#estado').val(estado);

                        if (document.getElementById('guardar')) {
                            document.getElementById('guardar').disabled = true;
                        }

                        if (document.getElementById('actualizar')) {
                            document.getElementById('actualizar').disabled = false;
                        }

                        if (document.getElementById('eliminar')) {
                            document.getElementById('eliminar').disabled = false;
                        }
                    }


                }
            });
        }
    })

    //funcion guardar
    $('#guardar').click(function() {


        var tipo_vehiculo_id = $('#tipo_vehiculo_id').val();
        var valor_hora_diurna = $('#valor_hora_diurna').val();
        var valor_hora_nocturna = $('#valor_hora_nocturna').val();
        var valor_medio_dia = $('#valor_medio_dia').val();
        var valor_dia = $('#valor_dia').val();
        var valor_mes = $('#valor_mes').val();
        var tiempo_cobro = $('#tiempo_cobro').val();
        var estado = $('#estado').val();

        var validaRequeridos = tipo_vehiculo_id != '' && valor_hora_diurna != '' && valor_hora_nocturna != '' &&
            valor_medio_dia != '' && valor_mes != '' && tiempo_cobro != '' && valor_dia != '' && estado != '';

        if (validaRequeridos) {

            var datos = "FUNCION=save&" + $('#form').serialize();

            $.ajax({
                url: 'process/tarifaParqueadero.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {

                    var json = $.parseJSON(resp);
                    if (json == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Tarifa  Guardada Exitosamente!',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $('#form')[0].reset();
                        $('#buscar').val('');
                        if (document.getElementById('guardar')) {
                            document.getElementById('guardar').disabled = false;
                        }

                        if (document.getElementById('actualizar')) {
                            document.getElementById('actualizar').disabled = true;
                        }

                        if (document.getElementById('eliminar')) {
                            document.getElementById('eliminar').disabled = true;
                        }

                    } else if (json == 2) {

                        Swal.fire({
                            position: 'top-end',
                            icon: 'info',
                            title: 'Ya existe una tarifa activa para el tipo de vehiculo seleccionado!',
                            showConfirmButton: false,
                            timer: 1500
                        });

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
        }

    });

    //funcion actualizar
    $('#actualizar').click(function() {

        var tarifas_parqueadero_id = $('#tarifas_parqueadero_id').val();
        var tipo_vehiculo_id = $('#tipo_vehiculo_id').val();
        var valor_hora_diurna = $('#valor_hora_diurna').val();
        var valor_hora_nocturna = $('#valor_hora_nocturna').val();
        var valor_medio_dia = $('#valor_medio_dia').val();
        var valor_dia = $('#valor_dia').val();
        var valor_mes = $('#valor_mes').val();
        var tiempo_cobro = $('#tiempo_cobro').val();
        var estado = $('#estado').val();

        var validaRequeridos = tipo_vehiculo_id != '' && valor_hora_diurna != '' && valor_hora_nocturna != '' &&
            valor_medio_dia != '' && valor_mes != '' && tiempo_cobro != '' && valor_dia != '' && estado != '';

        if (validaRequeridos) {

            var datos = "FUNCION=update&" + $('#form').serialize();

            $.ajax({
                url: 'process/tarifaParqueadero.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {

                    var json = $.parseJSON(resp);
                    if (json == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Tarifa Actualizada Exitosamente!',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $('#form')[0].reset();
                        $('#buscar').val('');
                        if (document.getElementById('guardar')) {
                            document.getElementById('guardar').disabled = false;
                        }

                        if (document.getElementById('actualizar')) {
                            document.getElementById('actualizar').disabled = true;
                        }

                        if (document.getElementById('eliminar')) {
                            document.getElementById('eliminar').disabled = true;
                        }

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
            return false;

        } else {
            Swal.fire(
                'Atencion',
                'Por favor digite los campos obligatorios!',
                'info'
            )
        }

    });

    //funcion eliminar
    $('#eliminar').click(function() {

        var tarifas_parqueadero_id = $('#tarifas_parqueadero_id').val();

        var validaRequeridos = tarifas_parqueadero_id != '';

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
                    var datos = "FUNCION=delete&tarifas_parqueadero_id=" + tarifas_parqueadero_id;

                    $.ajax({
                        url: 'process/tarifaParqueadero.process.php',
                        type: 'POST',
                        data: datos,
                        dataType: 'json',
                        success: function(resp) {

                            var json = $.parseJSON(resp);
                            if (json == 1) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Tarifa Eliminada Exitosamente!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                $('#form')[0].reset();
                                $('#buscar').val('');
                                if (document.getElementById('guardar')) {
                                    document.getElementById('guardar').disabled = false;
                                }

                                if (document.getElementById('actualizar')) {
                                    document.getElementById('actualizar').disabled = true;
                                }

                                if (document.getElementById('eliminar')) {
                                    document.getElementById('eliminar').disabled = true;
                                }

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

    $('#limpiar').click(function() {
        $('#form')[0].reset();
        $('#buscar').val('');
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