<?php

function contaEstoque($brinde){
    require("../conexao.php");

    //qtd de entradas
    $entradas = $db->prepare("SELECT SUM(qtd) as qtd FROM brindes_entrada WHERE brinde = :brinde");
    $entradas->bindValue(':brinde', $brinde);
    $entradas->execute();
    $qtdEntradas = $entradas->fetch();
    $qtdEntradas = $qtdEntradas['qtd']?$qtdEntradas['qtd']:0;

    //qtd de saídas
    $saidas = $db->prepare("SELECT SUM(qtd) as qtd FROM brindes_saida WHERE brinde = :brinde");
    $saidas->bindValue(':brinde', $brinde);
    $saidas->execute();
    $qtdSaidas = $saidas->fetch();
    $qtdSaidas = $qtdSaidas['qtd']?$qtdSaidas['qtd']:0;

    $totalEstoque = $qtdEntradas-$qtdSaidas;

    $atualiza = $db->prepare("UPDATE brindes SET total_entrada = :entradas, total_saida = :saidas, total_estoque = :estoque WHERE idbrindes = :brinde");
    $atualiza->bindValue(':entradas', $qtdEntradas);
    $atualiza->bindValue(':saidas', $qtdSaidas);
    $atualiza->bindValue(':estoque', $totalEstoque);
    $atualiza->bindValue(':brinde', $brinde);
    $atualiza->execute();
}

?>