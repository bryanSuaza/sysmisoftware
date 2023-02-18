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

    $('#servicio').click(function() {
        var cliente_id = $("#cliente_id").val();

        var datos = "FUNCION=getServicios&cliente_id=" + cliente_id;

        $.ajax({
            url: 'process/factura.process.php',
            type: 'POST',
            data: datos,
            success: function(resp) {

                var json = $.parseJSON(resp);


                if (json != '') {

                    var tableBody = $('#detalles_modal').find("tbody");
                    tableBody.find("tr").remove();
                    for (var i = 0; i < json.length; i++) {

                        var servicio = json[i]['servicio'];
                        var servicio_id = servicio['servicio_id'];
                        var cliente = servicio['cliente'];
                        var fecha = servicio['fecha'];
                        var valor = servicio['valor'];

                        var htmlTags = '<tr>' +
                            '<td>' + '<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" id="checkbox" name="servicio_id" value="' + servicio_id + '"></div>' + '</td>' +
                            '<td>' + servicio_id + '</td>' +
                            '<td>' + cliente + '</td>' +
                            '<td>' + fecha + '</td>' +
                            '<td>' + valor + '</td>' +
                            '</tr>';
                        $('#detalles_modal tbody').append(htmlTags);

                    }
                }
            }
        });

    });

    $("#checkboxAll").change(function() {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $("#checkboxDetalleAll").change(function() {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $("#eliminar_servicio").click(function() {
        eliminarDetalleServicio();
    });

    var factura_id = $("#factura_id").val();
    if (factura_id > 0) {
        cargarDatos(factura_id);
    }

    $('#table_facturas').DataTable();

    //busqueda inteligente
    $('#buscar').autocomplete({
        source: function(data, cb) {

            var datos = "FUNCION=serch&busqueda=" + data.term;

            $.ajax({
                url: 'process/factura.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {
                    var d = $.map(resp, function(factura_id) {
                        return {
                            label: factura_id,
                            value: factura_id
                        }
                    });

                    cb(d);
                }
            });
        },

        select: function(event, ui) {

            $('#form')[0].reset();

            var factura = ui.item.value;
            var arrayfactura = factura.split(' ');
            var factura_id = arrayfactura[0];

            var datos = "FUNCION=getDate&factura_id=" + factura_id;

            $.ajax({
                url: 'process/factura.process.php',
                type: 'POST',
                data: datos,
                success: function(resp) {

                    var json = $.parseJSON(resp);

                    if (json != '') {

                        var factura = json[0]['factura'];
                        var detalles = json[0]['detalles'];

                        var factura_id = factura['factura_id'];
                        var cliente = factura['cliente'];
                        var numero_identificacion = factura['numero_identificacion'];
                        var cliente_id = factura['cliente_id'];
                        var fecha = factura['fecha'];
                        var estado = factura['estado'];
                        var valor_total = factura['valor_total'];
                        var impuesto = factura['impuesto'];
                        var descuento = factura['descuento'];
                        var base = factura['base'];

                        $('#factura_id').val(factura_id);
                        $('#cliente').val(cliente);
                        $('#numero_identificacion').val(numero_identificacion);
                        $('#cliente_id').val(cliente_id);
                        $('#fecha').val(fecha);
                        $('#estado').val(estado);
                        $('#valor_total').val(valor_total);
                        $('#total').val(valor_total);
                        $('#impuesto_total').val(impuesto);
                        $('#descuento_total').val(descuento);
                        $('#base_total').val(base);

                        if (detalles != null) {

                            var tableBody = $('#detalles').find("tbody");
                            tableBody.find("tr").remove();

                            for (var i = 0; i < json.length; i++) {

                                var detalle_factura = json[i]['detalles'];
                                var detalle_factura_id = detalle_factura['detalle_factura_id'];
                                var servicio_id = detalle_factura['servicio_id'];
                                var producto_id = detalle_factura['producto_id'];
                                var concepto = detalle_factura['concepto'];
                                var cantidad = detalle_factura['cantidad'];
                                var valor_unitario = detalle_factura['valor_unitario'];
                                var iva = detalle_factura['iva'];
                                var descuento = detalle_factura['descuento'];

                                if (iva == null || iva == '') {
                                    iva = 0;
                                }

                                if (descuento == null || descuento == '') {
                                    descuento = 0;
                                }
                                var subtotal = detalle_factura['subtotal'];

                                if (producto_id > 0) {

                                    var htmlTags = '<tr>' +
                                        '<td>' + '<input type="hidden" id="detalle_factura_id" value="' + detalle_factura_id + '"><input type="hidden" id="producto_id_clon" value="' + producto_id + '"><input type="hidden" id="cantidad_clon" value="' + cantidad + '">' + cantidad + '</td>' +
                                        '<td>' + '<input type="hidden" id="concepto_clon" value="' + concepto + '">' + concepto + '</td>' +
                                        '<td>' + valor_unitario + '</td>' +
                                        '<td>' + '<input type="hidden" id="descuento_clon" value="' + descuento + '">' + descuento + '</td>' +
                                        '<td>' + '<input type="hidden" id="iva_clon" value="' + iva + '">' + iva + '</td>' +
                                        '<td>' + '<input type="hidden" id="subtotal_clon" value="' + subtotal + '">' + subtotal + '</td>' +
                                        '<td>' + '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_producto_actualizar" > <i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '<td>' + '<button class="btn btn-danger" id="quitar"><i class="fa fa-trash" style="font-size:24px;" aria-hidden="true"></i></button></td>' +
                                        '</tr>';
                                    $('#detalles tbody').append(htmlTags);

                                } else if (servicio_id > 0) {

                                    var htmlTags = '<tr>' +
                                        '<td>' + '<input type="hidden" id="detalle_factura_id" value="' + detalle_factura_id + '"></input>' + cantidad + '</td>' +
                                        '<td>' + concepto + '</td>' +
                                        '<td>' + valor_unitario + '</td>' +
                                        '<td>' + '<input type="hidden" id="descuento_clon" value="' + descuento + '">' + descuento + '</td>' +
                                        '<td>' + '<input type="hidden" id="iva_clon" value="' + iva + '">' + iva + '</td>' +
                                        '<td>' + subtotal + '</td>' +
                                        '<td>' + '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_servicio_actualizar" > <i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '<td>' + '<input type="checkbox" name="detalle_factura_id"  value="' + detalle_factura_id + '" disabled></td>' +
                                        '</tr>';
                                    $('#detalles tbody').append(htmlTags);

                                }
                            }

                        }


                        document.getElementById('detalles_factura').style.display = '';

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
        var estado = $('#estado').val();

        var validaRequeridos = cliente_id != '' && fecha != '' && estado != '';

        if (validaRequeridos) {

            var datos = "FUNCION=save&estado=" + estado + "&" + $('#form').serialize();

            $.ajax({
                url: 'process/factura.process.php',
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

                        $('#factura_id').val(json);
                        document.getElementById('detalles_factura').style.display = '';

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

        var factura_id = $('#factura_id').val();
        var cliente_id = $('#cliente_id').val();
        var fecha = $('#fecha').val();
        var hora = $('#hora').val();
        var estado = $('#estado').val();
        var usuario_id = $('#usuario_id').val();

        var validaRequeridos = factura_id != '' && cliente_id != '' && fecha != '' && hora != '' && estado != '';

        if (validaRequeridos) {

            var datos = "FUNCION=update&usuario_id=" + usuario_id + "&estado=" + estado + "&" + $('#form').serialize();

            $.ajax({
                url: 'process/factura.process.php',
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

        var factura_id = $('#factura_id').val();

        var validaRequeridos = factura_id != '';

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
                    var datos = "FUNCION=delete&factura_id=" + factura_id;

                    $.ajax({
                        url: 'process/factura.process.php',
                        type: 'POST',
                        data: datos,
                        dataType: 'json',
                        success: function(resp) {

                            var json = $.parseJSON(resp);
                            if (json == 1) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'factura Eliminado Exitosamente!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                $('#form')[0].reset();
                                $('#buscar').val('');

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

    //busqueda cliente
    $('#cliente').autocomplete({
        source: function(data, cb) {

            var datos = "FUNCION=serchCliente&busqueda=" + data.term;

            $.ajax({
                url: 'process/factura.process.php',
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
                url: 'process/factura.process.php',
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

    if (document.getElementById('detalles_factura')) {
        document.getElementById('detalles_factura').style.display = 'none';
    }

    $("#habitacion_id, #habitacion_id_modal").blur(function() {

        var habitacion_id = $(this).val();

        var datos = "FUNCION=getValorHabitacion&habitacion_id=" + habitacion_id;

        $.ajax({
            url: 'process/factura.process.php',
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
            url: 'process/factura.process.php',
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
            url: 'process/factura.process.php',
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
            url: 'process/factura.process.php',
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

        var detalle_factura_id = $(this).parents("tr").find("#detalle_factura_id").val();
        var factura_id = $("#factura_id").val();

        if (detalle_factura_id > 0) {

            var validaRequeridos = detalle_factura_id != '' && factura_id != '';

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
                        var datos = "FUNCION=deleteDetalle&detalle_factura_id=" + detalle_factura_id + "&factura_id=" + factura_id;

                        $.ajax({
                            url: 'process/factura.process.php',
                            type: 'POST',
                            data: datos,
                            dataType: 'json',
                            success: function(resp) {

                                var json = resp;
                                if (json != '' && json != null) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Detalle factura Eliminado Exitosamente!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    var desc_total = json['desc_total'];


                                    var base = desc_total['base'];
                                    var total = desc_total['total'];
                                    var valor_descuento = desc_total['descuento'];
                                    var valor_iva = desc_total['iva'];

                                    $("#valor_total").val(total);
                                    $("#total").val(total);
                                    $("#base_total").val(base);

                                    if (valor_descuento > 0) {
                                        $("#descuento_total").val(valor_descuento);
                                    } else {
                                        $("#descuento_total").val(0);
                                    }

                                    if (valor_iva > 0) {
                                        $("#impuesto_total").val(valor_iva);
                                    } else {
                                        $("#impuesto_total").val(0);
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

    //funcion guardar detalle servicio ejecutada desde el modal
    $('#guardar_detalle_servicio').click(function() {

        var factura_id = $('#factura_id').val();
        var servicio = [];

        $('input:checkbox[name=servicio_id]:checked').each(function() {
            var servicio_id = $(this).val();
            servicio.push(servicio_id);
        });

        var validaRequeridos = factura_id != '' && servicio != '';

        if (validaRequeridos) {

            var datos = "FUNCION=saveDetalleServ&factura_id=" + factura_id + "&servicio=" + servicio;

            $.ajax({
                url: 'process/factura.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {

                    var json = resp;
                    if (json != '' && json != null) {

                        var detalle_factura = json[0]['detalle_factura'];
                        var desc_total = json[0]['desc_total'];

                        var base = desc_total['base'];
                        var total = desc_total['total'];
                        var valor_descuento = desc_total['descuento'];
                        var valor_iva = desc_total['iva'];

                        $("#valor_total").val(total);
                        $("#total").val(total);
                        $("#base_total").val(base);

                        if (valor_descuento > 0) {
                            $("#descuento_total").val(valor_descuento);
                        } else {
                            $("#descuento_total").val(0);
                        }

                        if (valor_iva > 0) {
                            $("#impuesto_total").val(valor_iva);
                        } else {
                            $("#impuesto_total").val(0);
                        }


                        if (detalle_factura != null) {

                            var tableBody = $('#detalles').find("tbody");
                            tableBody.find("tr").remove();

                            for (var i = 0; i < json.length; i++) {

                                var detalle_factura = json[i]['detalle_factura'];
                                var detalle_factura_id = detalle_factura['detalle_factura_id'];
                                var servicio_id = detalle_factura['servicio_id'];
                                var producto_id = detalle_factura['producto_id'];
                                var concepto = detalle_factura['concepto'];
                                var cantidad = detalle_factura['cantidad'];
                                var valor_unitario = detalle_factura['valor_unitario'];
                                var descuento = detalle_factura['descuento'];
                                var iva = detalle_factura['iva'];

                                if (iva == null || iva == '') {
                                    iva = 0;
                                }

                                if (descuento == null || descuento == '') {
                                    descuento = 0;
                                }

                                var subtotal = detalle_factura['subtotal'];

                                if (producto_id > 0) {

                                    var htmlTags = '<tr>' +
                                        '<td>' + '<input type="hidden" id="detalle_factura_id" value="' + detalle_factura_id + '"><input type="hidden" id="producto_id_clon" value="' + producto_id + '"><input type="hidden" id="cantidad_clon" value="' + cantidad + '">' + cantidad + '</td>' +
                                        '<td>' + '<input type="hidden" id="concepto_clon" value="' + concepto + '">' + concepto + '</td>' +
                                        '<td>' + valor_unitario + '</td>' +
                                        '<td>' + '<input type="hidden" id="descuento_clon" value="' + descuento + '">' + descuento + '</td>' +
                                        '<td>' + '<input type="hidden" id="iva_clon" value="' + iva + '">' + iva + '</td>' +
                                        '<td>' + '<input type="hidden" id="subtotal_clon" value="' + subtotal + '">' + subtotal + '</td>' +
                                        '<td>' + '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_producto_actualizar" > <i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '<td>' + '<button class="btn btn-danger" id="quitar"><i class="fa fa-trash" style="font-size:24px;" aria-hidden="true"></i></button></td>' +
                                        '</tr>';
                                    $('#detalles tbody').append(htmlTags);

                                } else if (servicio_id > 0) {

                                    var htmlTags = '<tr>' +
                                        '<td>' + '<input type="hidden" id="detalle_factura_id" value="' + detalle_factura_id + '"></input>' + cantidad + '</td>' +
                                        '<td>' + concepto + '</td>' +
                                        '<td>' + valor_unitario + '</td>' +
                                        '<td>' + '<input type="hidden" id="descuento_clon" value="' + descuento + '">' + descuento + '</td>' +
                                        '<td>' + '<input type="hidden" id="iva_clon" value="' + iva + '">' + iva + '</td>' +
                                        '<td>' + subtotal + '</td>' +
                                        '<td>' + '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_servicio_actualizar" > <i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '<td>' + '<input type="checkbox" name="detalle_factura_id"  value="' + detalle_factura_id + '" disabled></td>' +
                                        '</tr>';
                                    $('#detalles tbody').append(htmlTags);

                                }
                            }

                        }

                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Factura Guardada Exitosamente!',
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
                'Debe seleccionar al menos un servicio!',
                'info'
            )
        }
    });

    //funcion guardar detalle producto
    $('#guardar_detalle_producto').click(function() {

        var factura_id = $('#factura_id').val();
        var producto_id = $("#producto_id").val();
        var concepto = $("#concepto_pro").val();
        var cantidad = $("#cantidad_pro").val();
        var valor = $("#valor_pro").val();

        var validaRequeridos = factura_id != '' && producto_id != '' && cantidad != '' && valor != '';

        if (validaRequeridos) {

            var datos = "FUNCION=saveDetalle&factura_id=" + factura_id + "&producto_id=" + producto_id + "&concepto=" + concepto + "&cantidad=" + cantidad + "&valor=" + valor;

            $.ajax({
                url: 'process/factura.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {

                    var json = resp;
                    if (json != '' && json != null) {

                        var detalle_factura = json[0]['detalle_factura'];
                        var desc_total = json[0]['desc_total'];

                        var base = desc_total['base'];
                        var total = desc_total['total'];
                        var valor_descuento = desc_total['descuento'];
                        var valor_iva = desc_total['iva'];

                        $("#valor_total").val(total);
                        $("#total").val(total);
                        $("#base_total").val(base);

                        if (valor_descuento > 0) {
                            $("#descuento_total").val(valor_descuento);
                        } else {
                            $("#descuento_total").val(0);
                        }

                        if (valor_iva > 0) {
                            $("#impuesto_total").val(valor_iva);
                        } else {
                            $("#impuesto_total").val(0);
                        }

                        if (detalle_factura != null) {

                            var tableBody = $('#detalles').find("tbody");
                            tableBody.find("tr").remove();

                            for (var i = 0; i < json.length; i++) {

                                var detalle_factura = json[i]['detalle_factura'];
                                var detalle_factura_id = detalle_factura['detalle_factura_id'];
                                var servicio_id = detalle_factura['servicio_id'];
                                var producto_id = detalle_factura['producto_id'];
                                var concepto = detalle_factura['concepto'];
                                var cantidad = detalle_factura['cantidad'];
                                var valor_unitario = detalle_factura['valor_unitario'];
                                var descuento = detalle_factura['descuento'];
                                var iva = detalle_factura['iva'];

                                if (iva == null || iva == '') {
                                    iva = 0;
                                }

                                if (descuento == null || descuento == '') {
                                    descuento = 0;
                                }

                                var subtotal = detalle_factura['subtotal'];

                                if (producto_id > 0) {

                                    var htmlTags = '<tr>' +
                                        '<td>' + '<input type="hidden" id="detalle_factura_id" value="' + detalle_factura_id + '"><input type="hidden" id="producto_id_clon" value="' + producto_id + '"><input type="hidden" id="cantidad_clon" value="' + cantidad + '">' + cantidad + '</td>' +
                                        '<td>' + '<input type="hidden" id="concepto_clon" value="' + concepto + '">' + concepto + '</td>' +
                                        '<td>' + valor_unitario + '</td>' +
                                        '<td>' + '<input type="hidden" id="descuento_clon" value="' + descuento + '">' + descuento + '</td>' +
                                        '<td>' + '<input type="hidden" id="iva_clon" value="' + iva + '">' + iva + '</td>' +
                                        '<td>' + '<input type="hidden" id="subtotal_clon" value="' + subtotal + '">' + subtotal + '</td>' +
                                        '<td>' + '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_producto_actualizar" > <i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '<td>' + '<button class="btn btn-danger" id="quitar"><i class="fa fa-trash" style="font-size:24px;" aria-hidden="true"></i></button></td>' +
                                        '</tr>';
                                    $('#detalles tbody').append(htmlTags);

                                } else if (servicio_id > 0) {

                                    var htmlTags = '<tr>' +
                                        '<td>' + '<input type="hidden" id="detalle_factura_id" value="' + detalle_factura_id + '"></input>' + cantidad + '</td>' +
                                        '<td>' + concepto + '</td>' +
                                        '<td>' + valor_unitario + '</td>' +
                                        '<td>' + '<input type="hidden" id="descuento_clon" value="' + descuento + '">' + descuento + '</td>' +
                                        '<td>' + '<input type="hidden" id="iva_clon" value="' + iva + '">' + iva + '</td>' +
                                        '<td>' + subtotal + '</td>' +
                                        '<td>' + '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_servicio_actualizar" > <i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '<td>' + '<input type="checkbox" name="detalle_factura_id"  value="' + detalle_factura_id + '" disabled></td>' +
                                        '</tr>';
                                    $('#detalles tbody').append(htmlTags);

                                }
                            }

                        }

                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Factura Guardada Exitosamente!',
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

        var detalle_factura_id = $(this).parents("tr").find("#detalle_factura_id").val();
        var producto_id = $(this).parents("tr").find("#producto_id_clon").val();
        var concepto = $(this).parents("tr").find("#concepto_clon").val();
        var cantidad = $(this).parents("tr").find("#cantidad_clon").val();
        var iva = $(this).parents("tr").find("#iva_clon").val();
        var descuento = $(this).parents("tr").find("#descuento_clon").val();
        var valor = $(this).parents("tr").find("#subtotal_clon").val();

        $('#detalle_factura_id_modal').val(detalle_factura_id);
        $('#iva_modal').val(iva);
        $('#descuento_modal').val(descuento);

        $('#detalle_factura_id_modal_pro').val(detalle_factura_id);
        $('#producto_id_modal').val(producto_id);
        $('#concepto_modal_pro').val(concepto);
        $('#cantidad_modal_pro').val(cantidad);
        $('#valor_modal_pro').val(valor);
        $('#iva_modal_pro').val(iva);
        $('#descuento_modal_pro').val(descuento);
    });

    //funcion actualizar detalle servicio
    $('#actualizar_detalle_servicio').click(function() {

        var factura_id = $('#factura_id').val();
        var detalle_factura_id = $('#detalle_factura_id_modal').val();
        var iva = $("#iva_modal").val();
        var descuento = $("#descuento_modal").val();

        if (detalle_factura_id > 0) {

            var validaRequeridos = detalle_factura_id != '' && factura_id != '';

            if (validaRequeridos) {

                var datos = "FUNCION=updateDetalleServicio&factura_id=" + factura_id + "&detalle_factura_id=" + detalle_factura_id + "&iva=" + iva + "&descuento=" + descuento;

                $.ajax({
                    url: 'process/factura.process.php',
                    type: 'POST',
                    data: datos,
                    dataType: 'json',
                    success: function(resp) {

                        var json = resp;
                        if (json != '') {

                            var tableBody = $('#detalles').find("tbody");
                            tableBody.find("tr").remove();


                            for (var i = 0; i < json.length; i++) {

                                var detalle_factura = json[i]['detalle_factura'];
                                var desc_total = json[0]['desc_total'];

                                var base = desc_total['base'];
                                var descuento = desc_total['descuento'];
                                var impuesto = desc_total['impuesto'];
                                var total = desc_total['total'];

                                $("#valor_total").val(total);
                                $("#total").val(total);
                                $("#base_total").val(base);
                                $("#impuesto_total").val(impuesto);
                                $("#descuento_total").val(descuento);

                                var detalle_factura_id = detalle_factura['detalle_factura_id'];
                                var servicio_id = detalle_factura['servicio_id'];
                                var producto_id = detalle_factura['producto_id'];
                                var producto = detalle_factura['producto'];
                                var concepto = detalle_factura['concepto'];
                                var cantidad = detalle_factura['cantidad'];
                                var valor_unitario = detalle_factura['valor_unitario'];
                                var descuento = detalle_factura['descuento'];
                                var iva = detalle_factura['iva'];
                                var subtotal = detalle_factura['subtotal'];

                                if (iva == null || iva == '') {
                                    iva = 0;
                                }

                                if (descuento == null || descuento == '') {
                                    descuento = 0;
                                }

                                if (servicio_id > 0) {

                                    var htmlTags = '<tr>' +
                                        '<td>' + '<input type="hidden" id="detalle_factura_id" value="' + detalle_factura_id + '"></input>' + cantidad + '</td>' +
                                        '<td>' + concepto + '</td>' +
                                        '<td>' + valor_unitario + '</td>' +
                                        '<td>' + '<input type="hidden" id="descuento_clon" value="' + descuento + '">' + descuento + '</td>' +
                                        '<td>' + '<input type="hidden" id="iva_clon" value="' + iva + '">' + iva + '</td>' +
                                        '<td>' + subtotal + '</td>' +
                                        '<td>' + '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_servicio_actualizar" > <i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '<td>' + '<input type="checkbox" name="detalle_factura_id"  value="' + detalle_factura_id + '" disabled></td>' +
                                        '</tr>';
                                    $('#detalles tbody').append(htmlTags);

                                } else if (producto_id > 0) {

                                    var htmlTags = '<tr>' +
                                        '<td>' + '<input type="hidden" id="detalle_factura_id" value="' + detalle_factura_id + '"><input type="hidden" id="producto_id_clon" value="' + producto_id + '"><input type="hidden" id="cantidad_clon" value="' + cantidad + '">' + cantidad + '</td>' +
                                        '<td>' + '<input type="hidden" id="concepto_clon" value="' + concepto + '">' + concepto + '</td>' +
                                        '<td>' + valor_unitario + '</td>' +
                                        '<td>' + '<input type="hidden" id="descuento_clon" value="' + descuento + '">' + descuento + '</td>' +
                                        '<td>' + '<input type="hidden" id="iva_clon" value="' + iva + '">' + iva + '</td>' +
                                        '<td>' + '<input type="hidden" id="subtotal_clon" value="' + subtotal + '">' + subtotal + '</td>' +
                                        '<td>' + '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_producto_actualizar" > <i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                        '<td>' + '<button class="btn btn-danger" id="quitar"><i class="fa fa-trash" style="font-size:24px;" aria-hidden="true"></i></button></td>' +
                                        '</tr>';

                                    $('#detalles tbody').append(htmlTags);

                                }

                            }



                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Factura Actualizada Exitosamente!',
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

        var factura_id = $('#factura_id').val();
        var detalle_factura_id = $('#detalle_factura_id_modal_pro').val();
        var producto_id = $("#producto_id_modal").val();
        var concepto = $("#concepto_modal_pro").val();
        var cantidad = $("#cantidad_modal_pro").val();
        var valor = $("#valor_modal_pro").val();
        var iva = $("#iva_modal_pro").val();
        var descuento = $("#descuento_modal_pro").val();

        if (detalle_factura_id > 0) {

            var validaRequeridos = detalle_factura_id != '' && factura_id != '' && producto_id != '' && cantidad != '' && valor != '';

            if (validaRequeridos) {

                var datos = "FUNCION=updateDetalle&factura_id=" + factura_id + "&detalle_factura_id=" + detalle_factura_id + "&producto_id=" + producto_id + "&concepto=" + concepto + "&cantidad=" + cantidad + "&valor=" + valor + "&iva=" + iva + "&descuento=" + descuento;

                $.ajax({
                    url: 'process/factura.process.php',
                    type: 'POST',
                    data: datos,
                    dataType: 'json',
                    success: function(resp) {

                        var json = resp;
                        if (json != '') {

                            var detalle_factura = json[0]['detalle_factura'];
                            var desc_total = json[0]['desc_total'];

                            var base = desc_total['base'];
                            var total = desc_total['total'];
                            var valor_descuento = desc_total['descuento'];
                            var valor_iva = desc_total['impuesto'];


                            $("#valor_total").val(total);
                            $("#total").val(total);
                            $("#base_total").val(base);

                            if (valor_descuento > 0) {
                                $("#descuento_total").val(valor_descuento);
                            } else {
                                $("#descuento_total").val(0);
                            }

                            if (valor_iva > 0) {
                                $("#impuesto_total").val(valor_iva);
                            } else {
                                $("#impuesto_total").val(0);
                            }

                            if (detalle_factura != null) {

                                var tableBody = $('#detalles').find("tbody");
                                tableBody.find("tr").remove();

                                for (var i = 0; i < json.length; i++) {

                                    var detalle_factura = json[i]['detalle_factura'];
                                    var detalle_factura_id = detalle_factura['detalle_factura_id'];
                                    var servicio_id = detalle_factura['servicio_id'];
                                    var producto_id = detalle_factura['producto_id'];
                                    var concepto = detalle_factura['concepto'];
                                    var cantidad = detalle_factura['cantidad'];
                                    var valor_unitario = detalle_factura['valor_unitario'];
                                    var descuento = detalle_factura['descuento'];
                                    var iva = detalle_factura['iva'];

                                    if (iva == null || iva == '') {
                                        iva = 0;
                                    }

                                    if (descuento == null || descuento == '') {
                                        descuento = 0;
                                    }

                                    var subtotal = detalle_factura['subtotal'];

                                    if (producto_id > 0) {

                                        var htmlTags = '<tr>' +
                                            '<td>' + '<input type="hidden" id="detalle_factura_id" value="' + detalle_factura_id + '"><input type="hidden" id="producto_id_clon" value="' + producto_id + '"><input type="hidden" id="cantidad_clon" value="' + cantidad + '">' + cantidad + '</td>' +
                                            '<td>' + '<input type="hidden" id="concepto_clon" value="' + concepto + '">' + concepto + '</td>' +
                                            '<td>' + valor_unitario + '</td>' +
                                            '<td>' + '<input type="hidden" id="descuento_clon" value="' + descuento + '">' + descuento + '</td>' +
                                            '<td>' + '<input type="hidden" id="iva_clon" value="' + iva + '">' + iva + '</td>' +
                                            '<td>' + '<input type="hidden" id="subtotal_clon" value="' + subtotal + '">' + subtotal + '</td>' +
                                            '<td>' + '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_producto_actualizar" > <i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                            '<td>' + '<button class="btn btn-danger" id="quitar"><i class="fa fa-trash" style="font-size:24px;" aria-hidden="true"></i></button></td>' +
                                            '</tr>';
                                        $('#detalles tbody').append(htmlTags);

                                    } else if (servicio_id > 0) {

                                        var htmlTags = '<tr>' +
                                            '<td>' + '<input type="hidden" id="detalle_factura_id" value="' + detalle_factura_id + '"></input>' + cantidad + '</td>' +
                                            '<td>' + concepto + '</td>' +
                                            '<td>' + valor_unitario + '</td>' +
                                            '<td>' + '<input type="hidden" id="descuento_clon" value="' + descuento + '">' + descuento + '</td>' +
                                            '<td>' + '<input type="hidden" id="iva_clon" value="' + iva + '">' + iva + '</td>' +
                                            '<td>' + subtotal + '</td>' +
                                            '<td>' + '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_servicio_actualizar" > <i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                            '<td>' + '<input type="checkbox" name="detalle_factura_id"  value="' + detalle_factura_id + '" disabled></td>' +
                                            '</tr>';
                                        $('#detalles tbody').append(htmlTags);

                                    }
                                }

                            }


                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'factura Actualizada Exitosamente!',
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



function verfactura(factura_id) {

    window.location.href = "inicio.php?page=crearfactura&factura_id=" + factura_id;

}

function cargarDatos(factura_id) {

    var datos = "FUNCION=getDate&factura_id=" + factura_id;

    $.ajax({
        url: 'process/factura.process.php',
        type: 'POST',
        data: datos,
        success: function(resp) {

            var json = $.parseJSON(resp);

            if (json != '') {

                var factura = json[0]['factura'];
                var detalles = json[0]['detalles'];

                var factura_id = factura['factura_id'];
                var cliente = factura['cliente'];
                var numero_identificacion = factura['numero_identificacion'];
                var cliente_id = factura['cliente_id'];
                var fecha = factura['fecha'];
                var hora = factura['hora'];
                var estado = factura['estado'];
                var valor_total = factura['valor_total'];

                $('#factura_id').val(factura_id);
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

                        var detalle_factura = json[i]['detalles'];
                        var detalle_factura_id = detalle_factura['detalle_factura_id'];
                        var habitacion_id = detalle_factura['habitacion_id'];
                        var habitacion = detalle_factura['habitacion'];
                        var producto_id = detalle_factura['producto_id'];
                        var producto = detalle_factura['producto'];
                        var observacion = detalle_factura['concepto'];
                        var cantidad = detalle_factura['cantidad'];
                        var valor = detalle_factura['valor'];

                        if (habitacion_id > 0) {

                            var htmlTags = '<tr>' +
                                '<td>' + '<input type="hidden" id="detalle_factura_id" value="' + detalle_factura_id + '"><input type="hidden" id="habitacion_id_clon" value="' + habitacion_id + '">' + habitacion + '</td>' +
                                '<td>' + '<input type="hidden" id="concepto_clon" value="' + observacion + '">' + observacion + '</td>' +
                                '<td>' + '<input type="hidden" id="cantidad_clon" value="' + cantidad + '">' + cantidad + '</td>' +
                                '<td>' + '<input type="hidden" id="valor_clon" value="' + valor + '">' + valor + '</td>' +
                                '<td>' + '<button class="btn btn-primary" id="actualizar_detalle" data-toggle="modal" data-target="#modal_habitacion_actualizar"><i class="fa fa-pencil" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                '<td>' + '<button class="btn btn-danger" id="quitar"><i class="fa fa-trash" style="font-size:24px;" aria-hidden="true"></i></button>' + '</td>' +
                                '</tr>';
                            $('#detalles tbody').append(htmlTags);

                        } else if (producto_id > 0) {

                            var htmlTags = '<tr>' +
                                '<td>' + '<input type="hidden" id="detalle_factura_id" value="' + detalle_factura_id + '"><input type="hidden" id="producto_id_clon" value="' + producto_id + '">' + producto + '</td>' +
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


                document.getElementById('detalles_factura').style.display = '';

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

//funcion eliminar servicios
function eliminarDetalleServicio() {

    var factura_id = $('#factura_id').val();
    var detalle_factura = [];

    $('input:checkbox[name=detalle_factura_id]:checked').each(function() {
        var detalle_factura_id = $(this).val();
        detalle_factura.push(detalle_factura_id);
    });
    console.log("detalle" + detalle_factura);
    if (detalle_factura != '') {

        Swal.fire({
            title: 'Deseas eliminar los servicios del detalle de la factura?',
            text: "Clik en cancelar si no lo deseas!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                var datos = "FUNCION=deleteDetalleServicio&detalle_factura_id=" + detalle_factura + "&factura_id=" + factura_id;

                $.ajax({
                    url: 'process/factura.process.php',
                    type: 'POST',
                    data: datos,
                    dataType: 'json',
                    success: function(resp) {

                        var json = resp;

                        if (json != '' && json != null) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Detalle factura Eliminado Exitosamente!',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            var valor_total = json['total'];
                            var base = json['base'];
                            var descuento = json['descuento'];
                            var impuesto = json['impuesto'];

                            $("#valor_total").val(valor_total);
                            $("#total").val(valor_total);
                            $("#base_total").val(base);

                            if (impuesto > 0) {
                                $("#impuesto_total").val(impuesto);
                            } else {
                                $("#impuesto_total").val(0);
                            }

                            if (descuento > 0) {
                                $("#descuento_total").val(descuento);
                            } else {
                                $("#descuento_total").val(0);
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
                $('input:checkbox[name=detalle_factura_id]:checked').parents("tr").remove();
            }
        });

    } else {
        Swal.fire(
            'Atencion',
            'Por favor seleccione el checkbox principal para eliminar los detalles del servicio!',
            'error'
        )
    }

    return false;
}