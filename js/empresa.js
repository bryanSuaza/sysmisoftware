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
                url: 'process/empresa.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {
                    var d = $.map(resp, function(empresa_id) {
                        return {
                            label: empresa_id,
                            value: empresa_id
                        }
                    });

                    cb(d);
                }
            });
        },

        select: function(event, ui) {

            $('#form')[0].reset();

            var empresa = ui.item.value;
            var arrayEmpresa = empresa.split(' ');
            var empresa_id = arrayEmpresa[0];

            var datos = "FUNCION=getDate&empresa_id=" + empresa_id;

            $.ajax({
                url: 'process/empresa.process.php',
                type: 'POST',
                data: datos,
                success: function(resp) {

                    var json = $.parseJSON(resp);

                    if (json != '') {

                        var empresa_id = json['empresa_id'];
                        var tipo_persona_id = json['tipo_persona_id'];
                        var numero_identificacion = json['numero_identificacion'];
                        var digito_verificacion = json['digito_verificacion'];
                        var primer_nombre = json['primer_nombre'];
                        var segundo_nombre = json['segundo_nombre'];
                        var primer_apellido = json['primer_apellido'];
                        var segundo_apellido = json['segundo_apellido'];
                        var razon_social = json['razon_social'];
                        var email = json['email'];
                        var telefono = json['telefono'];
                        var representante = json['representante'];
                        var ubicacion = json['ubicacion'];
                        var direccion = json['direccion'];
                        var pagina = json['pagina'];
                        var registro_mercantil = json['registro_mercantil'];
                        var camara_comercio = json['camara_comercio'];
                        var estado = json['estado'];

                        $('#empresa_id').val(empresa_id);
                        $('#tipo_persona_id').val(tipo_persona_id);
                        $('#numero_identificacion').val(numero_identificacion);
                        $('#digito_verificacion').val(digito_verificacion);
                        $('#primer_nombre').val(primer_nombre);
                        $('#segundo_nombre').val(segundo_nombre);
                        $('#primer_apellido').val(primer_apellido);
                        $('#segundo_apellido').val(segundo_apellido);
                        $('#razon_social').val(razon_social);
                        $('#email').val(email);
                        $('#telefono').val(telefono);
                        $('#representante').val(representante);
                        $('#ubicacion').val(ubicacion);
                        $('#direccion').val(direccion);
                        $('#pagina').val(pagina);
                        $('#registro_mercantil').val(registro_mercantil);
                        $('#camara_comercio').val(camara_comercio);
                        $('#estado').val(estado);

                        if (tipo_persona_id == 1) {
                            document.getElementById("razon_social").disabled = true;
                            document.getElementById("primer_nombre").disabled = false;
                            document.getElementById("segundo_nombre").disabled = false;
                            document.getElementById("primer_apellido").disabled = false;
                            document.getElementById("segundo_apellido").disabled = false;
                        } else if (tipo_persona_id == 2) {
                            document.getElementById("razon_social").disabled = false;
                            document.getElementById("primer_nombre").disabled = true;
                            document.getElementById("segundo_nombre").disabled = true;
                            document.getElementById("primer_apellido").disabled = true;
                            document.getElementById("segundo_apellido").disabled = true;
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
    $('#guardar').click(function() {

        var tipo_persona_id = $('#tipo_persona_id').val();
        var numero_identificacion = $('#numero_identificacion').val();
        var primer_nombre = $('#primer_nombre').val();
        var primer_apellido = $('#primer_apellido').val();
        var razon_social = $('#razon_social').val();
        var representante = $('#representante').val();
        var ubicacion = $('#ubicacion').val();
        var direccion = $('#direccion').val();
        var email = $('#email').val();
        var telefono = $('#telefono').val();
        var logo_empresa = $('#logo_empresa').val();

        var data = new FormData($('#form')[0]);

        if (tipo_persona_id == 1) {
            var validaRequeridos = numero_identificacion != '' && primer_nombre != '' && primer_apellido != '' &&
                email != '' && telefono != '' && ubicacion != '' && direccion != '';
        } else {
            var validaRequeridos = numero_identificacion != '' && razon_social != '' && email != '' && telefono != '' && ubicacion != '' && direccion != '';
        }

        if (validaRequeridos) {

            data.append('FUNCION', 'save');

            $.ajax({
                url: 'process/empresa.process.php',
                type: 'POST',
                data: data,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {

                    var json = $.parseJSON(resp);
                    if (json == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Empresa Guardada Exitosamente!',
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
                            'Ya existe una empresa con el mismo numero de identificación o nit!',
                            'warning'
                        )
                    } else if (json == 3) {
                        Swal.fire(
                            'Atencion',
                            'El tipo de imagen debe tener formato JPG o PNG!',
                            'info'
                        )
                    } else if (json == 4) {
                        Swal.fire(
                            'Atencion',
                            'El tamaño de la imagen es demasiado grande!',
                            'info'
                        )
                    } else if (json == 5) {
                        Swal.fire(
                            'Atencion',
                            'El tamaño del archivo es demasiado grande!',
                            'info'
                        )
                    } else if (json == 6) {
                        Swal.fire(
                            'Atencion',
                            'El tipo de archivo debe tener formato PDF!',
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

        var tipo_persona_id = $('#tipo_persona_id').val();
        var empresa_id = $('#empresa_id').val();
        var numero_identificacion = $('#numero_identificacion').val();
        var primer_nombre = $('#primer_nombre').val();
        var primer_apellido = $('#primer_apellido').val();
        var razon_social = $('#razon_social').val();
        var email = $('#email').val();
        var ubicacion = $('#ubicacion').val();
        var representante = $('#representante').val();
        var direccion = $('#direccion').val();
        var telefono = $('#telefono').val();
        var logo_empresa = $('#logo_empresa').val();

        var data = new FormData($('#form')[0]);

        if (tipo_persona_id == 1) {
            var validaRequeridos = numero_identificacion != '' && primer_nombre != '' && primer_apellido != '' &&
                email != '' && telefono != '' && empresa_id != '' && ubicacion != '' && direccion != '';
        } else {
            var validaRequeridos = numero_identificacion != '' && razon_social != '' && email != '' && telefono != '' && empresa_id != '' && ubicacion != '' && direccion != '';
        }

        if (validaRequeridos) {

            data.append('FUNCION', 'update');

            $.ajax({
                url: 'process/empresa.process.php',
                type: 'POST',
                data: data,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {

                    var json = $.parseJSON(resp);
                    if (json == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Empresa Actualizada Exitosamente!',
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
                            'Ya existe una empresa con el mismo numero de identificación o nit!',
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
                    } else if (json == 5) {
                        Swal.fire(
                            'Atencion',
                            'El tamaño del archivo es demasiado grande!',
                            'info'
                        )
                    } else if (json == 6) {
                        Swal.fire(
                            'Atencion',
                            'El tipo de archivo debe tener formato PDF!',
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

        var empresa_id = $('#empresa_id').val();

        var validaRequeridos = empresa_id != '';

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
                    var datos = "FUNCION=delete&empresa_id=" + empresa_id;

                    $.ajax({
                        url: 'process/empresa.process.php',
                        type: 'POST',
                        data: datos,
                        dataType: 'json',
                        success: function(resp) {

                            var json = $.parseJSON(resp);
                            if (json == 1) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Empresa Eliminada Exitosamente!',
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

        var tipo_persona_id = $("#tipo_persona_id").val();
        if (tipo_persona_id == 1) {
            document.getElementById("razon_social").disabled = true;
            document.getElementById("primer_nombre").disabled = false;
            document.getElementById("segundo_nombre").disabled = false;
            document.getElementById("primer_apellido").disabled = false;
            document.getElementById("segundo_apellido").disabled = false;
        } else if (tipo_persona_id == 2) {
            document.getElementById("razon_social").disabled = false;
            document.getElementById("primer_nombre").disabled = true;
            document.getElementById("segundo_nombre").disabled = true;
            document.getElementById("primer_apellido").disabled = true;
            document.getElementById("segundo_apellido").disabled = true;
        }

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
                url: 'process/empresa.process.php',
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
                        var razon_social = json['razon_social'];
                        var email = json['email'];
                        var telefono = json['telefono'];

                        $('#tipo_persona_id').val(tipo_persona_id);
                        $('#numero_identificacion').val(numero_identificacion);
                        $('#primer_nombre').val(primer_nombre);
                        $('#segundo_nombre').val(segundo_nombre);
                        $('#primer_apellido').val(primer_apellido);
                        $('#segundo_apellido').val(segundo_apellido);
                        $('#razon_social').val(razon_social);
                        $('#email').val(email);
                        $('#telefono').val(telefono);

                    }

                    $("#loader").hide();

                }
            });

            var tipo_persona_id = $("#tipo_persona_id").val();
            if (tipo_persona_id == 2) {

                // Verificar que haya un numero
                let nit = document.getElementById("numero_identificacion").value;
                let isNitValid = nit >>> 0 === parseFloat(nit) ? true : false; // Validate a positive integer

                // Si es un número se calcula el Dígito de Verificación
                if (isNitValid) {
                    let inputDigVerificacion = document.getElementById("digito_verificacion");
                    inputDigVerificacion.value = calcularDigitoVerificacion(nit);
                }
            }
        }
    });

    var tipo_persona_id = $("#tipo_persona_id").val();
    if (tipo_persona_id == 1) {
        document.getElementById("razon_social").disabled = true;
    }

    $("#tipo_persona_id").change(function() {
        var tipo_persona_id = $(this).val();
        if (tipo_persona_id == 1) {
            document.getElementById("razon_social").disabled = true;
            document.getElementById("primer_nombre").disabled = false;
            document.getElementById("segundo_nombre").disabled = false;
            document.getElementById("primer_apellido").disabled = false;
            document.getElementById("segundo_apellido").disabled = false;
        } else if (tipo_persona_id == 2) {
            document.getElementById("razon_social").disabled = false;
            document.getElementById("primer_nombre").disabled = true;
            document.getElementById("segundo_nombre").disabled = true;
            document.getElementById("primer_apellido").disabled = true;
            document.getElementById("segundo_apellido").disabled = true;
        }
    });

    $('#archivo_doc_registro').click(function() {

        var empresa_id = $("#empresa_id").val();
        if (empresa_id > 0) {

            var datos = "FUNCION=getArchivo&empresa_id=" + empresa_id;

            $.ajax({
                url: 'process/empresa.process.php',
                type: 'POST',
                data: datos,
                success: function(resp) {

                    var json = $.parseJSON(resp);

                    if (json != '' && json != 1) {

                        var doc_registro = json['doc_registro'];

                        if (doc_registro != '') {
                            window.open('process/docs_uploads/' + doc_registro, '_blank');
                        } else {
                            Swal.fire(
                                'Atencion',
                                'Aun no se ha guardado ningun archivo!',
                                'info'
                            )
                        }

                    }

                }
            });

        } else {
            Swal.fire(
                'Atencion',
                'Aun no se ha guardado ningun archivo!',
                'info'
            )
        }
        return false;
    });

    $('#archivo_logo').click(function() {

        var empresa_id = $("#empresa_id").val();
        if (empresa_id > 0) {
            var datos = "FUNCION=getArchivo&empresa_id=" + empresa_id;

            $.ajax({
                url: 'process/empresa.process.php',
                type: 'POST',
                data: datos,
                success: function(resp) {

                    var json = $.parseJSON(resp);

                    if (json != '' && json != 1) {

                        var logo_empresa = json['logo_empresa'];

                        if (logo_empresa != '') {
                            window.open('process/img_uploads/' + logo_empresa, '_blank');
                        } else {
                            Swal.fire(
                                'Atencion',
                                'Aun no se ha guardado ningun archivo!',
                                'info'
                            )
                        }

                    }

                }
            });


        } else {
            Swal.fire(
                'Atencion',
                'Aun no se ha guardado ningun archivo!',
                'info'
            )
        }
        return false;
    });

    $('#archivo_foto').click(function() {

        var empresa_id = $("#empresa_id").val();
        if (empresa_id > 0) {
            var datos = "FUNCION=getArchivo&empresa_id=" + empresa_id;

            $.ajax({
                url: 'process/empresa.process.php',
                type: 'POST',
                data: datos,
                success: function(resp) {

                    var json = $.parseJSON(resp);

                    if (json != '' && json != 1) {

                        var foto_empresa = json['foto_empresa'];

                        if (foto_empresa != '') {
                            window.open('process/img_uploads/' + foto_empresa, '_blank');
                        } else {
                            Swal.fire(
                                'Atencion',
                                'Aun no se ha guardado ningun archivo!',
                                'info'
                            )
                        }

                    }

                }
            });


        } else {
            Swal.fire(
                'Atencion',
                'Aun no se ha guardado ningun archivo!',
                'info'
            )
        }
        return false;
    });


    $('#archivo_doc_camara').click(function() {

        var empresa_id = $("#empresa_id").val();
        if (empresa_id > 0) {
            var datos = "FUNCION=getArchivo&empresa_id=" + empresa_id;

            $.ajax({
                url: 'process/empresa.process.php',
                type: 'POST',
                data: datos,
                success: function(resp) {

                    var json = $.parseJSON(resp);

                    if (json != '' && json != 1) {

                        var doc_camara = json['doc_camara'];

                        if (doc_camara != '') {
                            window.open('process/docs_uploads/' + doc_camara, '_blank');
                        } else {
                            Swal.fire(
                                'Atencion',
                                'Aun no se ha guardado ningun archivo!',
                                'info'
                            )
                        }

                    }

                }
            });


        } else {
            Swal.fire(
                'Atencion',
                'Aun no se ha guardado ningun archivo!',
                'info'
            )
        }
        return false;
    });


});


//calculo-digito-de-verificacion-dian
function calcularDigitoVerificacion(myNit) {
    var vpri,
        x,
        y,
        z;

    // Se limpia el Nit
    myNit = myNit.replace(/\s/g, ""); // Espacios
    myNit = myNit.replace(/,/g, ""); // Comas
    myNit = myNit.replace(/\./g, ""); // Puntos
    myNit = myNit.replace(/-/g, ""); // Guiones

    // Se valida el nit
    if (isNaN(myNit)) {
        console.log("El nit/cédula '" + myNit + "' no es válido(a).");
        return "";
    };

    // Procedimiento
    vpri = new Array(16);
    z = myNit.length;

    vpri[1] = 3;
    vpri[2] = 7;
    vpri[3] = 13;
    vpri[4] = 17;
    vpri[5] = 19;
    vpri[6] = 23;
    vpri[7] = 29;
    vpri[8] = 37;
    vpri[9] = 41;
    vpri[10] = 43;
    vpri[11] = 47;
    vpri[12] = 53;
    vpri[13] = 59;
    vpri[14] = 67;
    vpri[15] = 71;

    x = 0;
    y = 0;
    for (var i = 0; i < z; i++) {
        y = (myNit.substr(i, 1));
        // console.log ( y + "x" + vpri[z-i] + ":" ) ;

        x += (y * vpri[z - i]);
        // console.log ( x ) ;    
    }

    y = x % 11;
    // console.log ( y ) ;

    return (y > 1) ? 11 - y : y;
}