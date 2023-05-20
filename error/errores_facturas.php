<?php

    if(isset($_REQUEST['genFactura'])){
        
        $genFactura =$_REQUEST['genFactura'];
        if($genFactura==0){
            print "
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Factura generada.',
                    })
                </script>
            ";
        }

    }

    if(isset($_REQUEST['errorFactura'])){
        $errorFactura = $_REQUEST['errorFactura'];
        if($errorFactura==0){
            echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Algo salio mal al generar factura. Intentelo de nuevo y si el problema persiste, consulte el apartado de preguntas frecuentes.',
                    })
                </script>
            ";
        }else if($errorFactura==1){
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Algo salio mal al generar factura. Consulte el apartado de preguntas frecuentes o contacte con el equipo de 4bar.',
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
                        text: 'La factura no ha podido ser borrada, compruebe el código de seguridad introducido.',
                    })
                </script>
            ";
        }else if($del==1){
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Factura borrada con éxito.',
                })
            </script>
        ";
        }
    }


?>