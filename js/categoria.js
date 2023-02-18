$(document).ready(function () {

    //funcion guardar
    $('#guardar').click(function () {

        var categoria_id = $('#categoria_id').val();
        var nombre = $('#nombre').val();

        if(!categoria_id>0){
            //funcion guardar
            var validaRequeridos = nombre != '';

            if (validaRequeridos) {

                var datos = "FUNCION=save&nombre=" + nombre;

                $.ajax({
                    url: 'process/categoria.process.php',
                    type: 'POST',
                    data: datos,
                    dataType: 'json',
                    success: function (resp) {

                        var json = $.parseJSON(resp);
                        if (json == 1) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Categoria Guardada Exitosamente!',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $('#form')[0].reset();
                            setTimeout(function () { location.reload(); }, 2000);


                        } else if (json == 2) {
                            Swal.fire(
                                'Atencion',
                                'Ya existe un categoria con el mismo nombre!',
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
        }else{
            //funcion actualizar
            var validaRequeridos = categoria_id != '' && nombre != '';

            if (validaRequeridos) {

                var datos = "FUNCION=update&categoria_id=" + categoria_id + "&nombre=" + nombre;

                $.ajax({
                    url: 'process/categoria.process.php',
                    type: 'POST',
                    data: datos,
                    dataType: 'json',
                    success: function (resp) {

                        var json = $.parseJSON(resp);
                        if (json == 1) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Categoria Actualizada Exitosamente!',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $('#form')[0].reset();
                            setTimeout(function () { location.reload(); }, 2000);


                        } else if (json == 2) {
                            Swal.fire(
                                'Atencion',
                                'Ya existe un categoria con el mismo nombre!',
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
        }

        

    });

    $("#table_categoria").on("click", ".btn-success", function () {
        
        var categoria_id = $(this).parents("tr").find("#categoria_id").val();
        var nombre = $(this).parents("tr").find("#nombre_categoria").val();
        
        $("#categoria_id").val(categoria_id);
        $("#nombre").val(nombre);
    });

    //funcion eliminar
    $("#table_categoria").on("click", ".btn-danger", function () {

        var categoria_id = $(this).parents("tr").find("#categoria_id").val();

        var validaRequeridos = categoria_id != '';

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
                    var datos = "FUNCION=delete&categoria_id=" + categoria_id;

                    $.ajax({
                        url: 'process/categoria.process.php',
                        type: 'POST',
                        data: datos,
                        dataType: 'json',
                        success: function (resp) {

                            var json = $.parseJSON(resp);
                            if (json == 1) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Categoria Eliminada Exitosamente!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                $('#form')[0].reset();
                                setTimeout(function () { location.reload(); }, 1500);
                               

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

});