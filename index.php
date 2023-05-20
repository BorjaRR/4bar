<?php
    include_once "./complementos/cabecera_intro.php";
    include_once "./error/errores_index.php";

    if(isset($_SESSION)){
        session_destroy();
    }
?>
<body>
    <div class="container-fluid index">
        <div class="row d-flex justify-content-center align-items-center vh-100">
            <div class="col-6 text-center tx-white">
                <img src="./img/4bar_logo.png" alt="" class="img-fluid">
                <p class="tx-white">INICIAR SESIÓN</p>
                <form action="./utils/inicioSesion.php" method="get" name="registro" class="text-start">
                    <label for="email">Correo electrónico</label>
                    <input type="email" name="email" id="email" class="d-block" placeholder="tuemail@gmail.com" required>

                    <label for="pass">Contraseña</label>
                    <input type="password" name="pass" id="pass" class="d-block mb-4" placeholder="Tu contraseña aquí" required>
                    
                    <a href="recuperacionPass.php">He olvidado mi contraseña</a>
                    <p class="registro m-0 mt-3">
                        ¿Aún no trabajas con 4bar? <a href="registroRestaurante.php">Regístrate ahora</a> para descubrir las ventajas de trabajar con nosotros.
                    </p>
                    
                    <button id="inicioSesion" type="submit" class="mt-4">Iniciar sesión</button>
                    
                </form>
            </div>
        </div>
    </div>

<script src="./js/script.js"></script>
<?php
    include "./error/errores_index.php";
?>
</body>
</html>