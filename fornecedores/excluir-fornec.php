<?php

session_start();
require("../conexao.php");

$id = filter_input(INPUT_GET, 'id');

if(isset($id) && empty($id) == false ){ 
    
    $sql = $db->prepare("UPDATE industrias SET ativo = :ativo WHERE idindustrias = :id");
    $sql->bindValue(':id',$id);
    $sql->bindValue(':ativo',0);
    
    if($sql->execute()){
        echo "<script>alert('Desativado com Sucesso!');</script>";
        echo "<script>window.location.href='fornecedores.php'</script>";
    }else{
        print_r($sql->errorInfo());
    }
    
}else{
    header("Location:solicitacoes.php");
}

?>