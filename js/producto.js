$(document).ready(function () {

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
        source: function (data, cb) {

            var datos = "FUNCION=serch&busqueda=" + data.term;

            $.ajax({
                url: 'process/producto.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function (resp) {
                    var d = $.map(resp, function (producto_id) {
                        return {
                            label: producto_id,
                            value: producto_id
                        }
                    });

                    cb(d);
                }
            });
        },

        select: function (event, ui) {

            $('#form')[0].reset();

            var producto = ui.item.value;
            var arrayProducto = producto.split(' ');
            var producto_id = arrayProducto[0];

            var datos = "FUNCION=getDate&producto_id=" + producto_id;

            $.ajax({
                url: 'process/producto.process.php',
                type: 'POST',
                data: datos,
                success: function (resp) {

                    var json = $.parseJSON(resp);

                    if (json != '') {

                        var producto_id = json['producto_id'];
                        var categoria_id = json['categoria_id'];
                        var nombre = json['nombre'];
                        var valor_costo = json['valor_costo'];
                        var valor_venta = json['valor_venta'];
                        var estado = json['estado'];

                        $('#producto_id').val(producto_id);
                        $('#categoria_id').val(categoria_id);
                        $('#nombre').val(nombre);
                        $('#valor_costo').val(valor_costo);
                        $('#valor_venta').val(valor_venta);
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
    $('#guardar').click(function () {

        var nombre = $('#nombre').val();
        var categoria_id = $('#categoria_id').val();
        var valor_costo = $('#valor_costo').val();
        var valor_venta = $('#valor_venta').val();
        var estado = $('#estado').val();

        var validaRequeridos = nombre != '' && categoria_id != '' && valor_costo != '' && valor_venta != '' && estado != '';

        if (validaRequeridos) {

            var datos = "FUNCION=save&" + $('#form').serialize();

            $.ajax({
                url: 'process/producto.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function (resp) {

                    var json = $.parseJSON(resp);
                    if (json == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Producto Guardado Exitosamente!',
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
                        Swal.fire(
                            'Atencion',
                            'Ya existe un producto con el mismo nombre!',
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
        }

    });

    //funcion actualizar
    $('#actualizar').click(function () {

        var producto_id = $('#producto_id').val();
        var nombre = $('#nombre').val();
        var categoria_id = $('#categoria_id').val();
        var valor_costo = $('#valor_costo').val();
        var valor_venta = $('#valor_venta').val();
        var estado = $('#estado').val();

        var validaRequeridos = nombre != '' && categoria_id != '' && valor_costo != '' && valor_venta != '' && estado != '';

        if (validaRequeridos) {

            var datos = "FUNCION=update&"+ $('#form').serialize();

            $.ajax({
                url: 'process/producto.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function (resp) {

                    var json = $.parseJSON(resp);
                    if (json == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Producto Actualizado Exitosamente!',
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
                        Swal.fire(
                            'Atencion',
                            'Ya existe un producto con el mismo nombre!',
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
    $('#eliminar').click(function () {

        var producto_id = $('#producto_id').val();

        var validaRequeridos = producto_id != '';

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
                    var datos = "FUNCION=delete&producto_id=" + producto_id;

                    $.ajax({
                        url: 'process/producto.process.php',
                        type: 'POST',
                        data: datos,
                        dataType: 'json',
                        success: function (resp) {

                            var json = $.parseJSON(resp);
                            if (json == 1) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Producto Eliminado Exitosamente!',
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

    $('#limpiar').click(function () {
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