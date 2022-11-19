<?php

session_start();
require("../conexao.php");
require("funcao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false){

    $usuario = $_SESSION['idusuario'];
    $material = filter_input(INPUT_POST, 'material');
    $fornecedor = explode("-",filter_input(INPUT_POST, 'fornecedor'));
    $fornecedor = trim($fornecedor[0]);
    $recebimento = filter_input(INPUT_POST, 'recebimento');
    $qtd = filter_input(INPUT_POST, 'qtd');
    $rua = filter_input(INPUT_POST, 'rua');
    $predio = filter_input(INPUT_POST, 'predio');
    $nivel = filter_input(INPUT_POST, 'nivel');
    $apartamento = filter_input(INPUT_POST, 'apartamento');
    $valorUnit =str_replace(",",".",filter_input(INPUT_POST, 'valor')) ;
    $valorTotal = $valorUnit*$qtd;

    
    $sql = $db->prepare("INSERT INTO entradas (data_recebimento, material, industria,  qtd, valor_unit, valor_total, rua, predio, nivel, apartamento, usuario) VALUES (:recebimento, :material, :industria, :qtd, :valorUnit, :valorTotal, :rua, :predio, :nivel, :apartamento, :usuario)");
    $sql->bindValue(':recebimento', $recebimento);
    $sql->bindValue(':material', $material);
    $sql->bindValue(':industria', $fornecedor);
    $sql->bindValue(':qtd', $qtd);
    $sql->bindValue(':valorUnit', $valorUnit);
    $sql->bindValue(':valorTotal', $valorTotal);
    $sql->bindValue(':rua', $rua);
    $sql->bindValue(':predio', $predio);
    $sql->bindValue(':nivel', $nivel);
    $sql->bindValue(':apartamento', $apartamento);
    $sql->bindValue(':usuario', $usuario);
    
    if($sql->execute()){
        contaEstoque($material);
        echo "<script> alert('Entrada Lançada!!!')</script>";
        echo "<script> window.location.href='entradas.php' </script>";
    }else{
        print_r($sql->errorInfo());
    }

}else{
    echo "<script> alert('Acesso não permitido')</script>";
    echo "<script> window.location.href='index.php' </script>";
}

?>