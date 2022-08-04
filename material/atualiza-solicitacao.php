<?php

session_start();
require("../conexao.php");
require("../conexao-oracle.php");
require("funcao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario'] == 99)){

    $idSolicitacao = filter_input(INPUT_POST, 'id');
    $material = filter_input(INPUT_POST, 'material');
    $qtd = filter_input(INPUT_POST, 'qtd');
    $pedido = filter_input(INPUT_POST, 'pedido');
    $fornecedor = explode("-",filter_input(INPUT_POST, 'fornecedor'));
    $fornecedor = trim($fornecedor[0]);
    $valorTotal = 0;

    //verifica qtd no estoque
    $consulta = $db->prepare("SELECT total_estoque FROM material WHERE idmaterial = :material LIMIT 1");
    $consulta->bindValue(':material', $material);
    $consulta->execute();
    $estoqueAtual = $consulta->fetch();
    $estoqueAtual = $estoqueAtual['total_estoque'];
    if($qtd>$estoqueAtual){
        echo "<script> alert('Estoque Insuficiente!!!')</script>";
        echo "<script> window.location.href='solicitacao-saida.php' </script>";
    }

    //  echo "$usuario<br>$material<br>$fornecedor<br>$qtd<br>$pedido<br>$idSolicitacao";

    //consulta no winthor
    $sqlwint = $dbora->prepare("SELECT PCCLIENT.CODCLI, PCCLIENT.CLIENTE, PCCLIENT.MUNICENT  FROM friobom.pcpedi LEFT JOIN friobom.pcclient ON pcpedi.codcli = pcclient.codcli LEFT JOIN friobom.PCPRODUT ON pcpedi.codprod = pcprodut.codprod where numped = :pedido and codfornec = :fornecedor");
    $sqlwint->bindValue(':pedido', $pedido);
    $sqlwint->bindValue(':fornecedor', $fornecedor);
    $sqlwint->execute();

    $qtdWint = $dbora->prepare("SELECT pcpedi.qt, pcpedi.pvenda FROM friobom.pcpedi LEFT JOIN friobom.PCPRODUT ON pcpedi.codprod = pcprodut.codprod where numped = :pedido and codfornec = :fornecedor ");
    $qtdWint->bindValue(':pedido', $pedido);
    $qtdWint->bindValue(':fornecedor', $fornecedor);
    $qtdWint->execute();
    $valores = $qtdWint->fetchAll();
    $numItens = count($valores);
    foreach($valores as $valor){
        $valorTotal = $valorTotal+(str_replace(",",".",$valor['QT']) * str_replace(",",".",$valor['PVENDA']) );
    }

    if($sqlwint && $qtdWint ){
        $dadosCli = $sqlwint->fetch();

        $inserir = $db->prepare("UPDATE solicitacao_saida_material SET material = :material, qtd = :qtd, pedido = :pedido, cliente = :cliente, rota=:rota, num_itens = :itens, valor = :valor WHERE idsolicitacao = :id");
        $inserir->bindValue(':material', $material);
        $inserir->bindValue(':qtd', $qtd);
        $inserir->bindValue(':pedido', $pedido);
        $inserir->bindValue(':cliente', $dadosCli['CODCLI']." - ". utf8_encode($dadosCli['CLIENTE']));
        $inserir->bindValue(':rota', $dadosCli['MUNICENT']);
        $inserir->bindValue(':itens', $numItens);
        $inserir->bindValue(':valor', $valorTotal);
        $inserir->bindValue(':id', $idSolicitacao);
        print_r($sqlwint);
        if( $inserir->execute()){
            echo "<script> alert('Solicitação Atualizada!!!')</script>";
            echo "<script> window.location.href='solicitacao-saida.php' </script>";
        }else{
            print_r($inserir->errorInfo());
        }
       

        
        
    }else{
        print_r($sqlwint->errorInfo()); 
        print_r($qtdWint->errorInfo());
    }
    
    
}else{
    echo "<script> alert('Acesso não permitido')</script>";
    echo "<script> window.location.href='index.php' </script>";
}

?>