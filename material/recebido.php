<?php

session_start();
require("../conexao.php");
require("../conexao-oracle.php");
require("funcao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario'] == 99)){

    $idSolicitacao = filter_input(INPUT_POST, 'recebimento');
    $situacao = "Recebido";
    $contrato = $_FILES['contrato'];
    $tipoArquivo = pathinfo($_FILES['contrato']['name'], PATHINFO_EXTENSION);

    //echo "$usuario<br>$material<br>$fornecedor<br>$qtd<br>$pedido<br>$idSolicitacao";

    $atualizar = $db->prepare("UPDATE solicitacao_saida_material SET status_solic = :situacao WHERE idsolicitacao = :id");
    $atualizar->bindValue(':situacao', $situacao);
    $atualizar->bindValue(':id', $idSolicitacao);
    if($atualizar->execute()){
        $pasta = 'contratos/';
        $mover = move_uploaded_file($_FILES['contrato']['tmp_name'],$pasta.$idSolicitacao.".".$tipoArquivo);

        echo "<script> alert('Solicitação Atualizada!!!')</script>";
        echo "<script> window.location.href='solicitacao-saida.php' </script>";
    }else{
        print_r($atualizar->errorInfo());
    }    
    
}else{
    echo "<script> alert('Acesso não permitido')</script>";
    echo "<script> window.location.href='index.php' </script>";
}

?>