$(document).ready(function () {
    
    if (document.getElementById('guardar')){
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
        source: function (data,cb) {
            
            var datos = "FUNCION=serch&busqueda="+data.term;

            $.ajax({
                url: 'process/rol.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function (resp) {
                   var d = $.map(resp, function (rol_id) {
                       return{
                           label:rol_id,
                           value:rol_id
                       }
                   });

                   cb(d);
                }
            });
        },

        select: function (event,ui) {

            $('#form')[0].reset();

            var rol = ui.item.value;
            var rol_id = rol.substr(0,1);

            var datos = "FUNCION=getDate&rol_id=" + rol_id;

            $.ajax({
                url: 'process/rol.process.php',
                type: 'POST',
                data: datos,
                success: function (resp) {
                  
                    var json = $.parseJSON(resp);
                    
                    if(json != ''){
                        var roles = json[0]['roles'];
                        var permisos = json[0]['permisos'];

                        var rol_id = roles['rol_id'];
                        var rol = roles['rol'];
                        var estado = roles['estado'];

                        if (permisos != null) {
                            for (var i = 0; i < json.length; i++) {
                                
                                var permisos = json[i]['permisos'];
                                var permiso_id = permisos['permiso_id'];

                                $("select[id=permiso_id] option").each(function () {

                                    if (this.value == permiso_id) {
                                        this.selected = true;
                                        return true;
                                    }

                                });
                            }
                        }

                        $('#rol_id').val(rol_id);
                        $('#rol').val(rol);
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

        var rol = $('#rol').val();
        var permiso_id = $('#permiso_id').val();
        var estado = $('#estado').val();

        var validaRequeridos = rol != '' && permiso_id != '' && estado != '';

        if(validaRequeridos){

            var datos = "FUNCION=save&permiso_id="+permiso_id+"&"+$('#form').serialize();

            $.ajax({
                url:'process/rol.process.php',
                type:'POST',
                data: datos,
                dataType:'json',
                success: function (resp) {

                   var json = $.parseJSON(resp);
                   if(json == 1){
                       Swal.fire({
                           position: 'top-end',
                           icon: 'success',
                           title: 'Rol Guardado Exitosamente!',
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

                   }else if(json == 2){
                       Swal.fire(
                           'Atencion',
                           'Ya existe un rol con el mismo nombre!',
                           'warning'
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
            return false;

        }else{
            Swal.fire(
                'Atencion',
                'Por favor digite los campos obligatorios!',
                'info'
            )
        }

    });

    //funcion actualizar
    $('#actualizar').click(function () {

        var rol_id = $('#rol_id').val();
        var rol = $('#rol').val();
        var permiso_id = $('#permiso_id').val();
        var estado = $('#estado').val();

        var validaRequeridos = rol != '' && permiso_id != '' && estado != '' && rol_id != '';

        if (validaRequeridos) {

            var datos = "FUNCION=update&permiso_id=" + permiso_id + "&" + $('#form').serialize();

            $.ajax({
                url: 'process/rol.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function (resp) {

                    var json = $.parseJSON(resp);
                    if (json == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Rol Actualizado Exitosamente!',
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
                            'Ya existe un rol con el mismo nombre!',
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

        var rol_id = $('#rol_id').val();

        var validaRequeridos = rol_id != '';

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
                    var datos = "FUNCION=delete&rol_id=" + rol_id;

                    $.ajax({
                        url: 'process/rol.process.php',
                        type: 'POST',
                        data: datos,
                        dataType: 'json',
                        success: function (resp) {

                            var json = $.parseJSON(resp);
                            if (json == 1) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Rol Eliminado Exitosamente!',
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