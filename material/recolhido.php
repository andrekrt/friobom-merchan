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

        $material = consultaMaterial($recolhimento);

        $inserir = $db->prepare("INSERT INTO entradas (data_recebimento, material, industria, qtd, valor_unit, valor_total, rua, predio, nivel, apartamento, usuario) VALUES(:dataRecolhimento, :material, :industria, :qtd, :valor_unit, :valorTotal, :rua, :predio, :nivel, :apartamento, :usuario)");
        $inserir->bindValue(':dataRecolhimento', $dataRecolhimento);
        $inserir->bindValue(':material', $material['material']);
        $inserir->bindValue(':industria',$material['industria']);
        $inserir->bindValue(':qtd', $material['qtd']);
        $inserir->bindValue(':valor_unit', 0);
        $inserir->bindValue(':valorTotal',0);
        $inserir->bindValue(':rua', "");
        $inserir->bindValue(':predio', "");
        $inserir->bindValue(':nivel', "");
        $inserir->bindValue(':apartamento', "");
        $inserir->bindValue(':usuario', $_SESSION['idusuario']);

        if($inserir->execute()){
            contaEstoque($material['material']);
            $pasta = 'contratos/recolhimentos/';
            $mover = move_uploaded_file($_FILES['contrato']['tmp_name'],$pasta.$recolhimento.".".$tipoArquivo);

            echo "<script> alert('Solicitação Atualizada!!!')</script>";
            echo "<script> window.location.href='saidas.php' </script>";
        }else{
            print_r($inserir->errorInfo());
        }
        
    }else{
        print_r($atualizar->errorInfo());
    }    
    
}else{
    echo "<script> alert('Acesso não permitido')</script>";
    echo "<script> window.location.href='index.php' </script>";
}

?>