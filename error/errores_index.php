<?php

    if(isset($_REQUEST['login'])){
        
        $login =$_REQUEST['login'];
        if($login==0){
            print "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El registro no se ha podido realizar, revise que los datos sean correctos.',
                    })
                </script>
            ";
        }else if($login=='check'){
            echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops..',
                        text: 'Debe aceptar la política de privacidad para poder continuar.',
                    })
                </script>
            ";
        }else if($login==1){
            echo "
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Registro realizado',
                        text: 'Registro realizado con éxito. Bienvenido.',
                    })
                </script>
            ";
        }

    }

    if(isset($_REQUEST['enviado'])){
        $enviado = $_REQUEST['enviado'];
        if($enviado==0){
            echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Algo salió mal...',
                        text: 'Por favor, revise el mail que ha indicado en el formulario.',
                    })
                </script>
            ";
        }else if($enviado==1){
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Mensaje enviado',
                    text: 'Revise su bandeja de entrada para poder realizar el cambio.',
                })
            </script>
        ";
        }
    }

    if(isset($_REQUEST['error_log'])){
        $error_log=$_REQUEST['error_log'];
        if($error_log==1){
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Algo salió mal...',
                    text: 'Ambos campos deben ser iguales. Revise los campos antes de enviar.',
                })
            </script>
            ";
        }else if($error_log==0){
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Cambio realizado',
                    text: 'Su contraseña ha sido cambiada con éxito.',
                })
            </script>
            ";
        }
    }

?>