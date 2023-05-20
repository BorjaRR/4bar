<?php

    include_once ".././clases/DAO.php";

    if(isset($_REQUEST['pass'])&&$_REQUEST['pass']==$_REQUEST['pass2']){
            $dao = new Metodos();
            $dao::nuevaPass($_REQUEST['id'], $_REQUEST['pass']);
    }else{
        $id=base64_encode($_REQUEST['id']);
        header("Location:../nuevaPassword.php?id=$id&error_log=1");
    }

?>