<?php
 
include_once ".././clases/DAO.php";

$email = filter_var($_REQUEST['email'], FILTER_SANITIZE_EMAIL);

$metodos = new Metodos();
$metodos::recuperarPass($email);

?>