<?php

    if(isset($_REQUEST['mesa'])){
        
        $mesa =$_REQUEST['mesa'];
        if($mesa==0){
            print "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Número de seguridad incorrecto. Intentelo de nuevo.',
                    })
                </script>
            ";
        }else if($mesa==1){
            echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Algo ha salido mal. Intentelo de nuevo o consulte el apartado de preguntas frecuentes para encontrar solución.',
                    })
                </script>
            ";
        }else if($mesa=='fin'){
            echo "
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: '¡Mesa finalizada con éxito!',
                        text: 'Su mesa ha sido finalizada con éxito.',
                    })
                </script>
            ";
        }
        else if($mesa=='del'){
            echo "
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: '¡Mesa eliminada con éxito!',
                        text: 'Su mesa ha sido finalizada con éxito.',
                    })
                </script>
            ";
        }

    }

    if(isset($_REQUEST['add'])){
        $add = $_REQUEST['add'];
        if($add==1){
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Algo salió mal al añadir plato, por favor compruebe que la mesa indicada existe y no ha sido borrada. Si el problema persiste, consulte las preguntas frecuentes.',
                })
            </script>
        ";
        }
    }

    if(isset($_REQUEST['error'])){
        $error=$_REQUEST['error'];
        if($error==0){
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Mesa creada con éxito.',
                })
            </script>
            ";
        }else if($error==1){
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Introduzca mesa y comensales.',
                    text: 'Para añadir mesa, introduzca número de mesa y comensales. Recuerde que la mesa debe estar desocupada.',
                })
            </script>
            ";
        }else if($error==2){
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: '¡Mesa ocupada!',
                    text: 'La mesa seleccionada esta ocupada, desocúpela o pruebe con otra mesa.',
                })
            </script>
            ";
        }else if($error==3){
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error grave:',
                    text: 'La mesa ha sido creada sin cuenta. Para solucionarlo entre a preguntas frecuentes o pongase en contacto con el equipo técnico de 4bar.',
                })
            </script>
            ";
        }
    }

    if(isset($_REQUEST['errorCierre'])){
        $errorCierre=$_REQUEST['errorCierre'];
        if($errorCierre==1){
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: '¿Seguro que quieres cerrar el día?',
                    text:'Elimine o finalice las mesas abiertas antes de poder cerrar sessión.',
                })
            </script>
            ";
        }
    }

?>