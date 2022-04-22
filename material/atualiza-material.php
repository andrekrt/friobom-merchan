<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false){

    $id = filter_input(INPUT_POST, 'id');
    $descricao = filter_input(INPUT_POST, 'descricao');
    $tipo = filter_input(INPUT_POST, 'tipo');
    $minimo = filter_input(INPUT_POST, 'minimo');
    $fornecedor = filter_input(INPUT_POST, 'fornecedor');

    //echo "$id<br>$fornecedor<br>$departamento<br>$tipoVolume<br>$valorVolume";

    $atualiza = $db->prepare("UPDATE material SET descricao = :descricao, tipo = :tipo, estoque_minimo = :minimo, industria = :industria WHERE idmaterial = :id");
    $atualiza->bindValue(':descricao', $descricao);
    $atualiza->bindValue(':tipo', $tipo);
    $atualiza->bindValue(':minimo', $minimo);
    $atualiza->bindValue(':industria', $fornecedor);
    $atualiza->bindValue(':id', $id);

    if($atualiza->execute()){
        echo "<script> alert('Atualizado com Sucesso!')</script>";
        echo "<script> window.location.href='materiais.php' </script>";
    }else{
        print_r($atualiza->errorInfo());
    }

}else{
    echo "<script> alert('Acesso não permitido!')</script>";
    echo "<script> window.location.href='colaboradores.php' </script>";
}

?>