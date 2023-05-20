<?php
    include_once "./complementos/cabecera_intro.php";
?>
<body>
    <div class="container-fluid">

        <?php
            if((!isset($_REQUEST['enviado']))||(isset($_REQUEST['enviado'])!=0)){
                print(
                    "<div class=\"row d-flex justify-content-center align-content-center vh-100\">
                        <div class=\"col-6 tx-white my-5\">
                            <h1 class=\"tx-white\">Recuperacion de contraseña</h1>
                            <p class=\"bienvenida\">Introduzca un mail válido para poder cambiar la contraseña.</p>
                            <form action=\"./utils/recuperarPass.php\" method=\"post\" name=\"registro\">
                            <a href=\"index.php\" class=\"d-block\">Volver al inicio</a>
                            
                                <label for=\"email\">Email para recuperación</label>
                                <input type=\"email\" name=\"email\" id=\"email\" class=\"d-block\" placeholder=\"Introduzca email válido.\" required>

                                <br>
                                <button id=\"recuperarPass\" type=\"submit\">Enviar</button>
                            </form>
                        </div>
                    </div>"
                );
            }else{
                print(
                    "<div class=\"row d-flex justify-content-center align-content-center vh-100\">
                        <div class=\"col-4 tx-white my-5\">
                            <h1 class=\"tx-white\">!Mensaje enviado con éxito!</h1>
                            <p class=\"bienvenida\">Comprueba tu email para solicitar el cambio de contraseña.</p>
                            <a href=\"index.php\" class=\"d-block\">Volver al inicio</a>
                        </div>
                    </div>"
                );
            }
        ?>

        
    </div>



<script src="./js/script.js"></script>
<?php
    include "./error/errores_index.php";
?>
</body>
</html>