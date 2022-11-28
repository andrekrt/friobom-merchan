<?php

session_start();
require("../conexao.php");
require("../conexao-oracle.php");
require("funcao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario'] == 99)){

    $recolhimento = filter_input(INPUT_POST, 'recebimento');
    $situacao = "Recolhido";
    $contrato = $_FILES['contrato'];
    $tipoArquivo = pathinfo($_FILES['contrato']['name'], PATHINFO_EXTENSION);
    $dataRecolhimento = date("Y-m-d H:i:s");
    $pasta = 'contratos/recolhimentos/';

    $nome = $pasta.$recolhimento.".".$tipoArquivo;

    //echo "$usuario<br>$material<br>$fornecedor<br>$qtd<br>$pedido<br>$idSolicitacao";

    $atualizar = $db->prepare("UPDATE saidas SET status_saida = :situacao, data_recolhimento = :dataRecolhimento WHERE idsaidas = :id");
    $atualizar->bindValue(':dataRecolhimento', $dataRecolhimento);
    $atualizar->bindValue(':situacao', $situacao);
    $atualizar->bindValue(':id', $recolhimento);
    if($atualizar->execute()){
        $pasta = 'contratos/recolhimentos/';
        $mover = move_uploaded_file($_FILES['contrato']['tmp_name'],$pasta.$recolhimento.".".$tipoArquivo);

        echo "<script> alert('Solicitação Atualizada!!!')</script>";
        echo "<script> window.location.href='saidas.php' </script>";
    }else{
        print_r($atualizar->errorInfo());
    }    
    
}else{
    echo "<script> alert('Acesso não permitido')</script>";
    echo "<script> window.location.href='index.php' </script>";
}

?>