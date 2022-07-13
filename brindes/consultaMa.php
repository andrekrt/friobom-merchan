<?php

include_once "../conexao.php";

$brinde = filter_input(INPUT_GET, 'codBrinde');

if(!empty($brinde)){
    $limite =1;
    
    $resultado =$db->prepare("SELECT * FROM brindes WHERE idbrindes = :brinde");
    $resultado->bindValue(':brinde', $brinde);
    $resultado->execute();


    $valores = array();

    if($resultado->rowCount() != 0){
        $marca = $resultado->fetch(PDO::FETCH_ASSOC);
        $valores['marca'] = $marca['marca'] ;
        
    }else{
        $valores['marca']="Não Encontrado";
    }

    echo json_encode($valores);
}

?>