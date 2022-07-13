<?php

session_start();
require("../conexao.php");
require("funcao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false){

    $idEntrada = filter_input(INPUT_POST, 'id');
    $recebimento = filter_input(INPUT_POST, 'recebimento');
    $qtd = filter_input(INPUT_POST, 'qtd');
    $brinde = filter_input(INPUT_POST, 'brinde');

    // echo "$idEntrada<br>$brinde<br>$recebimento<br>$qtd";
    
    $sql = $db->prepare("UPDATE brindes_entrada SET data_recebimento = :recebimento, qtd = :qtd WHERE idbrindes_entrada = :id");
    $sql->bindValue(':recebimento', $recebimento);
    $sql->bindValue(':qtd', $qtd);
    $sql->bindValue(':id', $idEntrada);
    
    if($sql->execute()){
        contaEstoque($brinde);
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