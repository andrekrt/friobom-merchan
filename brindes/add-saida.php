<?php

session_start();
require("../conexao.php");
require("funcao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false){

    $usuario = $_SESSION['idusuario'];
    $brinde = filter_input(INPUT_POST, 'brinde');
    $dataSaida = filter_input(INPUT_POST, 'saida');
    $qtd = filter_input(INPUT_POST, 'qtd');
    $cliente = filter_input(INPUT_POST, 'cliente');
    $cidade = filter_input(INPUT_POST, 'cidade');
    $rca = filter_input(INPUT_POST, 'rca');
    $obs = filter_input(INPUT_POST, 'obs');

    //verifica qtd no estoque
    $consulta = $db->prepare("SELECT total_estoque FROM brindes WHERE idbrindes = :brinde");
    $consulta->bindValue(':brinde', $brinde);
    $consulta->execute();
    $estoqueAtual = $consulta->fetch();
    $estoqueAtual = $estoqueAtual['total_estoque'];

    // echo "$usuario<br>$brinde<br>$dataSaida<br>$qtd<br>$cliente<br>$cidade<br>$rca<br>$obs<br>$estoqueAtual";

    if($qtd>$estoqueAtual){
        echo "<script> alert('Estoque Insuficiente!!!')</script>";
        echo "<script> window.location.href='saidas.php' </script>";
    }else{
        $sql = $db->prepare("INSERT INTO brindes_saida (data_saida, qtd, cliente, cidade, rca, obs, usuario, brinde) VALUES (:dataSaida, :qtd, :cliente, :cidade, :rca, :obs, :usuario, :brinde)");
        $sql->bindValue(':dataSaida', $dataSaida);
        $sql->bindValue(':qtd', $qtd);
        $sql->bindValue(':cliente', $cliente);
        $sql->bindValue(':cidade', $cidade);
        $sql->bindValue(':rca', $rca);
        $sql->bindValue(':obs', $obs);
        $sql->bindValue(':usuario', $usuario);
        $sql->bindValue(':brinde', $brinde);
        
        if($sql->execute()){
            contaEstoque($brinde);
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