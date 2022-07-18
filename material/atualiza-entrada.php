<?php

session_start();
require("../conexao.php");
require("funcao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false){

    $idEntrada = filter_input(INPUT_POST, 'id');
    $usuario = $_SESSION['idusuario'];
    $material = filter_input(INPUT_POST, 'material');
    $fornecedor = explode("-",filter_input(INPUT_POST, 'fornecedorEdit'));
    $fornecedor = trim($fornecedor[0]);
    $recebimento = filter_input(INPUT_POST, 'recebimento');
    $qtd = filter_input(INPUT_POST, 'qtd');
    $rua = filter_input(INPUT_POST, 'rua');
    $predio = filter_input(INPUT_POST, 'predio');
    $nivel = filter_input(INPUT_POST, 'nivel');
    $apartamento = filter_input(INPUT_POST, 'apartamento');

    //echo "$idEntrada<br>$usuario<br>$material<br>$fornecedor<br>$recebimento<br>$qtd";
    
    $sql = $db->prepare("UPDATE entradas SET data_recebimento = :recebimento, material = :material, industria = :industria, qtd = :qtd, rua = :rua, predio = :predio, nivel = :nivel, apartamento = :apartamento, usuario = :usuario WHERE identradas = :id");
    $sql->bindValue(':recebimento', $recebimento);
    $sql->bindValue(':material', $material);
    $sql->bindValue(':industria', $fornecedor);
    $sql->bindValue(':qtd', $qtd);
    $sql->bindValue(':rua', $rua);
    $sql->bindValue(':predio', $predio);
    $sql->bindValue(':nivel', $nivel);
    $sql->bindValue(':apartamento', $apartamento);
    $sql->bindValue(':usuario', $usuario);
    $sql->bindValue(':id', $idEntrada);
    
    if($sql->execute()){
        contaEstoque($material);
        echo "<script> alert('Entrada Atualizada!!!')</script>";
        echo "<script> window.location.href='entradas.php' </script>";
    }else{
        print_r($sql->errorInfo());
    }

}else{
    echo "<script> alert('Acesso não permitido')</script>";
    echo "<script> window.location.href='index.php' </script>";
}

?>