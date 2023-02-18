$(document).ready(function() {


    /* var table = $('#table_reporte').DataTable({
        responsive: true,
        dom: "Bfrtip",
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    }); */

    $('#fecha_desde').datetimepicker();
    $('#fecha_hasta').datetimepicker();

    //funcion generar
    $('#generar').click(function() {

        var fecha_desde = $('#fecha_desde').val();
        var fecha_hasta = $('#fecha_hasta').val();
        var placa = $('#placa').val();
        var estado = $('#estado').val();

        const formatterPeso = new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0
        })

        //funcion guardar
        var validaRequeridos = fecha_desde != '' && fecha_hasta != '' && estado != 'null';

        if (validaRequeridos) {

            var datos = "FUNCION=generar&fecha_desde=" + fecha_desde + "&fecha_hasta=" + fecha_hasta + "&placa=" + placa + "&estado=" + estado;

            $.ajax({
                url: 'process/reporteParqueadero.process.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(resp) {

                    var json = resp;
                    if (json != '' && json != 1) {

                        var parqueadero = json[0]['parqueadero'];
                        var total = json[0]['total'];
                        var valor_total = total['valor_total'];

                        if (valor_total == '' || valor_total == null) {
                            valor_total = 0;
                        }

                        $("#total").val(formatterPeso.format(valor_total));


                        if (parqueadero != null) {


                            var tableBody = $('#table_reporte').find("tbody");
                            tableBody.find("tr").remove();

                            for (var i = 0; i < json.length; i++) {

                                var parqueadero = json[i]['parqueadero'];

                                var codigo_ticket = parqueadero['codigo_ticket'];
                                var placa = parqueadero['placa'];
                                var tipo_vehiculo = parqueadero['tipo_vehiculo'];
                                var fecha_hora_ingreso = parqueadero['fecha_hora_ingreso'];
                                var fecha_hora_salida = parqueadero['fecha_hora_salida'];
                                var valor_servicio = parqueadero['valor_servicio'];
                                var estado = parqueadero['estado'];

                                if (fecha_hora_salida == 'null' || fecha_hora_salida == null) {
                                    fecha_hora_salida = 'N/A';
                                }

                                if (valor_servicio == 'null' || valor_servicio == null) {
                                    valor_servicio = 0;
                                }

                                var htmlTags = '<tr>' +
                                    '<td>' + codigo_ticket + '</td>' +
                                    '<td>' + placa + '</td>' +
                                    '<td>' + tipo_vehiculo + '</td>' +
                                    '<td>' + fecha_hora_ingreso + '</td>' +
                                    '<td>' + fecha_hora_salida + '</td>' +
                                    '<td>' + valor_servicio + '</td>' +
                                    '<td>' + estado + '</td>' +
                                    '</tr>';
                                $('#table_reporte tbody').append(htmlTags);

                            }
                        }
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'info',
                            title: 'No se encuentran registros con esta busqueda!',
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
            return false;
        }
    });

    $('#limpiar').click(function() {

        $('#form')[0].reset();
        $('#table_reporte').find("tbody").find("tr").remove();
        return false;
    });

});

function ingresarVehiculo() {

    window.location.href = "inicio.php?page=ingresarVehiculo";

}

function reporte() {

    window.location.href = "inicio.php?page=listaVehiculos";

}


function salidaVehiculo() {

    window.location.href = "inicio.php?page=salidaVehiculo";

}

function exportTableToExcel(tableID, filename = '') {
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

    // Specify file name
    filename = filename ? filename + '.xls' : 'excel_data.xls';

    // Create download link element
    downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);

    if (navigator.msSaveOrOpenBlob) {
        var blob = new Blob(['ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob(blob, filename);
        return false;
    } else {
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

        // Setting the file name
        downloadLink.download = filename;

        //triggering the function
        downloadLink.click();
        return false;
    }
}