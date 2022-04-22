<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false){

    $usuario = $_SESSION['idusuario'];
    $descricao = filter_input(INPUT_POST, 'descricao');
    $tipo = filter_input(INPUT_POST, 'tipo');
    $minimo = filter_input(INPUT_POST, 'minimo');
    $fornecedor = filter_input(INPUT_POST, 'fornecedor');

    //echo "$descricao<br>$tipo<br>$minimo<br>$fornecedor";

    $sql = $db->prepare("INSERT INTO material (descricao, tipo, estoque_minimo, industria, usuario) VALUES (:descricao, :tipo, :minimo, :industria, :usuario)");
    $sql->bindValue(':descricao', $descricao);
    $sql->bindValue(':tipo', $tipo);
    $sql->bindValue(':minimo', $minimo);
    $sql->bindValue(':industria', $fornecedor);
    $sql->bindValue(':usuario', $usuario);
    
    if($sql->execute()){
        echo "<script> alert('Material Cadastrado!!!')</script>";
        echo "<script> window.location.href='materiais.php' </script>";
    }else{
        print_r($sql->errorInfo());
    }    

}else{
    echo "<script> alert('Acesso não permitido')</script>";
    echo "<script> window.location.href='index.php' </script>";
}

?>