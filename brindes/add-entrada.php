<?php

session_start();
require("../conexao.php");
require("funcao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false){

    $usuario = $_SESSION['idusuario'];
    $brinde = filter_input(INPUT_POST, 'brinde');
    $recebimento = filter_input(INPUT_POST, 'recebimento');
    $qtd = filter_input(INPUT_POST, 'qtd');

    // echo "$usuario<br>$brinde<br>$recebimento<br>$qtd";
    
    $sql = $db->prepare("INSERT INTO brindes_entrada (data_recebimento, qtd, usuario, brinde) VALUES (:recebimento, :qtd, :usuario, :brinde)");
    $sql->bindValue(':recebimento', $recebimento);
    $sql->bindValue(':brinde', $brinde);
    $sql->bindValue(':qtd', $qtd);
    $sql->bindValue(':usuario', $usuario);
    
    if($sql->execute()){
        contaEstoque($brinde);
        echo "<script> alert('Entrada Lançada!!!')</script>";
        echo "<script> window.location.href='entradas.php' </script>";
    }else{
        print_r($sql->errorInfo());
    }

}else{
    echo "<script> alert('Acesso não permitido')</script>";
    echo "<script> window.location.href='index.php' </script>";
}

?>