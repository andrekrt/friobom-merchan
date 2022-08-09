<?php

session_start();
require("../conexao.php");
require("funcao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false){

    $material = filter_input(INPUT_POST, 'material');
    $fornecedor = filter_input(INPUT_POST, 'fornecedor');
    $fornecedor = explode(" - ",$fornecedor);
    $dataSaida = date("Y-m-d");
    $qtd = filter_input(INPUT_POST, 'qtd');
    $cliente = filter_input(INPUT_POST, 'cliente');
    $rota = filter_input(INPUT_POST, 'rota');
    $usuario = $_SESSION['idusuario'];

    // echo "$usuario<br>$material<br>$fornecedor[0]<br>$dataSaida<br>$qtd<br>$cliente<br>$rota";

    $sql = $db->prepare("INSERT INTO saidas (data_saida, material, industria,  qtd, cliente, rota, usuario) VALUES (:saida, :material, :industria, :qtd, :cliente, :rota, :usuario)");
    $sql->bindValue(':saida', $dataSaida);
    $sql->bindValue(':material', $material);
    $sql->bindValue(':industria', $fornecedor[0]);
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

    
}else{
    echo "<script> alert('Acesso não permitido')</script>";
    echo "<script> window.location.href='saidas.php' </script>";
}

?>