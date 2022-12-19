<?php

function contaEstoque($material){
    require("../conexao.php");

    //qtd de entradas
    $entradas = $db->prepare("SELECT SUM(qtd) as qtd, SUM(valor_total) as vlTotal FROM entradas WHERE material = :material");
    $entradas->bindValue(':material', $material);
    $entradas->execute();
    $entradas = $entradas->fetch();
    $qtdEntradas = $entradas['qtd']?$entradas['qtd']:0;
    $vlTotal = $entradas['vlTotal']?$entradas['vlTotal']:0;
    if($qtdEntradas==0 || $vlTotal==0){
        $custoMedio = 0;
    }else{
        $custoMedio = $vlTotal/$qtdEntradas;
    }

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

    $atualiza = $db->prepare("UPDATE material SET total_entrada = :entradas, total_saida = :saidas, total_estoque = :estoque, situacao = :situacao, custo_medio=:custo WHERE idmaterial = :material");
    $atualiza->bindValue(':entradas', $qtdEntradas);
    $atualiza->bindValue(':saidas', $qtdSaidas);
    $atualiza->bindValue(':estoque', $totalEstoque);
    $atualiza->bindValue(':situacao', $status);
    $atualiza->bindValue(':material', $material);
    $atualiza->bindValue(':custo', $custoMedio);
    $atualiza->execute();
}

contaEstoque(6);
?>