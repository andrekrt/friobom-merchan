<?php

session_start();
require("../conexao.php");
require("funcao.php");

$id = filter_input(INPUT_GET, 'id');

if(isset($id) && empty($id) == false ){ 
    
    $sql = $db->prepare("DELETE FROM solicitacao_saida_material WHERE idsolicitacao = :id");
    $sql->bindValue(':id',$id);
    
    if($sql->execute()){

        echo "<script>alert('Solicitação Excluída!');</script>";
        echo "<script>window.location.href='solicitacao-saida.php'</script>";
    }else{
        print_r($sql->errorInfo());
    }
    
}else{
    header("Location:solicitacao-saida.php");
}

?>