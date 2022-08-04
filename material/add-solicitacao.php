<?php

session_start();
require("../conexao.php");
require("../conexao-oracle.php");
require("funcao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario'] == 99)){

    $usuario = $_SESSION['idusuario'];
    $material = filter_input(INPUT_POST, 'material');
    $qtd = filter_input(INPUT_POST, 'qtd');
    $pedido = filter_input(INPUT_POST, 'pedido');
    $fornecedor = explode("-",filter_input(INPUT_POST, 'fornecedor'));
    $fornecedor = trim($fornecedor[0]);
    $valorTotal = 0;
    $situacao = "Em Análise";

    //verificar se pedido existe
    $consultaPedido = $dbora->prepare("SELECT * FROM friobom.pcpedc where numped = :pedido ");
    $consultaPedido->bindValue(':pedido', $pedido);
    $consultaPedido->execute();
    $pedidos = $consultaPedido->fetchAll();
    if(count($pedidos)<1){
        echo "<script> alert('Pedido Inexistente')</script>";
        echo "<script> window.location.href='solicitacao-saida.php' </script>";
    }

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

    // echo "$usuario<br>$material<br>$fornecedor<br>$qtd<br>$pedido";

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

        $inserir = $db->prepare("INSERT INTO solicitacao_saida_material (material, qtd, pedido, cliente, rota, num_itens, valor, status_solic, solicitante) VALUE(:material, :qtd, :pedido, :cliente, :rota, :itens, :valor, :situacao, :solicitante) ");
        $inserir->bindValue(':material', $material);
        $inserir->bindValue(':qtd', $qtd);
        $inserir->bindValue(':pedido', $pedido);
        $inserir->bindValue(':cliente', $dadosCli['CODCLI']." - ". utf8_encode($dadosCli['CLIENTE']));
        $inserir->bindValue(':rota', $dadosCli['MUNICENT']);
        $inserir->bindValue(':itens', $numItens);
        $inserir->bindValue(':valor', $valorTotal);
        $inserir->bindValue(':situacao', $situacao);
        $inserir->bindValue(':solicitante', $usuario);
        $inserir->execute();

        echo "<script> alert('Solicitação Lançada!!!')</script>";
        echo "<script> window.location.href='solicitacao-saida.php' </script>";
        
    }else{
        print_r($sqlwint->errorInfo()); 
        print_r($qtdWint->errorInfo());
    }
    
    
}else{
    echo "<script> alert('Acesso não permitido')</script>";
    echo "<script> window.location.href='index.php' </script>";
}

?>