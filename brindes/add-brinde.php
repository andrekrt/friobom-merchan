<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario'] == 99)){

    $usuario = $_SESSION['idusuario'];
    $descricao = filter_input(INPUT_POST, 'descricao');
    $tipo = filter_input(INPUT_POST, 'tipo');
    $marca = filter_input(INPUT_POST, 'marca');

    // echo "$descricao<br>$tipo<br>$marca<br>$usuario";

    $sql = $db->prepare("INSERT INTO brindes (descricao, marca, tipo, usuario) VALUES (:descricao, :marca, :tipo, :usuario)");
    $sql->bindValue(':descricao', $descricao);
    $sql->bindValue(':tipo', $tipo);
    $sql->bindValue(':marca', $marca);
    $sql->bindValue(':usuario', $usuario);
    
    if($sql->execute()){
        echo "<script> alert('Brinde Cadastrado!!!')</script>";
        echo "<script> window.location.href='brindes.php' </script>";
    }else{
        print_r($sql->errorInfo());
    }    

}else{
    echo "<script> alert('Acesso não permitido')</script>";
    echo "<script> window.location.href='index.php' </script>";
}

?>