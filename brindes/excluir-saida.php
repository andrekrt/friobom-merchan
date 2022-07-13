<?php

session_start();
require("../conexao.php");
require("funcao.php");

$id = filter_input(INPUT_GET, 'id');

if(isset($id) && empty($id) == false ){ 

    //pegar codigo do material
    $seleciona=$db->prepare("SELECT brinde FROM brindes_saida WHERE idbrindes_saida = :id");
    $seleciona->bindValue(':id', $id);
    $seleciona->execute();
    $brinde = $seleciona->fetch();
    $brinde = $brinde['brinde'];
    
    $sql = $db->prepare("DELETE FROM brindes_saida WHERE idbrindes_saida = :id");
    $sql->bindValue(':id',$id);
    
    if($sql->execute()){
        contaEstoque($brinde);
        echo "<script>alert('Saída Excluída!');</script>";
        echo "<script>window.location.href='saidas.php'</script>";
    }else{
        print_r($sql->errorInfo());
    }
    
}else{
    header("Location:solicitacoes.php");
}

?>