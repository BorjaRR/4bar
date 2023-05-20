<?php

    if(isset($_REQUEST['reg'])){
        
        $reg =$_REQUEST['reg'];
        if($reg==0){
            print "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Plato no registrado',
                        text: 'Compruebe los datos de registro y no deje ninguno vacío.',
                    })
                </script>
            ";
        }else if($reg==1){
            echo "
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Plato añadido.',
                        text: 'El plato ha sido añadido con éxito.',
                    })
                </script>
            ";
        }

    }

    if(isset($_REQUEST['add'])){
        $add = $_REQUEST['add'];
        if($add==0){
            echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'La mesa no existe o la cuenta no esta creada. Pruebe de nuevo. Si el problema persiste, consulte las preguntas frecuentes.',
                    })
                </script>
            ";
        }else if($add==2){
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Plato añadido con éxito',
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
                        text: 'El plato no ha podido ser borrado, compruebe el código de seguridad introducido. ',
                    })
                </script>
            ";
        }else if($del==1){
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Plato borrado con éxito.',
                })
            </script>
        ";
        }
    }

    if(isset($_REQUEST['errorDel'])){
        $error=$_REQUEST['errorDel'];
        if($error==0){
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                })
            </script>
            ";
        }else if($error==1){
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error al borrar plato.',
                    text: 'Si el problema persiste, consule el apartado de preguntas frecuentes.',
                })
            </script>
            ";
        }
    }

?>