<?php

session_start();
require("../conexao.php");
require("funcao.php");

$id = filter_input(INPUT_GET, 'id');

if(isset($id) && empty($id) == false ){ 

    //pegar codigo do material
    $seleciona=$db->prepare("SELECT material FROM entradas WHERE identradas = :id");
    $seleciona->bindValue(':id', $id);
    $seleciona->execute();
    $material = $seleciona->fetch();
    $material = $material['material'];
    
    $sql = $db->prepare("DELETE FROM entradas WHERE identradas = :id");
    $sql->bindValue(':id',$id);
    
    if($sql->execute()){
        contaEstoque($material);
        echo "<script>alert('Entrada Excluída!');</script>";
        echo "<script>window.location.href='entradas.php'</script>";
    }else{
        print_r($sql->errorInfo());
    }
    
}else{
    header("Location:solicitacoes.php");
}

?>