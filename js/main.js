$(document).ready(function(){

    //Aparece el menu de mesa
    $('.mesa').on('click', function(){
        $(this).next().toggleClass('d-none');
    })

    //Cambio en el menu de platos 
    $('.categorias span').on('click', function(){
        $('.selected').removeClass('selected');
        $(this).addClass('selected');
        let target = $(this).data('target');
        let arr = document.getElementsByClassName('tr');
        if(target!="all"){
            for(i=0;i<arr.length;i++){
                if($(arr[i]).data('op')!=target){
                    $(arr[i]).addClass('d-none');
                }
                else{
                    $(arr[i]).removeClass('d-none')
                }
            }
        }else{
            if($('.tr').hasClass('d-none')){
                $('.tr').removeClass('d-none');
            }
        }
        
    })

    //validacion de campos de entrada. Todo input con clase esNumero se validara solo si son números.
    $('.esNumero').on('keyup', function(){
        let num = $(this).val();
        if(!esNumero(num)){
            Swal.fire(
                '¡Error!',
                'Debes introducir un número.'
            )
        }  
    })
    
    //validación formulario de nueva factura
    $('#generarFactura').on('click', validarNuevaFactura);

    //validación formulario de nuevo plato
    $('#generarPlato').on('click', validarNuevoPlato);

    //validación formulario de nueva reserva
    $('#generarReserva').on('click', validarNuevaReserva);

    //validación formulario de cambio de datos de restaurante
    $('#cambiarDatos').on('click', validarCambioDatos);

    //validación formulario de borrar con codigo de confirmacion
    $('.borrarFactura').on('click', validarConfirmacion);
    $('.borrarPlato').on('click', validarConfirmacion);
});


function esNumero(num){
    if(!isNaN(num)){
        return true;
    }else{
        return false;
    }
}

function validarNuevaFactura(){
    if($('#empresa').val()==null || $('#empresa').val()==""){
        Swal.fire(
            '¡Error!',
            'El campo "Nombre de empresa" es obligatorio.'
        )
        return false;
    }
    if($('#nif').val()==null || $('#nif').val()==""){
        Swal.fire(
            '¡Error!',
            'El campo "NIF" es obligatorio.'
        )
        return false;
    }
    if($('#direccion').val()==null || $('#direccion').val()==""){
        Swal.fire(
            '¡Error!',
            'El campo "Dirección" es obligatorio.'
        )
        return false;
    }
    if(!esNumero($('#cp').val())){
        Swal.fire(
            '¡Error!',
            'El campo "Código postal" debe ser un número.'
        )
        return false;
    }
    if($('#ciudad').val()==null || $('#ciudad').val()==""){
        Swal.fire(
            '¡Error!',
            'El campo "Ciudad" es obligatorio.'
        )
        return false;
    }
    if($('#provincia').val()==null || $('#provincia').val()==""){
        Swal.fire(
            '¡Error!',
            'El campo "Provincia" es obligatorio.'
        )
        return false;
    }
    if($('#telefono').val()==null || $('#telefono').val()=="" || !esNumero($('#telefono').val())){
        Swal.fire(
            '¡Error!',
            'El campo "Teléfono" es obligatorio.'
        )
        return false;
    }  
    if($('#contacto').val()==null || $('#contacto').val()==""){
        Swal.fire(
            '¡Error!',
            'El campo "Contacto" es obligatorio.'
        )
        return false;
    }
    if(!esNumero($('#cp').val()) || $('#cp').val()==null || $('#cp').val()==""){
        Swal.fire(
            '¡Error!',
            'El campo "Código postal" debe ser un número.'
        )
        return false;
    }
    return true;
    
}

function validarNuevoPlato(){
    if($('#nombre').val()==null || $('#nombre').val()==""){
        Swal.fire(
            '¡Error!',
            'El campo "Nombre del plato" es obligatorio.'
        )
        return false;
    }
    if(!esNumero($('#precio').val()) || $('#precio').val()==null || $('#precio').val()==""){
        Swal.fire(
            '¡Error!',
            'El campo "Precio" es obligatorio.'
        )
        return false;
    }
    return true;
    
}

function validarNuevaReserva(){
    if($('#nombre').val()==null || $('#nombre').val()==""){
        Swal.fire(
            '¡Error!',
            'El campo "Nombre de la reserva" es obligatorio.'
        )
        return false;
    }
    if(!esNumero($('#comensales').val())){
        Swal.fire(
            '¡Error!',
            'El campo "Comensales" debe ser un número.'
        )
        return false;
    }
    if($('#telefono').val()==null || $('#telefono').val()=="" || !esNumero($('#telefono').val())){
        Swal.fire(
            '¡Error!',
            'El campo "Teléfono de contacto" es obligatorio.'
        )
        return false;
    }  
    return true;
    
}

function validarConfirmacion(){
    if(!esNumero($('#num_conf').val())){
        Swal.fire(
            '¡Error!',
            'El CSS debe ser un número de 4 cifras.'
        )
        return false;
    }
    return true;
}

function validarCambioDatos(){
    if($('#nombre').val()==null || $('#nombre').val()==""){
        Swal.fire(
            '¡Error!',
            'El campo "nombre" es obligatorio.'
        )
        return false;
    }
    if($('#nif').val()==null || $('#nif').val()==""){
        Swal.fire(
            '¡Error!',
            'El campo "NIF" es obligatorio.'
        )
        return false;
    }
    if($('#telefono').val()==null || $('#telefono').val()=="" || !esNumero($('#telefono').val())){
        Swal.fire(
            '¡Error!',
            'El campo "teléfono" es obligatorio.'
        )
        return false;
    }    
    if(!isEmail($('#email').val())){
        Swal.fire(
            '¡Error!',
            'El campo "email" es obligatorio.'
        )
        return false;
    }
    if($('#pass').val()==null || $('#pass').val()==""){
        Swal.fire(
            '¡Error!',
            'El campo "contraseña" es obligatorio.'
        )
        return false;
    }
    if($('#pass2').val()==null || $('#pass2').val()==""){
        Swal.fire(
            '¡Error!',
            'Repita la contraseña anterior.'
        )
        return false;
    }
    if($('#pass').val()!= $('#pass2').val()){
        Swal.fire(
            '¡Error!',
            'Ambas contraseñas deben coincidir.'
        )
        return false;
    }
    if(!esNumero($('#cp').val())){
        Swal.fire(
            '¡Error!',
            'El campo "código postal" debe ser un número.'
        )
        return false;
    }
    if($('#css').val()==null || $('#css').val()=="" || !esNumero($('#css').val())){
        Swal.fire(
            '¡Error!',
            'Debe introducir un código de seguridad secreto válido.'
        )
        return false;
    }
    return true;
    
}