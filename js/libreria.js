/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function enviarFormulario(id_formulario, ejecutar) {

//alert("el id es "+id_formulario);
    var url = $("#" + id_formulario).attr("action"); // El script a dónde se realizará la petición.
    var type = $("#" + id_formulario).attr("method");
    var formData = new FormData(document.getElementById(id_formulario));
    $.ajax({
        type: type,
        url: url,
//        dataType:"html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data)
        {

            $(data).find('respuesta').each(function () {
                var $respuesta = $(this);
                var resultado = $respuesta.find('resultado').text();
                var mensaje = $respuesta.find('mensaje').text();
                if (resultado === 'ok') {

                    $('#alertas').html(mensajeExitoConFormato(mensaje));
                    eval(ejecutar);
                } else {
                    $('#alertas').html(errorConFormato(mensaje));

                }

            });
        }
    });
    return false; // Evitar ejecutar el submit del formulario.   
}

function abrirPagina(pagina, contenedor, parametros) {

    $.ajax({
        type: 'post',
        url: pagina,
        data: parametros,
        success: function (data)
        {
            $('#' + contenedor).html(data);
        }
    });
}



        


