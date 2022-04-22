<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false){

    $cod = filter_input(INPUT_POST, 'cod');
    $razao = filter_input(INPUT_POST, 'razao');
    $fantasia = filter_input(INPUT_POST, 'fantasia');


    //consultar fornecedor cadastrado
    $consulta = $db->prepare("SELECT * FROM industrias WHERE idindustrias = :cod");
    $consulta->bindValue(':cod', $cod);
    $consulta->execute();

    if($consulta->rowCount()){
        echo "<script> alert('Esse código já está cadastrado')</script>";
        echo "<script> window.location.href='form-fornecedor.php' </script>";
    }else{

        $sql = $db->prepare("INSERT INTO industrias (idindustrias, razao, fantasia) VALUES (:cod, :razao, :fantasia)");
        $sql->bindValue(':cod', $cod);
        $sql->bindValue(':razao', $razao);
        $sql->bindValue(':fantasia', $fantasia);
        
        if($sql->execute()){
            echo "<script> alert('Fornecedor Cadastrado!!!')</script>";
            echo "<script> window.location.href='form-fornecedor.php' </script>";
        }else{
            print_r($sql->errorInfo());
        }

    }

    

}else{
    echo "<script> alert('Acesso não permitido')</script>";
    echo "<script> window.location.href='index.php' </script>";
}

?>