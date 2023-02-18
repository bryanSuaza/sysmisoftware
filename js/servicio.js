$(document).ready(function() {

    $('#fecha').datepicker();

    if (document.getElementById('guardar')) {
        document.getElementById('guardar').disabled = false;
    }

    if (document.getElementById('actualizar')) {
        document.getElementById('actualizar').disabled = true;
    }

    if (document.getElementById('eliminar')) {
        document.getElementById('eliminar').disabled = true;
    }


    var servicio_id = $("#servicio_id").val();
    if (servicio_id > 0) {
        cargarDatos(servicio_id);
    }

    $('#table_servicios').DataTable({
        responsive: true
    });

    //busqueda inteligente
    $('#buscar').autocomplete({
        source: function(data, cb) {

            var datos = "FUNCION=serch&busqueda=" + data.term;

            $.ajax({
                url: 'process/servicio.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {
                    var d = $.map(resp, function(servicio_id) {
                        return {
                            label: servicio_id,
                            value: servicio_id
                        }
                    });

                    cb(d);
                }
            });
        },

        select: function(event, ui) {

            $('#form')[0].reset();

            var servicio = ui.item.value;
            var arrayServicio = servicio.split(' ');
            var servicio_id = arrayServicio[0];

            var datos = "FUNCION=getDate&servicio_id=" + servicio_id;

            $.ajax({
                url: 'process/servicio.process.php',
                type: 'POST',
                data: datos,
                success: function(resp) {

                    var json = $.parseJSON(resp);

                    if (json != '') {

                        var servicio = json[0]['servicio'];
                        var detalles = json[0]['detalles'];

                        var servicio_id = servicio['servicio_id'];
                        var cliente = servicio['cliente'];
                        var numero_identificacion = servicio['numero_identificacion'];
                        var cliente_id = servicio['cliente_id'];
                        var fecha = servicio['fecha'];
                        var hora = servicio['hora'];
                        var estado = servicio['estado'];
                        var valor_total = servicio['valor_total'];

                        $('#servicio_id').val(servicio_id);
                        $('#cliente').val(cliente);
                        $('#numero_identificacion').val(numero_identificacion);
                        $('#cliente_id').val(cliente_id);
                        $('#fecha').val(fecha);
                        $('#hora').val(hora);
                        $('#estado').val(estado);
                        $('#total').val(valor_total);

                        if (detalles != null) {

                            var tableBody = $('#detalles').find("tbody");
                            tableBody.find("tr").remove();

                            for (var i = 0; i < json.length; i++) {

                                var detalle_servicio = json[i]['detalles'];
                                var detalle_servicio_id = detalle_servicio['detalle_servicio_id'];
                                var habitacion_id = detalle_servicio['habitacion_id'];
                                var habitacion = detalle_servicio['habitacion'];
                                var producto_id = detalle_servicio['producto_id'];
                                var producto = detalle_servicio['producto'];
                                var observacion = detalle_servicio['concepto'];
                                var cantidad = detalle_servicio['cantidad'];
                                var valor = detalle_servicio['valor'];

                                if (habitacion_id > 0) {

                                    var htmlTags = '<tr>' +
                                        '<td>' + '<input type="hidden" id="detalle_servicio_id" value="' + detalle_servicio_id + '"><input type="hidden" id="habitacion_id_clon" value="' + habitacion_id + '">' + habitacion + '</td>' +
                                        '<td>' + '<input type="hidden" id="concepto_clon" value="' + observacion + '">' + observacion + '</td>' +
                                        '<td>' + '<input type="hidden" id="cantidad_clon" value="' + cantidad + '">' + cantidad + '</td>' +
                                        '<td>' + '<input type="hidden" id="valor_clon" value="' + valor + '">' + valor + '</td>' +
                                        '<td>' + '<button class="btn btn-primary" id="actualizar_detalle" data-toggle="modal" data-target="#modal_habitacion_actualizar"><i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '<td>' + '<button class="btn btn-danger" id="quitar"><i class="fa fa-trash" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '</tr>';
                                    $('#detalles tbody').append(htmlTags);

                                } else if (producto_id > 0) {

                                    var htmlTags = '<tr>' +
                                        '<td>' + '<input type="hidden" id="detalle_servicio_id" value="' + detalle_servicio_id + '"><input type="hidden" id="producto_id_clon" value="' + producto_id + '">' + producto + '</td>' +
                                        '<td>' + '<input type="hidden" id="concepto_clon" value="' + observacion + '">' + observacion + '</td>' +
                                        '<td>' + '<input type="hidden" id="cantidad_clon" value="' + cantidad + '">' + cantidad + '</td>' +
                                        '<td>' + '<input type="hidden" id="valor_clon" value="' + valor + '">' + valor + '</td>' +
                                        '<td>' + '<button class="btn btn-primary" id="actualizar_detalle_pro" data-toggle="modal" data-target="#modal_producto_actualizar"><i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '<td>' + '<button class="btn btn-danger" id="quitar"><i class="fa fa-trash" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '</tr>';
                                    $('#detalles tbody').append(htmlTags);

                                }
                            }

                            //$('#detalles').find("tbody").find("tr:last").find("#quitar").prop('disabled', false);
                        }


                        document.getElementById('detalles_servicio').style.display = '';

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
    });

    //funcion guardar
    $('#guardar').click(function() {

        var cliente_id = $('#cliente_id').val();
        var fecha = $('#fecha').val();
        var hora = $('#hora').val();
        var estado = $('#estado').val();

        var validaRequeridos = cliente_id != '' && fecha != '' && hora != '' && estado != '';

        if (validaRequeridos) {

            var datos = "FUNCION=save&estado=" + estado + "&" + $('#form').serialize();

            $.ajax({
                url: 'process/servicio.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {

                    var json = $.parseJSON(resp);
                    if (json > 0) {

                        if (document.getElementById('guardar')) {
                            document.getElementById('guardar').disabled = true;
                        }

                        if (document.getElementById('actualizar')) {
                            document.getElementById('actualizar').disabled = false;
                        }

                        if (document.getElementById('eliminar')) {
                            document.getElementById('eliminar').disabled = false;
                        }

                        $('#servicio_id').val(json);
                        document.getElementById('detalles_servicio').style.display = '';

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

        var servicio_id = $('#servicio_id').val();
        var cliente_id = $('#cliente_id').val();
        var fecha = $('#fecha').val();
        var hora = $('#hora').val();
        var estado = $('#estado').val();
        var usuario_id = $('#usuario_id').val();

        var validaRequeridos = servicio_id != '' && cliente_id != '' && fecha != '' && hora != '' && estado != '';

        if (validaRequeridos) {

            var datos = "FUNCION=update&usuario_id=" + usuario_id + "&estado=" + estado + "&" + $('#form').serialize();

            $.ajax({
                url: 'process/servicio.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {

                    var json = $.parseJSON(resp);
                    if (json == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Reserva Actualizada Exitosamente!',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $('#form')[0].reset();
                        $('#buscar').val('');

                        document.getElementById('detalles_servicio').style.display = 'none';

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

        var servicio_id = $('#servicio_id').val();

        var validaRequeridos = servicio_id != '';

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
                    var datos = "FUNCION=delete&servicio_id=" + servicio_id;

                    $.ajax({
                        url: 'process/servicio.process.php',
                        type: 'POST',
                        data: datos,
                        dataType: 'json',
                        success: function(resp) {

                            var json = $.parseJSON(resp);
                            if (json == 1) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Servicio Eliminado Exitosamente!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                $('#form')[0].reset();
                                $('#buscar').val('');

                                document.getElementById('detalles_servicio').style.display = 'none';

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

        $('#detalles').find("tbody").find("tr").remove();

        document.getElementById('detalles_servicio').style.display = 'none';

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

    //busqueda cliente
    $('#cliente').autocomplete({
        source: function(data, cb) {

            var datos = "FUNCION=serchCliente&busqueda=" + data.term;

            $.ajax({
                url: 'process/servicio.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {
                    var d = $.map(resp, function(cliente_id) {
                        return {
                            label: cliente_id,
                            value: cliente_id
                        }
                    });

                    cb(d);
                }
            });
        },

        select: function(event, ui) {

            var cliente = ui.item.value;
            var arrayCliente = cliente.split(' ');
            var cliente_id = arrayCliente[0];

            var datos = "FUNCION=getDateCliente&cliente_id=" + cliente_id;

            $.ajax({
                url: 'process/servicio.process.php',
                type: 'POST',
                data: datos,
                success: function(resp) {

                    var json = $.parseJSON(resp);

                    if (json != '') {

                        var cliente_id = json['cliente_id'];
                        var numero_identificacion = json['numero_identificacion'];


                        $('#cliente_id').val(cliente_id);
                        $('#numero_identificacion').val(numero_identificacion);

                    }

                }
            });
        }
    });

    if (document.getElementById('detalles_servicio')) {
        document.getElementById('detalles_servicio').style.display = 'none';
    }

    $("#habitacion_id, #habitacion_id_modal").blur(function() {

        var habitacion_id = $(this).val();

        var datos = "FUNCION=getValorHabitacion&habitacion_id=" + habitacion_id;

        $.ajax({
            url: 'process/servicio.process.php',
            type: 'POST',
            data: datos,
            success: function(resp) {

                var json = $.parseJSON(resp);

                if (json != '') {

                    var valor = json['valor'];
                    $("#valor").val(valor);
                    $("#valor_modal").val(valor);

                }
            }
        });
    });

    $("#cantidad, #cantidad_modal").blur(function() {

        var cantidad = $(this).val();
        var habitacion_id = $("#habitacion_id").val();
        if (habitacion_id == 'null') {
            var habitacion_id = $("#habitacion_id_modal").val();
        }

        var datos = "FUNCION=getValorHabitacion&habitacion_id=" + habitacion_id;

        $.ajax({
            url: 'process/servicio.process.php',
            type: 'POST',
            data: datos,
            success: function(resp) {

                var json = $.parseJSON(resp);

                if (json != '') {

                    var valor = json['valor'];

                    if (cantidad > 0 && valor > 0) {
                        var valor_calculado = (parseInt(cantidad) * parseInt(valor));
                        $("#valor").val(valor_calculado);
                        $("#valor_modal").val(valor_calculado);
                    }

                }

            }
        });


    });

    $("#producto_id, #producto_id_modal").blur(function() {

        var producto_id = $(this).val();

        var datos = "FUNCION=getValorProducto&producto_id=" + producto_id;

        $.ajax({
            url: 'process/servicio.process.php',
            type: 'POST',
            data: datos,
            success: function(resp) {

                var json = $.parseJSON(resp);

                if (json != '') {

                    var valor = json['valor_venta'];
                    $("#valor_pro").val(valor);
                    $("#valor_modal_pro").val(valor);

                }
            }
        });
    });

    $("#cantidad_pro, #cantidad_modal_pro").blur(function() {

        var cantidad = $(this).val();
        var producto_id = $("#producto_id").val();
        if (producto_id == 'null') {
            var producto_id = $("#producto_id_modal").val();
        }

        var datos = "FUNCION=getValorProducto&producto_id=" + producto_id;

        $.ajax({
            url: 'process/servicio.process.php',
            type: 'POST',
            data: datos,
            success: function(resp) {

                var json = $.parseJSON(resp);

                if (json != '') {

                    var valor = json['valor_venta'];

                    if (cantidad > 0 && valor > 0) {
                        var valor_calculado = (parseInt(cantidad) * parseInt(valor));
                        $("#valor_pro").val(valor_calculado);
                        $("#valor_modal_pro").val(valor_calculado);
                    }

                }

            }
        });


    });

    //funcion borrar detalles
    $("#detalles").on("click", ".btn-danger", function() {

        var detalle_servicio_id = $(this).parents("tr").find("#detalle_servicio_id").val();
        var servicio_id = $("#servicio_id").val();

        if (detalle_servicio_id > 0) {

            var validaRequeridos = detalle_servicio_id != '' && servicio_id != '';

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
                        var datos = "FUNCION=deleteDetalle&detalle_servicio_id=" + detalle_servicio_id + "&servicio_id=" + servicio_id;

                        $.ajax({
                            url: 'process/servicio.process.php',
                            type: 'POST',
                            data: datos,
                            dataType: 'json',
                            success: function(resp) {

                                var json = resp;
                                if (json != '' && json != null) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Detalle Servicio Eliminado Exitosamente!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    var valor_total = json['total'];
                                    $("#total").val(valor_total);

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
                        $(this).parents("tr").remove();
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

        } else {

            $('#detalles').find("tbody").find("tr").prev().find("#quitar").prop('disabled', false);
            $(this).parents("tr").remove();

        }


    });

    //funcion guardar detalle habitacion
    $('#guardar_detalle_habitacion').click(function() {

        var servicio_id = $('#servicio_id').val();
        var habitacion_id = $("#habitacion_id").val();
        var concepto = $("#concepto").val();
        var cantidad = $("#cantidad").val();
        var valor = $("#valor").val();

        var validaRequeridos = servicio_id != '' && habitacion_id != '' && cantidad != '' && valor != '';

        if (validaRequeridos) {

            var datos = "FUNCION=saveDetalle&servicio_id=" + servicio_id + "&habitacion_id=" + habitacion_id + "&concepto=" + concepto + "&cantidad=" + cantidad + "&valor=" + valor;

            $.ajax({
                url: 'process/servicio.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {

                    var json = resp;
                    if (json != '' && json != null) {

                        var detalle_servicio = json[0]['detalle_servicio'];
                        var detalle_servicio_id = detalle_servicio['detalle_servicio_id'];
                        var habitacion_id = detalle_servicio['habitacion_id'];
                        var habitacion = detalle_servicio['habitacion'];
                        var observacion = detalle_servicio['concepto'];
                        var cantidad = detalle_servicio['cantidad'];
                        var valor = detalle_servicio['valor'];

                        var total = json[0]['total'];
                        var valor_total = total['total'];

                        var htmlTags = '<tr>' +
                            '<td>' + '<input type="hidden" id="detalle_servicio_id" value="' + detalle_servicio_id + '"><input type="hidden" id="habitacion_id_clon" value="' + habitacion_id + '">' + habitacion + '</td>' +
                            '<td>' + '<input type="hidden" id="concepto_clon" value="' + observacion + '">' + observacion + '</td>' +
                            '<td>' + '<input type="hidden" id="cantidad_clon" value="' + cantidad + '">' + cantidad + '</td>' +
                            '<td>' + '<input type="hidden" id="valor_clon" value="' + valor + '">' + valor + '</td>' +
                            '<td>' + '<button class="btn btn-primary" id="actualizar_detalle" data-toggle="modal" data-target="#modal_habitacion_actualizar"><i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                            '<td>' + '<button class="btn btn-danger" id="quitar"><i class="fa fa-trash" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                            '</tr>';
                        $('#detalles tbody').append(htmlTags);

                        $("#total").val(valor_total);

                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Reserva Guardada Exitosamente!',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $("#habitacion_id").val('null');
                        $("#concepto").val('');
                        $("#cantidad").val('');
                        $("#valor").val('');

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
    });

    //funcion guardar detalle producto
    $('#guardar_detalle_producto').click(function() {

        var servicio_id = $('#servicio_id').val();
        var producto_id = $("#producto_id").val();
        var concepto = $("#concepto_pro").val();
        var cantidad = $("#cantidad_pro").val();
        var valor = $("#valor_pro").val();

        var validaRequeridos = servicio_id != '' && producto_id != '' && cantidad != '' && valor != '';

        if (validaRequeridos) {

            var datos = "FUNCION=saveDetalle&servicio_id=" + servicio_id + "&producto_id=" + producto_id + "&concepto=" + concepto + "&cantidad=" + cantidad + "&valor=" + valor;

            $.ajax({
                url: 'process/servicio.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {

                    var json = resp;
                    if (json != '' && json != null) {

                        var detalle_servicio = json[0]['detalle_servicio'];
                        var detalle_servicio_id = detalle_servicio['detalle_servicio_id'];
                        var producto_id = detalle_servicio['producto_id'];
                        var producto = detalle_servicio['producto'];
                        var observacion = detalle_servicio['concepto'];
                        var cantidad = detalle_servicio['cantidad'];
                        var valor = detalle_servicio['valor'];

                        var total = json[0]['total'];
                        var valor_total = total['total'];

                        var htmlTags = '<tr>' +
                            '<td>' + '<input type="hidden" id="detalle_servicio_id" value="' + detalle_servicio_id + '"><input type="hidden" id="producto_id_clon" value="' + producto_id + '">' + producto + '</td>' +
                            '<td>' + '<input type="hidden" id="concepto_clon" value="' + observacion + '">' + observacion + '</td>' +
                            '<td>' + '<input type="hidden" id="cantidad_clon" value="' + cantidad + '">' + cantidad + '</td>' +
                            '<td>' + '<input type="hidden" id="valor_clon" value="' + valor + '">' + valor + '</td>' +
                            '<td>' + '<button class="btn btn-primary" id="actualizar_detalle_pro" data-toggle="modal" data-target="#modal_producto_actualizar"><i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                            '<td>' + '<button class="btn btn-danger" id="quitar"><i class="fa fa-trash" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                            '</tr>';
                        $('#detalles tbody').append(htmlTags);

                        $("#total").val(valor_total);

                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Servicio Guardado Exitosamente!',
                            showConfirmButton: false,
                            timer: 1500
                        });


                        $("#producto_id").val('null');
                        $("#concepto_pro").val('');
                        $("#cantidad_pro").val('');
                        $("#valor_pro").val('');

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
    });

    $('#detalles').on('click', '.btn-primary', function() {
        var detalle_servicio_id = $(this).parents("tr").find("#detalle_servicio_id").val();
        var habitacion_id = $(this).parents("tr").find("#habitacion_id_clon").val();
        var producto_id = $(this).parents("tr").find("#producto_id_clon").val();
        var concepto = $(this).parents("tr").find("#concepto_clon").val();
        var cantidad = $(this).parents("tr").find("#cantidad_clon").val();
        var valor = $(this).parents("tr").find("#valor_clon").val();


        $('#detalle_servicio_id_modal').val(detalle_servicio_id);
        $('#habitacion_id_modal').val(habitacion_id);
        $('#concepto_modal').val(concepto);
        $('#cantidad_modal').val(cantidad);
        $('#valor_modal').val(valor);

        $('#detalle_servicio_id_modal_pro').val(detalle_servicio_id);
        $('#producto_id_modal').val(producto_id);
        $('#concepto_modal_pro').val(concepto);
        $('#cantidad_modal_pro').val(cantidad);
        $('#valor_modal_pro').val(valor);
    });

    //funcion actualizar detalle habitacion
    $('#actualizar_detalle_habitacion').click(function() {

        var servicio_id = $('#servicio_id').val();
        var detalle_servicio_id = $('#detalle_servicio_id_modal').val();
        var habitacion_id = $("#habitacion_id_modal").val();
        var concepto = $("#concepto_modal").val();
        var cantidad = $("#cantidad_modal").val();
        var valor = $("#valor_modal").val();

        if (detalle_servicio_id > 0) {

            var validaRequeridos = detalle_servicio_id != '' && servicio_id != '' && habitacion_id != '' && cantidad != '' && valor != '';

            if (validaRequeridos) {

                var datos = "FUNCION=updateDetalle&servicio_id=" + servicio_id + "&detalle_servicio_id=" + detalle_servicio_id + "&habitacion_id=" + habitacion_id + "&concepto=" + concepto + "&cantidad=" + cantidad + "&valor=" + valor;

                $.ajax({
                    url: 'process/servicio.process.php',
                    type: 'POST',
                    data: datos,
                    dataType: 'json',
                    success: function(resp) {

                        var json = resp;
                        if (json != '') {

                            var tableBody = $('#detalles').find("tbody");
                            tableBody.find("tr").remove();


                            for (var i = 0; i < json.length; i++) {

                                var detalle_servicio = json[i]['detalle_servicio'];
                                var detalle_servicio_id = detalle_servicio['detalle_servicio_id'];
                                var habitacion_id = detalle_servicio['habitacion_id'];
                                var habitacion = detalle_servicio['habitacion'];
                                var producto_id = detalle_servicio['producto_id'];
                                var producto = detalle_servicio['producto'];
                                var observacion = detalle_servicio['concepto'];
                                var cantidad = detalle_servicio['cantidad'];
                                var valor = detalle_servicio['valor'];

                                if (habitacion_id > 0) {

                                    var htmlTags = '<tr>' +
                                        '<td>' + '<input type="hidden" id="detalle_servicio_id" value="' + detalle_servicio_id + '"><input type="hidden" id="habitacion_id_clon" value="' + habitacion_id + '">' + habitacion + '</td>' +
                                        '<td>' + '<input type="hidden" id="concepto_clon" value="' + observacion + '">' + observacion + '</td>' +
                                        '<td>' + '<input type="hidden" id="cantidad_clon" value="' + cantidad + '">' + cantidad + '</td>' +
                                        '<td>' + '<input type="hidden" id="valor_clon" value="' + valor + '">' + valor + '</td>' +
                                        '<td>' + '<button class="btn btn-primary" id="actualizar_detalle" data-toggle="modal" data-target="#modal_habitacion_actualizar"><i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '<td>' + '<button class="btn btn-danger" id="quitar"><i class="fa fa-trash" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '</tr>';
                                    $('#detalles tbody').append(htmlTags);

                                } else if (producto_id > 0) {

                                    var htmlTags = '<tr>' +
                                        '<td>' + '<input type="hidden" id="detalle_servicio_id" value="' + detalle_servicio_id + '"><input type="hidden" id="producto_id_clon" value="' + producto_id + '">' + producto + '</td>' +
                                        '<td>' + '<input type="hidden" id="concepto_clon" value="' + observacion + '">' + observacion + '</td>' +
                                        '<td>' + '<input type="hidden" id="cantidad_clon" value="' + cantidad + '">' + cantidad + '</td>' +
                                        '<td>' + '<input type="hidden" id="valor_clon" value="' + valor + '">' + valor + '</td>' +
                                        '<td>' + '<button class="btn btn-primary" id="actualizar_detalle_pro" data-toggle="modal" data-target="#modal_producto_actualizar"><i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '<td>' + '<button class="btn btn-danger" id="quitar"><i class="fa fa-trash" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '</tr>';
                                    $('#detalles tbody').append(htmlTags);

                                }

                            }
                            var total = json[0]['total'];
                            var valor_total = total['total'];

                            $("#total").val(valor_total);


                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Reserva Actualizada Exitosamente!',
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


            } else {
                Swal.fire(
                    'Atencion',
                    'Por favor digite los campos obligatorios!',
                    'info'
                )
            }

        }
    });

    //funcion actualizar detalle producto
    $('#actualizar_detalle_producto').click(function() {

        var servicio_id = $('#servicio_id').val();
        var detalle_servicio_id = $('#detalle_servicio_id_modal_pro').val();
        var producto_id = $("#producto_id_modal").val();
        var concepto = $("#concepto_modal_pro").val();
        var cantidad = $("#cantidad_modal_pro").val();
        var valor = $("#valor_modal_pro").val();

        if (detalle_servicio_id > 0) {

            var validaRequeridos = detalle_servicio_id != '' && servicio_id != '' && producto_id != '' && cantidad != '' && valor != '';

            if (validaRequeridos) {

                var datos = "FUNCION=updateDetalle&servicio_id=" + servicio_id + "&detalle_servicio_id=" + detalle_servicio_id + "&producto_id=" + producto_id + "&concepto=" + concepto + "&cantidad=" + cantidad + "&valor=" + valor;

                $.ajax({
                    url: 'process/servicio.process.php',
                    type: 'POST',
                    data: datos,
                    dataType: 'json',
                    success: function(resp) {

                        var json = resp;
                        if (json != '') {

                            var tableBody = $('#detalles').find("tbody");
                            tableBody.find("tr").remove();


                            for (var i = 0; i < json.length; i++) {

                                var detalle_servicio = json[i]['detalle_servicio'];
                                var detalle_servicio_id = detalle_servicio['detalle_servicio_id'];
                                var habitacion_id = detalle_servicio['habitacion_id'];
                                var habitacion = detalle_servicio['habitacion'];
                                var producto_id = detalle_servicio['producto_id'];
                                var producto = detalle_servicio['producto'];
                                var observacion = detalle_servicio['concepto'];
                                var cantidad = detalle_servicio['cantidad'];
                                var valor = detalle_servicio['valor'];

                                if (habitacion_id > 0) {

                                    var htmlTags = '<tr>' +
                                        '<td>' + '<input type="hidden" id="detalle_servicio_id" value="' + detalle_servicio_id + '"><input type="hidden" id="habitacion_id_clon" value="' + habitacion_id + '">' + habitacion + '</td>' +
                                        '<td>' + '<input type="hidden" id="concepto_clon" value="' + observacion + '">' + observacion + '</td>' +
                                        '<td>' + '<input type="hidden" id="cantidad_clon" value="' + cantidad + '">' + cantidad + '</td>' +
                                        '<td>' + '<input type="hidden" id="valor_clon" value="' + valor + '">' + valor + '</td>' +
                                        '<td>' + '<button class="btn btn-primary" id="actualizar_detalle" data-toggle="modal" data-target="#modal_habitacion_actualizar"><i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '<td>' + '<button class="btn btn-danger" id="quitar"><i class="fa fa-trash" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '</tr>';
                                    $('#detalles tbody').append(htmlTags);

                                } else if (producto_id > 0) {

                                    var htmlTags = '<tr>' +
                                        '<td>' + '<input type="hidden" id="detalle_servicio_id" value="' + detalle_servicio_id + '"><input type="hidden" id="producto_id_clon" value="' + producto_id + '">' + producto + '</td>' +
                                        '<td>' + '<input type="hidden" id="concepto_clon" value="' + observacion + '">' + observacion + '</td>' +
                                        '<td>' + '<input type="hidden" id="cantidad_clon" value="' + cantidad + '">' + cantidad + '</td>' +
                                        '<td>' + '<input type="hidden" id="valor_clon" value="' + valor + '">' + valor + '</td>' +
                                        '<td>' + '<button class="btn btn-primary" id="actualizar_detalle_pro" data-toggle="modal" data-target="#modal_producto_actualizar"><i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '<td>' + '<button class="btn btn-danger" id="quitar"><i class="fa fa-trash" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '</tr>';
                                    $('#detalles tbody').append(htmlTags);

                                }

                            }
                            var total = json[0]['total'];
                            var valor_total = total['total'];

                            $("#total").val(valor_total);


                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Servicio Actualizado Exitosamente!',
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


            } else {
                Swal.fire(
                    'Atencion',
                    'Por favor digite los campos obligatorios!',
                    'info'
                )
            }

        }
    });

});



function verServicio(servicio_id) {

    window.location.href = "inicio.php?page=crearServicio&servicio_id=" + servicio_id;

}

function cargarDatos(servicio_id) {

    var datos = "FUNCION=getDate&servicio_id=" + servicio_id;

    $.ajax({
        url: 'process/servicio.process.php',
        type: 'POST',
        data: datos,
        success: function(resp) {

            var json = $.parseJSON(resp);

            if (json != '') {

                var servicio = json[0]['servicio'];
                var detalles = json[0]['detalles'];

                var servicio_id = servicio['servicio_id'];
                var cliente = servicio['cliente'];
                var numero_identificacion = servicio['numero_identificacion'];
                var cliente_id = servicio['cliente_id'];
                var fecha = servicio['fecha'];
                var hora = servicio['hora'];
                var estado = servicio['estado'];
                var valor_total = servicio['valor_total'];

                $('#servicio_id').val(servicio_id);
                $('#cliente').val(cliente);
                $('#numero_identificacion').val(numero_identificacion);
                $('#cliente_id').val(cliente_id);
                $('#fecha').val(fecha);
                $('#hora').val(hora);
                $('#estado').val(estado);
                $('#total').val(valor_total);

                if (detalles != null) {

                    var tableBody = $('#detalles').find("tbody");
                    tableBody.find("tr").remove();

                    for (var i = 0; i < json.length; i++) {

                        var detalle_servicio = json[i]['detalles'];
                        var detalle_servicio_id = detalle_servicio['detalle_servicio_id'];
                        var habitacion_id = detalle_servicio['habitacion_id'];
                        var habitacion = detalle_servicio['habitacion'];
                        var producto_id = detalle_servicio['producto_id'];
                        var producto = detalle_servicio['producto'];
                        var observacion = detalle_servicio['concepto'];
                        var cantidad = detalle_servicio['cantidad'];
                        var valor = detalle_servicio['valor'];

                        if (habitacion_id > 0) {

                            var htmlTags = '<tr>' +
                                '<td>' + '<input type="hidden" id="detalle_servicio_id" value="' + detalle_servicio_id + '"><input type="hidden" id="habitacion_id_clon" value="' + habitacion_id + '">' + habitacion + '</td>' +
                                '<td>' + '<input type="hidden" id="concepto_clon" value="' + observacion + '">' + observacion + '</td>' +
                                '<td>' + '<input type="hidden" id="cantidad_clon" value="' + cantidad + '">' + cantidad + '</td>' +
                                '<td>' + '<input type="hidden" id="valor_clon" value="' + valor + '">' + valor + '</td>' +
                                '<td>' + '<button class="btn btn-primary" id="actualizar_detalle" data-toggle="modal" data-target="#modal_habitacion_actualizar"><i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                '<td>' + '<button class="btn btn-danger" id="quitar"><i class="fa fa-trash" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                '</tr>';
                            $('#detalles tbody').append(htmlTags);

                        } else if (producto_id > 0) {

                            var htmlTags = '<tr>' +
                                '<td>' + '<input type="hidden" id="detalle_servicio_id" value="' + detalle_servicio_id + '"><input type="hidden" id="producto_id_clon" value="' + producto_id + '">' + producto + '</td>' +
                                '<td>' + '<input type="hidden" id="concepto_clon" value="' + observacion + '">' + observacion + '</td>' +
                                '<td>' + '<input type="hidden" id="cantidad_clon" value="' + cantidad + '">' + cantidad + '</td>' +
                                '<td>' + '<input type="hidden" id="valor_clon" value="' + valor + '">' + valor + '</td>' +
                                '<td>' + '<button class="btn btn-primary" id="actualizar_detalle_pro" data-toggle="modal" data-target="#modal_producto_actualizar"><i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                '<td>' + '<button class="btn btn-danger" id="quitar"><i class="fa fa-trash" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                '</tr>';
                            $('#detalles tbody').append(htmlTags);

                        }
                    }
                }


                document.getElementById('detalles_servicio').style.display = '';

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