<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario'] == 99)){

    $id = filter_input(INPUT_POST, 'id');
    $descricao = filter_input(INPUT_POST, 'descricao');
    $tipo = filter_input(INPUT_POST, 'tipo');
    $marca = filter_input(INPUT_POST, 'marca');

    // echo "$id<br>$descricao<br>$tipo<br>$marca<br>";

    $atualiza = $db->prepare("UPDATE brindes SET descricao = :descricao, tipo = :tipo, marca = :marca WHERE idbrindes = :id");
    $atualiza->bindValue(':descricao', $descricao);
    $atualiza->bindValue(':tipo', $tipo);
    $atualiza->bindValue(':marca', $marca);
    $atualiza->bindValue(':id', $id);

    if($atualiza->execute()){
        echo "<script> alert('Atualizado com Sucesso!')</script>";
        echo "<script> window.location.href='brindes.php' </script>";
    }else{
        print_r($atualiza->errorInfo());
    }

}else{
    echo "<script> alert('Acesso não permitido!')</script>";
    echo "<script> window.location.href='colaboradores.php' </script>";
}

?>