<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false){

    $cpf = filter_input(INPUT_POST, 'cpf');
    $email = filter_input(INPUT_POST, 'email');
    $nome = filter_input(INPUT_POST, 'nome');
    $senha = password_hash(filter_input(INPUT_POST,'senha'), PASSWORD_DEFAULT) ;

    $sql = $db->prepare("INSERT INTO usuarios (cpf, email, nome, senha) VALUES (:cpf, :email, :nome, :senha)");
    $sql->bindValue(':cpf', $cpf);
    $sql->bindValue(':email', $email);
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':senha', $senha);
    
    if($sql->execute()){
        echo "<script> alert('Usuário Cadastrado!!!')</script>";
        echo "<script> window.location.href='form-usuario.php' </script>";
    }else{
        print_r($sql->errorInfo());
    }

}else{
    echo "<script> alert('Acesso não permitido')</script>";
    echo "<script> window.location.href='index.php' </script>";
}

?>