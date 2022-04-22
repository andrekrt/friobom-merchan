<?php

session_start();
require("../conexao.php");
require("funcao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false){

    $idEntrada = filter_input(INPUT_POST, 'id');
    $usuario = $_SESSION['idusuario'];
    $material = filter_input(INPUT_POST, 'materialEdit');
    $fornecedor = explode("-",filter_input(INPUT_POST, 'fornecedorEdit'));
    $fornecedor = trim($fornecedor[0]);
    $recebimento = filter_input(INPUT_POST, 'recebimento');
    $qtd = filter_input(INPUT_POST, 'qtd');

    //echo "$idEntrada<br>$usuario<br>$material<br>$fornecedor<br>$recebimento<br>$qtd";
    
    $sql = $db->prepare("UPDATE entradas SET data_recebimento = :recebimento, material = :material, industria = :industria, qtd = :qtd, usuario = :usuario WHERE identradas = :id");
    $sql->bindValue(':recebimento', $recebimento);
    $sql->bindValue(':material', $material);
    $sql->bindValue(':industria', $fornecedor);
    $sql->bindValue(':qtd', $qtd);
    $sql->bindValue(':usuario', $usuario);
    $sql->bindValue(':id', $idEntrada);
    
    if($sql->execute()){
        contaEstoque($material);
        echo "<script> alert('Entrada Atualizada!!!')</script>";
        echo "<script> window.location.href='entradas.php' </script>";
    }else{
        print_r($sql->errorInfo());
    }

}else{
    echo "<script> alert('Acesso não permitido')</script>";
    echo "<script> window.location.href='index.php' </script>";
}

?>