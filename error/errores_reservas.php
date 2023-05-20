<?php

    if(isset($_REQUEST['reg'])){
        
        $reg =$_REQUEST['reg'];
        if($reg==0){
            print "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al guardar reserva.',
                        text: 'Recuede rellenar todos los campos del formulario para poder generar una reserva.',
                    })
                </script>
            ";
        }else if($reg==1){
            print "
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Reserva guardada.',
                    })
                </script>
            ";
        }

    }

    if(isset($_REQUEST['del'])){
        $del = $_REQUEST['del'];
        if($del==0){
            echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'La reserva no ha podido ser borrada, introduzca número secreto correcto.',
                    })
                </script>
            ";
        }else if($del==1){
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Algo salió mal, revise el apartado de preguntas frecuentes o pongase en contacto con el equipo técnico de 4bar.',
                })
            </script>
        ";
        }else if($del==2){
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No se pudo borrar la reserva de la base de datos, pongase en contacto con el equipo técnico de 4bar.',
                })
            </script>
        ";
        }else if($del=='del'){
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Reserva borrada con éxito.',
                })
            </script>
        ";
        }
    }


?>