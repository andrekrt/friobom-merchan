<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario'] == 99)){

    $cpf = filter_input(INPUT_POST, 'cpf');
    $email = filter_input(INPUT_POST, 'email');
    $nome = filter_input(INPUT_POST, 'nome');
    $tipo = filter_input(INPUT_POST, 'tipo');
    $senha = password_hash(filter_input(INPUT_POST,'senha'), PASSWORD_DEFAULT) ;

    $sql = $db->prepare("INSERT INTO usuarios (cpf, email, nome, senha, tipo_usuario) VALUES (:cpf, :email, :nome, :senha, :tipo)");
    $sql->bindValue(':cpf', $cpf);
    $sql->bindValue(':email', $email);
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':senha', $senha);
    $sql->bindValue(':tipo', $tipo);
    
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