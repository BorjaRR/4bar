<?php

include_once ".././clases/DAO.php";

    $email = filter_var($_REQUEST['email'], FILTER_SANITIZE_EMAIL);
    $pass = filter_var($_REQUEST['pass'],FILTER_SANITIZE_SPECIAL_CHARS);

    $metodos = new Metodos();
    $query = $metodos::validarInicioSesion($email, $pass);


?>