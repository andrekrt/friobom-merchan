<?php

session_start();
require("../conexao.php");
require("funcao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false){

    $idSaida = filter_input(INPUT_POST, 'id');
    $usuario = $_SESSION['idusuario'];
    $material = filter_input(INPUT_POST, 'materialEdit');
    $fornecedor = explode("-",filter_input(INPUT_POST, 'fornecedorEdit'));
    $fornecedor = trim($fornecedor[0]);
    $saida = filter_input(INPUT_POST, 'saida');
    $qtd = filter_input(INPUT_POST, 'qtd');
    $cliente = filter_input(INPUT_POST, 'cliente');
    $rota = filter_input(INPUT_POST, 'rota');

    //echo "$idSaida<br>$usuario<br>$material<br>$fornecedor<br>$saida<br>$qtd<br>$cliente<br>$rota";

    //verifica qtd no estoque
    $consulta = $db->prepare("SELECT total_estoque FROM material WHERE idmaterial = :material");
    $consulta->bindValue(':material', $material);
    $consulta->execute();
    $estoqueAtual = $consulta->fetch();
    $estoqueAtual = $estoqueAtual['total_estoque'];

    if($qtd>$estoqueAtual){
        echo "<script> alert('Estoque Insuficiente!!!')</script>";
        echo "<script> window.location.href='saidas.php' </script>";
    }else{
        $sql = $db->prepare("UPDATE saidas SET data_saida = :saida, material = :material, industria = :industria, qtd = :qtd, usuario = :usuario, cliente = :cliente, rota = :rota WHERE idsaidas = :id");
        $sql->bindValue(':saida', $saida);
        $sql->bindValue(':material', $material);
        $sql->bindValue(':industria', $fornecedor);
        $sql->bindValue(':qtd', $qtd);
        $sql->bindValue(':usuario', $usuario);
        $sql->bindValue(':cliente', $cliente);
        $sql->bindValue(':rota', $rota);
        $sql->bindValue(':id', $idEntrada);
        
        if($sql->execute()){
            contaEstoque($material);
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