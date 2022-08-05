<?php

include('conexao.php');

$selec = $db->query("SELECT * FROM brindes");
$usuarios = $selec->fetchAll();

foreach($usuarios as $usuario){
    $atualizar = $db->prepare("UPDATE brindes SET descricao = :descricao, tipo =:tipo WHERE idbrindes = :id ");
    $atualizar->bindValue(':descricao', utf8_decode($usuario['descricao']) );
    $atualizar->bindValue(':tipo', utf8_decode($usuario['tipo']) );
    $atualizar->bindValue(':id', $usuario['idbrindes']);
    if($atualizar->execute()){
        echo "certo<br>";
    }else{
        print_r($atualizar->errorInfo());
    }
}

// print_r($usuarios);

?>