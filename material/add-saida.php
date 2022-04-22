<?php

session_start();
require("../conexao.php");
require("funcao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false){

    $usuario = $_SESSION['idusuario'];
    $material = filter_input(INPUT_POST, 'material');
    $fornecedor = explode("-",filter_input(INPUT_POST, 'fornecedor'));
    $fornecedor = trim($fornecedor[0]);
    $saida = filter_input(INPUT_POST, 'saida');
    $qtd = filter_input(INPUT_POST, 'qtd');
    $cliente = filter_input(INPUT_POST, 'cliente');
    $rota = filter_input(INPUT_POST, 'rota');

    //verifica qtd no estoque
    $consulta = $db->prepare("SELECT total_estoque FROM material WHERE idmaterial = :material");
    $consulta->bindValue(':material', $material);
    $consulta->execute();
    $estoqueAtual = $consulta->fetch();
    $estoqueAtual = $estoqueAtual['total_estoque'];

    //echo "$usuario<br>$material<br>$fornecedor<br>$saida<br>$qtd<br>$cliente<br>$rota";

    if($qtd>$estoqueAtual){
        echo "<script> alert('Estoque Insuficiente!!!')</script>";
        echo "<script> window.location.href='saidas.php' </script>";
    }else{
        $sql = $db->prepare("INSERT INTO saidas (data_saida, material, industria,  qtd, cliente, rota, usuario) VALUES (:saida, :material, :industria, :qtd, :cliente, :rota, :usuario)");
        $sql->bindValue(':saida', $saida);
        $sql->bindValue(':material', $material);
        $sql->bindValue(':industria', $fornecedor);
        $sql->bindValue(':qtd', $qtd);
        $sql->bindValue(':cliente', $cliente);
        $sql->bindValue(':rota', $rota);
        $sql->bindValue(':usuario', $usuario);
        
        if($sql->execute()){
            contaEstoque($material);
            echo "<script> alert('Saida Lançada!!!')</script>";
            echo "<script> window.location.href='saidas.php' </script>";
        }else{
            print_r($sql->errorInfo());
        }
    }
    
}else{
    echo "<script> alert('Acesso não permitido')</script>";
    echo "<script> window.location.href='index.php' </script>";
}

?>