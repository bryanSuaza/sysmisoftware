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

    var usuario_id = $("#usuario_id").val();
    if (usuario_id > 0) {
        cargarDatos(usuario_id);
    }

    $('#table_usuarios').DataTable({
        responsive: true
    });

    //busqueda inteligente
    $('#buscar').autocomplete({
        source: function(data, cb) {

            var datos = "FUNCION=serch&busqueda=" + data.term;

            $.ajax({
                url: 'process/usuario.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {
                    var d = $.map(resp, function(usuario_id) {
                        return {
                            label: usuario_id,
                            value: usuario_id
                        }
                    });

                    cb(d);
                }
            });
        },

        select: function(event, ui) {

            $('#form')[0].reset();

            var usuario = ui.item.value;
            var usuario_id = usuario.substr(0, 1);

            var datos = "FUNCION=getDate&usuario_id=" + usuario_id;

            $.ajax({
                url: 'process/usuario.process.php',
                type: 'POST',
                data: datos,
                success: function(resp) {

                    var json = $.parseJSON(resp);

                    if (json != '') {

                        var usuario_id = json['usuario_id'];
                        var tipo_persona_id = json['tipo_persona_id'];
                        var numero_identificacion = json['numero_identificacion'];
                        var primer_nombre = json['primer_nombre'];
                        var segundo_nombre = json['segundo_nombre'];
                        var primer_apellido = json['primer_apellido'];
                        var segundo_apellido = json['segundo_apellido'];
                        var email = json['email'];
                        var telefono = json['telefono'];
                        var rol_id = json['rol_id'];
                        var username = json['username'];
                        var password = json['password'];
                        var estado = json['estado'];

                        $('#usuario_id').val(usuario_id);
                        $('#tipo_persona_id').val(tipo_persona_id);
                        $('#numero_identificacion').val(numero_identificacion);
                        $('#primer_nombre').val(primer_nombre);
                        $('#segundo_nombre').val(segundo_nombre);
                        $('#primer_apellido').val(primer_apellido);
                        $('#segundo_apellido').val(segundo_apellido);
                        $('#email').val(email);
                        $('#telefono').val(telefono);
                        $('#username').val(username);
                        $('#password').val(password);
                        $('#rol_id').val(rol_id);
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

        var numero_identificacion = $('#numero_identificacion').val();
        var primer_nombre = $('#primer_nombre').val();
        var primer_apellido = $('#primer_apellido').val();
        var email = $('#email').val();
        var telefono = $('#telefono').val();
        var username = $('#username').val();
        var password = $('#password').val();

        var validaRequeridos = numero_identificacion != '' && primer_nombre != '' && primer_apellido != '' &&
            email != '' && telefono != '' && username != '' && password != '';

        if (validaRequeridos) {

            var datos = "FUNCION=save&" + $('#form').serialize();

            $.ajax({
                url: 'process/usuario.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {

                    var json = $.parseJSON(resp);
                    if (json == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Usuario Guardado Exitosamente!',
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
                            'Ya existe un usuario con el mismo numero de identificación!',
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
    $('#actualizar').click(function() {

        var usuario_id = $('#usuario_id').val();
        var numero_identificacion = $('#numero_identificacion').val();
        var primer_nombre = $('#primer_nombre').val();
        var primer_apellido = $('#primer_apellido').val();
        var email = $('#email').val();
        var telefono = $('#telefono').val();
        var username = $('#username').val();
        var password = $('#password').val();

        var validaRequeridos = numero_identificacion != '' && primer_nombre != '' && primer_apellido != '' &&
            email != '' && telefono != '' && username != '' && password != '' && usuario_id != '';

        if (validaRequeridos) {

            var datos = "FUNCION=update&" + $('#form').serialize();

            $.ajax({
                url: 'process/usuario.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {

                    var json = $.parseJSON(resp);
                    if (json == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Usuario Actualizado Exitosamente!',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $('#form')[0].reset();
                        $('#buscar').val('');
                        $('#usuario_id').val('');

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
                            'Ya existe un Usuario con el mismo numero de identificación!',
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
    $('#eliminar').click(function() {

        var usuario_id = $('#usuario_id').val();

        var validaRequeridos = usuario_id != '';

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
                    var datos = "FUNCION=delete&usuario_id=" + usuario_id;

                    $.ajax({
                        url: 'process/usuario.process.php',
                        type: 'POST',
                        data: datos,
                        dataType: 'json',
                        success: function(resp) {

                            var json = $.parseJSON(resp);
                            if (json == 1) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Usuario Eliminado Exitosamente!',
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


        } else {
            Swal.fire(
                'Atencion',
                'Por favor digite los campos obligatorios!',
                'info'
            )
        }

        return false;
    });

    $('#limpiar').click(function() {

        $('#form')[0].reset();
        $('#buscar').val('');
        $('#usuario_id').val('');

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

    $('#numero_identificacion').blur(function() {

        if ($(this).val() > 0 || $(this).val() != '') {

            var datos = "FUNCION=getTercero&numero_identificacion=" + $(this).val();

            $.ajax({
                url: 'process/usuario.process.php',
                type: 'POST',
                data: datos,
                beforeSend: function() {
                    $("#loader").show();
                },
                success: function(resp) {

                    var json = $.parseJSON(resp);

                    if (json != '' && json != 1) {

                        var tipo_persona_id = json['tipo_persona_id'];
                        var numero_identificacion = json['numero_identificacion'];
                        var primer_nombre = json['primer_nombre'];
                        var segundo_nombre = json['segundo_nombre'];
                        var primer_apellido = json['primer_apellido'];
                        var segundo_apellido = json['segundo_apellido'];
                        var email = json['email'];
                        var telefono = json['telefono'];

                        $('#tipo_persona_id').val(tipo_persona_id);
                        $('#numero_identificacion').val(numero_identificacion);
                        $('#primer_nombre').val(primer_nombre);
                        $('#segundo_nombre').val(segundo_nombre);
                        $('#primer_apellido').val(primer_apellido);
                        $('#segundo_apellido').val(segundo_apellido);
                        $('#email').val(email);
                        $('#telefono').val(telefono);

                    }

                    $("#loader").hide();

                }
            });
        }
    })


});

function verUsuario(usuario_id) {

    window.location.href = "inicio.php?page=crearUsuario&usuario_id=" + usuario_id;

}

function cargarDatos(usuario_id) {

    var datos = "FUNCION=getDate&usuario_id=" + usuario_id;

    $.ajax({
        url: 'process/usuario.process.php',
        type: 'POST',
        data: datos,
        success: function(resp) {


            var json = $.parseJSON(resp);

            if (json != '') {


                var usuario_id = json['usuario_id'];
                var tipo_persona_id = json['tipo_persona_id'];
                var numero_identificacion = json['numero_identificacion'];
                var primer_nombre = json['primer_nombre'];
                var segundo_nombre = json['segundo_nombre'];
                var primer_apellido = json['primer_apellido'];
                var segundo_apellido = json['segundo_apellido'];
                var email = json['email'];
                var telefono = json['telefono'];
                var rol_id = json['rol_id'];
                var username = json['username'];
                var password = json['password'];
                var estado = json['estado'];


                $('#usuario_id').val(usuario_id);
                $('#tipo_persona_id').val(tipo_persona_id);
                $('#numero_identificacion').val(numero_identificacion);
                $('#primer_nombre').val(primer_nombre);
                $('#segundo_nombre').val(segundo_nombre);
                $('#primer_apellido').val(primer_apellido);
                $('#segundo_apellido').val(segundo_apellido);
                $('#email').val(email);
                $('#telefono').val(telefono);
                $('#username').val(username);
                $('#password').val(password);
                $('#rol_id').val(rol_id);
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