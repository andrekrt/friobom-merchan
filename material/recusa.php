<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false && ($_SESSION['tipoUsuario'] == 2 || $_SESSION['tipoUsuario'] == 99)){

    $idSolicitacao = filter_input(INPUT_POST, 'recusa');
    $situacao = "Recusado";
    $motivo = filter_input(INPUT_POST, 'obs');

    // echo "$idSolicitacao<br>$situacao<br>$motivo";

    $atualizar = $db->prepare("UPDATE solicitacao_saida_material SET status_solic = :situacao, obs = :obs WHERE idsolicitacao = :id");
    $atualizar->bindValue(':situacao', $situacao);
    $atualizar->bindValue(':obs', $motivo);
    $atualizar->bindValue(':id', $idSolicitacao);
    if($atualizar->execute()){
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