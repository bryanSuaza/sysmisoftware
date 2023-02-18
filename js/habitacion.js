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
                url: 'process/habitacion.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function (resp) {
                    var d = $.map(resp, function (habitacion_id) {
                        return {
                            label: habitacion_id,
                            value: habitacion_id
                        }
                    });

                    cb(d);
                }
            });
        },

        select: function (event, ui) {

            $('#form')[0].reset();

            var habitacion = ui.item.value;
            var habitacion_id = habitacion.substr(0, 1);

            var datos = "FUNCION=getDate&habitacion_id=" + habitacion_id;

            $.ajax({
                url: 'process/habitacion.process.php',
                type: 'POST',
                data: datos,
                success: function (resp) {

                    var json = $.parseJSON(resp);

                    if (json != '') {

                        var habitacion_id = json['habitacion_id'];
                        var numero = json['numero'];
                        var valor = json['valor'];
                        var descripcion = json['descripcion'];
                        var estado = json['estado'];
                        var tipo_habitacion_id = json['tipo_habitacion_id'];
                        var imagen = json['imagen'];
            
                        var ruta = 'process/img_uploads/' + imagen;

                        $('#habitacion_id').val(habitacion_id);
                        $('#numero').val(numero);
                        $('#valor').val(valor);
                        $('#descripcion').val(descripcion);
                        $('#tipo_habitacion_id').val(tipo_habitacion_id);
                        $('#estado').val(estado);
                        
                        if (imagen != ''){
                            $('#imagen').attr('src', '');
                            $('#imagen').attr('src',ruta);
                        }

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

        var numero = $('#numero').val();
        var valor = $('#valor').val();
        var descripcion = $('#descripcion').val();
        
        var data = new FormData($('#form')[0]);
        
        var validaRequeridos = numero != '' && valor != '' && descripcion != '';

        if (validaRequeridos) {
        
            data.append('FUNCION','save');

            $.ajax({
                url: 'process/habitacion.process.php',
                type: 'POST',
                data: data,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (resp) {

                    var json = $.parseJSON(resp);
                    if (json == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Habitación Guardada Exitosamente!',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $('#form')[0].reset();
                        $('#buscar').val('');
                        $('#imagen').attr('src', 'images/ejemploHabitacion.jpg');

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
                            'Ya existe un habitación con el mismo número!',
                            'warning'
                        )
                    } else if(json == 3) {
                        Swal.fire(
                            'Atencion',
                            'El tamaño de la imagen es demasiado grande!',
                            'info'
                        )
                    } else if (json == 4) {
                        Swal.fire(
                            'Atencion',
                            'El tipo de imagen debe tener formato JPG o PNG!',
                            'info'
                        )
                    }else{
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

        return false;
    });

    //funcion actualizar
    $('#actualizar').click(function () {

        var habitacion_id = $('#habitacion_id').val();
        var numero = $('#numero').val();
        var valor = $('#valor').val();
        var descripcion = $('#descripcion').val();

        var data = new FormData($('#form')[0]);

        var validaRequeridos = habitacion_id != '' && numero != '' && valor != '' && descripcion != '';

        if (validaRequeridos) {

            data.append('FUNCION', 'update');

            $.ajax({
                url: 'process/habitacion.process.php',
                type: 'POST',
                data: data,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (resp) {

                    var json = $.parseJSON(resp);
                    if (json == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Habitación Actualizada Exitosamente!',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $('#form')[0].reset();
                        $('#buscar').val('');
                        $('#imagen').attr('src', 'images/ejemploHabitacion.jpg');
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
                            'Ya existe un habitación con el mismo número de identificación!',
                            'warning'
                        )
                    } else if (json == 3) {
                        Swal.fire(
                            'Atencion',
                            'El tamaño de la imagen es demasiado grande!',
                            'info'
                        )
                    } else if (json == 4) {
                        Swal.fire(
                            'Atencion',
                            'El tipo de imagen debe tener formato JPG o PNG!',
                            'info'
                        )
                    }else {
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

        } else {
            Swal.fire(
                'Atencion',
                'Por favor digite los campos obligatorios!',
                'info'
            )
        }

        return false;
    });

    //funcion eliminar
    $('#eliminar').click(function () {

        var habitacion_id = $('#habitacion_id').val();

        var validaRequeridos = habitacion_id != '';

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
                    var datos = "FUNCION=delete&habitacion_id=" + habitacion_id;

                    $.ajax({
                        url: 'process/habitacion.process.php',
                        type: 'POST',
                        data: datos,
                        dataType: 'json',
                        success: function (resp) {

                            var json = $.parseJSON(resp);
                            if (json == 1) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Habitación Eliminada Exitosamente!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                $('#form')[0].reset();
                                $('#buscar').val('');
                                $('#imagen').attr('src', 'images/ejemploHabitacion.jpg');
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


        } else {
            Swal.fire(
                'Atencion',
                'Por favor digite los campos obligatorios!',
                'info'
            )
        }

        return false;
    });

    $('#limpiar').click(function () {
        $('#form')[0].reset();
        $('#buscar').val('');
        $('#imagen').attr('src', 'images/ejemploHabitacion.jpg');
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