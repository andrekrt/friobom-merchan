<?php

session_start();
require("../conexao.php");
require("funcao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false){

    $idSaida = filter_input(INPUT_POST, 'id');
    $brinde = filter_input(INPUT_POST, 'brinde');
    $dataSaida = filter_input(INPUT_POST, 'saida');
    $qtd = filter_input(INPUT_POST, 'qtd');
    $cliente = filter_input(INPUT_POST, 'cliente');
    $cidade = filter_input(INPUT_POST, 'cidade');
    $rca = filter_input(INPUT_POST, 'rca');
    $obs = filter_input(INPUT_POST, 'obs');

    // echo "$idSaida<br>$brinde<br>$dataSaida<br>$qtd<br>$cliente<br>$cidade<br>$rca<br>$obs";

    //verifica qtd no estoque
    $consulta = $db->prepare("SELECT total_estoque FROM brindes WHERE idbrindes = :brinde");
    $consulta->bindValue(':brinde', $brinde);
    $consulta->execute();
    $estoqueAtual = $consulta->fetch();
    $estoqueAtual = $estoqueAtual['total_estoque'];

    if($qtd>$estoqueAtual){
        echo "<script> alert('Estoque Insuficiente!!!')</script>";
        echo "<script> window.location.href='saidas.php' </script>";
    }else{
        $sql = $db->prepare("UPDATE brindes_saida SET data_saida = :saida, qtd = :qtd, cliente = :cliente, cidade = :cidade, rca = :rca, obs = :obs WHERE idbrindes_saida = :id");
        $sql->bindValue(':saida', $dataSaida);
        $sql->bindValue(':qtd', $qtd);
        $sql->bindValue(':cliente', $cliente);
        $sql->bindValue(':cidade', $cidade);
        $sql->bindValue(':rca', $rca);
        $sql->bindValue(':obs', $obs);
        $sql->bindValue(':id', $idSaida);
        
        if($sql->execute()){
            contaEstoque($brinde);
            echo "<script> alert('Saída Atualizada!!!')</script>";
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