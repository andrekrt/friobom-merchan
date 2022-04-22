<?php

function contaEstoque($material){
    require("../conexao.php");

    //qtd de entradas
    $entradas = $db->prepare("SELECT SUM(qtd) as qtd FROM entradas WHERE material = :material");
    $entradas->bindValue(':material', $material);
    $entradas->execute();
    $qtdEntradas = $entradas->fetch();
    $qtdEntradas = $qtdEntradas['qtd']?$qtdEntradas['qtd']:0;

    //qtd de saídas
    $saidas = $db->prepare("SELECT SUM(qtd) as qtd FROM saidas WHERE material = :material");
    $saidas->bindValue(':material', $material);
    $saidas->execute();
    $qtdSaidas = $saidas->fetch();
    $qtdSaidas = $qtdSaidas['qtd']?$qtdSaidas['qtd']:0;

    $totalEstoque = $qtdEntradas-$qtdSaidas;

    //estoque minimo 
    $minimo = $db->prepare("SELECT * FROM material WHERE idmaterial = :material");
    $minimo->bindValue(':material', $material);
    $minimo->execute();
    $qtdMinimo = $minimo->fetch();
    $qtdMinimo = $qtdMinimo['estoque_minimo'];

    if($totalEstoque<=$qtdMinimo){
        $status = 'Solicitar';
    }else{
        $status = 'OK';
    }

    $atualiza = $db->prepare("UPDATE material SET total_entrada = :entradas, total_saida = :saidas, total_estoque = :estoque, situacao = :situacao WHERE idmaterial = :material");
    $atualiza->bindValue(':entradas', $qtdEntradas);
    $atualiza->bindValue(':saidas', $qtdSaidas);
    $atualiza->bindValue(':estoque', $totalEstoque);
    $atualiza->bindValue(':situacao', $status);
    $atualiza->bindValue(':material', $material);
    $atualiza->execute();
}

?>