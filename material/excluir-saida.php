<?php

session_start();
require("../conexao.php");
require("funcao.php");

$id = filter_input(INPUT_GET, 'id');

if(isset($id) && empty($id) == false ){ 

    //pegar codigo do material
    $seleciona=$db->prepare("SELECT material FROM saidas WHERE idsaidas = :id");
    $seleciona->bindValue(':id', $id);
    $seleciona->execute();
    $material = $seleciona->fetch();
    $material = $material['material'];
    
    $sql = $db->prepare("DELETE FROM saidas WHERE idsaidas = :id");
    $sql->bindValue(':id',$id);
    
    if($sql->execute()){
        contaEstoque($material);
        echo "<script>alert('Saída Excluída!');</script>";
        echo "<script>window.location.href='saidas.php'</script>";
    }else{
        print_r($sql->errorInfo());
    }
    
}else{
    header("Location:solicitacoes.php");
}

?>