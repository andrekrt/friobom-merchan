<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false){

    $codigo = filter_input(INPUT_POST, 'cod');
    $razao = filter_input(INPUT_POST, 'razao');
    $fantasia = filter_input(INPUT_POST, 'fantasia');

    //echo "$id<br>$fornecedor<br>$departamento<br>$tipoVolume<br>$valorVolume";

    $atualiza = $db->prepare("UPDATE industrias SET razao = :razao, fantasia = :fantasia WHERE idindustrias = :codigo");
    $atualiza->bindValue(':razao', $razao);
    $atualiza->bindValue(':fantasia', $fantasia);
    $atualiza->bindValue(':codigo', $codigo);

    if($atualiza->execute()){
        echo "<script> alert('Atualizado com Sucesso!')</script>";
        echo "<script> window.location.href='fornecedores.php' </script>";
    }else{
        print_r($atualiza->errorInfo());
    }

}else{
    echo "<script> alert('Acesso não permitido!')</script>";
    echo "<script> window.location.href='colaboradores.php' </script>";
}

?>