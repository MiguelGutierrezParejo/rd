$(function(){

    let $cambio = false
    
    function cambiar(){
         if ($cambio ? $cambio = false : $cambio = true );
        
    }

    if ($('#bajas').text().trim() != 'Mostrar Todo')
            $(".ocultar").toggle();


    $('#bajas').on('click', function(){

        if ($('#bajas').text().trim() == 'Mostrar Todo')
            this.href = "/inventario/public/equipos";

        else if ($('#bajas').text().trim() == 'Mostrar solo Altas')
            this.href = "/inventario/public/";
    });

    $("#IdTipo").change(function(){
        $("#form").submit();
    });
    
});




