$(document).ready(function(){
    
    $('.ojo i').on('mousedown', function(){
        
            verPass();
            $(this).addClass('icofont-eye');
            $(this).removeClass('icofont-eye-blocked');
        
    });

    $('.ojo i').on('mouseup', function(){
        
        noVerPass();
        $(this).addClass('icofont-eye-blocked');
        $(this).removeClass('icofont-eye');
        
    });

    $('.generarPass').on('click', genPass);
    
    //VALIDACION DE FORMULARIOS
    // Primero valido los campos numéricos, y a partir de ahi valido el resto de campos al enviar.
    $('#telefono').on('keyup', function(){
        let num = $(this).val();
        if(!esNumero(num)){
            Swal.fire(
                '¡Error!',
                'Debes introducir un número válido.'
            )
        }        
    })
    $('#cp').on('keyup', function(){
        let num = $(this).val();
        if(!esNumero(num)){
            Swal.fire(
                '¡Error!',
                'Debes introducir un número válido.'
            )
        }        
    })
    $('#css').on('keyup', function(){
        let num = $(this).val();
        if(!esNumero(num)){
            Swal.fire(
                '¡Error!',
                'Debes introducir un número válido.'
            )
        }        
    })
    //validacion de registro de restaurante
    $('#registrar').on('click', validarRegistro);    
    //validacion de inicio de sesión
    $('#inicioSesion').on('click', validarInicio);  
    //validacion de recuperación de contraseña
    $('#recuperarPass').on('click', validarRecuperarPass);  


});


function genPass(){
    let pass = document.getElementById('pass');
    let pass2 = document.getElementById('pass2');
    
    let arr = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','ñ','o','p','q','r','s','t','u','v','w','x','y','z',
                'A','B','C','D','E','F','G','H','I','J','K','L','M','N','Ñ','O','P','Q','R','S','T','U','V','W','X','Y','Z',
                '¿','?','¡','!','$','-','_'];

    let final ="";

    for(let i = 1; i<=12;i++){
        var num = Math.floor(Math.random()*62);
        final+=arr[num];
    } 
    pass.value = final;
    pass2.value = final;
}

function verPass(){
    
    let pass = document.getElementById('pass');
    pass.type="text";

}

function noVerPass(){
    
    let pass = document.getElementById('pass');
    pass.type="password";

}

//validacion de formularios
function validarRegistro(){
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
    if(!$('#pp').is(':checked')){
        Swal.fire(
            '¡Error!',
            'Debe aceptar la política de privacidad.'
        )
        return false;
    }
    return true;
    
}
function validarInicio(){
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
    return true;
    
}
function validarRecuperarPass(){
    if(!isEmail($('#email').val())){
        Swal.fire(
            '¡Error!',
            'El campo "email" es obligatorio.'
        )
        return false;
    }
    return true;
    
}
function esNumero(num){
    if(!isNaN(num)){
        return true;
    }else{
        return false;
    }
}
function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}