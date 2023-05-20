<?php
    include_once "./complementos/cabecera_intro.php";
?>
<body>
    <div class="container-fluid">
            <?php

                include "./clases/DAO.php";
                $dao = new Metodos();

                if(isset($_REQUEST['id'])){
                    $id = $dao->decoder($_REQUEST['id']);
                }else{
                    header("Location:index.php");
                }
            ?>
        
            <div class="row d-flex justify-content-center align-content-center vh-100">
                <div class="col-6 tx-white my-5">
                    <h1 class="tx-white">Cambio de contraseña</h1>
                    <form action="./utils/nuevaPass.php" method="post" name="registro">
                    <a href="index.php" class="d-block">Volver al inicio</a>
                    
                        <label for="pass">Introduce nueva contraseña</label>
                        <input type="password" name="pass" id="pass" class="d-block" onkeydown="mostrar();" required>

                        <label for="pass2">Repite la contraseña</label>
                        <input type="password" name="pass2" id="pass2" class="d-block" required>

                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <br>
                        <button type="submit">Enviar</button>
                    </form>
                </div>
            </div>

    </div>


<script>
    function mostrar(){
        let pass = document.getElementById('pass').value();
        alert (pass);
    }
</script>
<script src="./js/script.js"></script>
<?php
    include "./error/errores_index.php";
?>
</body>
</html>