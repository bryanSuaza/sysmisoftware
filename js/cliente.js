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

    var cliente_id = $("#cliente_id").val();
    if (cliente_id > 0) {
        cargarDatos(cliente_id);
    }


    $('#table_clientes').DataTable({
    	responsive: true
    });


    //busqueda inteligente
    $('#buscar').autocomplete({
        source: function (data, cb) {

            var datos = "FUNCION=serch&busqueda=" + data.term;

            $.ajax({
                url: 'process/cliente.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function (resp) {
                    var d = $.map(resp, function (cliente_id) {
                        return {
                            label: cliente_id,
                            value: cliente_id
                        }
                    });

                    cb(d);
                }
            });
        },

        select: function (event, ui) {

            $('#form')[0].reset();

            var cliente = ui.item.value;
            var arrayCliente = cliente.split(' ');
            var cliente_id = arrayCliente[0];
            
            var datos = "FUNCION=getDate&cliente_id=" + cliente_id;

            $.ajax({
                url: 'process/cliente.process.php',
                type: 'POST',
                data: datos,
                success: function (resp) {

                    var json = $.parseJSON(resp);

                    if (json != '') {

                        var cliente_id = json['cliente_id'];
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
                        var banco = json['banco'];
                        var numero_cuenta = json['numero_cuenta'];
                        var estado = json['estado'];

                        
                        $('#cliente_id').val(cliente_id);
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
                        $('#banco').val(banco);
                        $('#numero_cuenta').val(numero_cuenta);
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
    $('#guardar').click(function () {

        var tipo_persona_id = $('#tipo_persona_id').val();
        var numero_identificacion = $('#numero_identificacion').val();
        var primer_nombre = $('#primer_nombre').val();
        var primer_apellido = $('#primer_apellido').val();
        var razon_social = $('#razon_social').val();
        var email = $('#email').val();
        var telefono = $('#telefono').val();

        if(tipo_persona_id == 1){
            var validaRequeridos = numero_identificacion != '' && primer_nombre != '' && primer_apellido != ''
            && email != '' && telefono != '';
        }else{
            var validaRequeridos = numero_identificacion != '' && razon_social != '' && email != '' && telefono != '';
        }


        if (validaRequeridos) {

            var datos = "FUNCION=save&" + $('#form').serialize();

            $.ajax({
                url: 'process/cliente.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function (resp) {

                    var json = $.parseJSON(resp);
                    if (json == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Cliente Guardado Exitosamente!',
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
                            'Ya existe un cliente con el mismo numero de identificación!',
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

        var tipo_persona_id = $('#tipo_persona_id').val();
        var cliente_id = $('#cliente_id').val();
        var numero_identificacion = $('#numero_identificacion').val();
        var primer_nombre = $('#primer_nombre').val();
        var primer_apellido = $('#primer_apellido').val();
        var razon_social = $('#razon_social').val();
        var email = $('#email').val();
        var telefono = $('#telefono').val();

        if (tipo_persona_id == 1) {
            var validaRequeridos = numero_identificacion != '' && primer_nombre != '' && primer_apellido != ''
                && email != '' && telefono != '' && cliente_id != '';
        } else {
            var validaRequeridos = numero_identificacion != '' && razon_social != '' && email != '' && telefono != '' && cliente_id != '';
        }

        if (validaRequeridos) {

            var datos = "FUNCION=update&" + $('#form').serialize();

            $.ajax({
                url: 'process/cliente.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function (resp) {

                    var json = $.parseJSON(resp);
                    if (json == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Cliente Actualizado Exitosamente!',
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
                            'Ya existe un cliente con el mismo numero de identificación!',
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

        var cliente_id = $('#cliente_id').val();

        var validaRequeridos = cliente_id != '';

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
                    var datos = "FUNCION=delete&cliente_id=" + cliente_id;

                    $.ajax({
                        url: 'process/cliente.process.php',
                        type: 'POST',
                        data: datos,
                        dataType: 'json',
                        success: function (resp) {

                            var json = $.parseJSON(resp);
                            if (json == 1) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Cliente Eliminado Exitosamente!',
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


    $('#numero_identificacion').blur(function () {

        if($(this).val()>0 || $(this).val()!= ''){

        var datos = "FUNCION=getTercero&numero_identificacion=" + $(this).val();

        $.ajax({
            url: 'process/cliente.process.php',
            type: 'POST',
            data: datos,
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (resp) {
                
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

        var tipo_persona_id = $("#tipo_persona_id").val();
        if(tipo_persona_id == 2){

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

    $("#tipo_persona_id").change(function(){
        var tipo_persona_id = $(this).val();
        if (tipo_persona_id == 1) {
            document.getElementById("razon_social").disabled =true;
            document.getElementById("primer_nombre").disabled = false;
            document.getElementById("segundo_nombre").disabled = false;
            document.getElementById("primer_apellido").disabled = false;
            document.getElementById("segundo_apellido").disabled = false;
        }else if(tipo_persona_id == 2){
            document.getElementById("razon_social").disabled = false;
            document.getElementById("primer_nombre").disabled = true;
            document.getElementById("segundo_nombre").disabled = true;
            document.getElementById("primer_apellido").disabled = true;
            document.getElementById("segundo_apellido").disabled = true;
        }
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

function verCliente(cliente_id) {

    window.location.href = "inicio.php?page=crearCliente&cliente_id=" + cliente_id;

}

function cargarDatos(cliente_id) {
    
    var datos = "FUNCION=getDate&cliente_id=" + cliente_id;

    $.ajax({
        url: 'process/cliente.process.php',
        type: 'POST',
        data: datos,
        success: function (resp) {


            var json = $.parseJSON(resp);

            if (json != '') {

                var cliente_id = json['cliente_id'];
                var tipo_persona_id = json['tipo_persona_id'];
                var numero_identificacion = json['numero_identificacion'];
                var digito_verificacion = json['digito_verificacion'];
                var primer_nombre = json['primer_nombre'];
                var segundo_nombre = json['segundo_nombre'];
                var primer_apellido = json['primer_apellido'];
                var segundo_apellido = json['segundo_apellido'];
                var email = json['email'];
                var telefono = json['telefono'];
                var banco = json['banco'];
                var cuenta = json['cuenta'];
                var estado = json['estado'];

                $('#cliente_id').val(cliente_id);
                $('#tipo_persona_id').val(tipo_persona_id);
                $('#numero_identificacion').val(numero_identificacion);
                $('#digito_verificacion').val(digito_verificacion);
                $('#primer_nombre').val(primer_nombre);
                $('#segundo_nombre').val(segundo_nombre);
                $('#primer_apellido').val(primer_apellido);
                $('#segundo_apellido').val(segundo_apellido);
                $('#email').val(email);
                $('#telefono').val(telefono);
                $('#banco').val(banco);
                $('#cuenta').val(cuenta);
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