<?php

session_start();
require("../conexao.php");
require("funcao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario'] == 99)){

    $usuario = $_SESSION['idusuario'];
    $brinde = filter_input(INPUT_POST, 'brinde');
    $recebimento = filter_input(INPUT_POST, 'recebimento');
    $qtd = filter_input(INPUT_POST, 'qtd');
    $nf = filter_input(INPUT_POST, 'nf');
    $fornecedor = filter_input(INPUT_POST, 'fornecedor');

    // echo "$usuario<br>$brinde<br>$recebimento<br>$qtd";
    
    $sql = $db->prepare("INSERT INTO brindes_entrada (data_recebimento, qtd, usuario, brinde, num_nf, industria) VALUES (:recebimento, :qtd, :usuario, :brinde, :nf, :industria)");
    $sql->bindValue(':recebimento', $recebimento);
    $sql->bindValue(':brinde', $brinde);
    $sql->bindValue(':qtd', $qtd);
    $sql->bindValue(':usuario', $usuario);
    $sql->bindValue(':nf', $nf);
    $sql->bindValue(':industria', $fornecedor);
    
    if($sql->execute()){
        contaEstoque($brinde);
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