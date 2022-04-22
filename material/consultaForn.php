<?php

include_once "../conexao.php";

$material = filter_input(INPUT_GET, 'codMaterial');

if(!empty($material)){
    $limite =1;
    
    $resultado =$db->prepare("SELECT * FROM material LEFT JOIN industrias ON material.industria = industrias.idindustrias WHERE idmaterial = :material");
    $resultado->bindValue(':material', $material);
    $resultado->execute();


    $valores = array();

    if($resultado->rowCount() != 0){
        $fornecedor = $resultado->fetch(PDO::FETCH_ASSOC);
        $valores['fornecedor'] = $fornecedor['industria'] . " - " . $fornecedor['fantasia'];
        
    }else{
        $valores['fornecedor']="Não Encontrado";
    }

    echo json_encode($valores);
}

?>