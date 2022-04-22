<?php

include_once '../conexao-oracle.php';

$cod = filter_input(INPUT_GET, 'cod');

if(!empty($cod)){
    $limite =1;
    
    $resultado =$dbora->prepare("SELECT * FROM FRIOBOM.PCFORNEC WHERE CODFORNEC = :fornecedor");
    $resultado->bindValue(':fornecedor', $cod);
    $resultado->execute();

    $qtd =$dbora->prepare("SELECT COUNT(*) FROM FRIOBOM.PCFORNEC WHERE CODFORNEC = :fornecedor");
    $qtd->bindValue(':fornecedor', $cod);
    $qtd->execute();
    $qtd = $qtd->fetchColumn();

    if($qtd!=0){
        $fornecedor = $resultado->fetch(PDO::FETCH_ASSOC);
        $valores['FANTASIA'] = $fornecedor['FANTASIA'];
        $valores['FORNECEDOR'] = $fornecedor['FORNECEDOR'];
        
    }else{
        $valores['FANTASIA']="Não Encontrado";
        $valores['FORNECEDOR']="Não Encontrado";
    }

    echo json_encode($valores);
}

?>