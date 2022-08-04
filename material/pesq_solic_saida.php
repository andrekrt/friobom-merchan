<?php
include '../conexao.php';
session_start();
$tipoUsuario = $_SESSION['tipoUsuario'];

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

$searchArray = array();

## Search 
$searchQuery = " ";
if($searchValue != ''){
	$searchQuery = " AND (descricao LIKE :descricao OR razao LIKE :razao OR fantasia LIKE :fantasia OR idindustrias LIKE :idindustrias OR pedido LIKE :pedido OR cliente LIKE :cliente OR rota LIKE :rota OR situacao LIKE :situacao OR nome LIKE :nome) ";
    $searchArray = array(
        'descricao'=>"%$searchValue%",
        'razao'=>"%$searchValue%",
        'fantasia'=>"%$searchValue%",
        'idindustrias'=>"%$searchValue%",
        'pedido'=>"%$searchValue%",
        'ciente'=>"%$searchValue%",
        'rota'=>"%$searchValue%",
        'situacao'=>"%$searchValue%",
        'nome'=>"%$searchValue%",
    );
}

## Total number of records without filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM solicitacao_saida_material LEFT JOIN material ON solicitacao_saida_material.material = material.idmaterial LEFT JOIN industrias ON material.industria = industrias.idindustrias LEFT JOIN usuarios ON solicitacao_saida_material.solicitante = usuarios.idusuarios");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM solicitacao_saida_material LEFT JOIN material ON solicitacao_saida_material.material = material.idmaterial LEFT JOIN industrias ON material.industria = industrias.idindustrias LEFT JOIN usuarios ON solicitacao_saida_material.solicitante = usuarios.idusuarios WHERE 1".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $db->prepare("SELECT * FROM solicitacao_saida_material LEFT JOIN material ON solicitacao_saida_material.material = material.idmaterial LEFT JOIN industrias ON material.industria = industrias.idindustrias LEFT JOIN usuarios ON solicitacao_saida_material.solicitante = usuarios.idusuarios WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

// Bind values
foreach($searchArray as $key=>$search){
    $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
}

$stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
$stmt->execute();
$empRecords = $stmt->fetchAll();

$data = array();

foreach($empRecords as $row){
    $btnAprovar = "";
    $btnEdit = "";
    $btnExcluir = "";
    $pdf = "";
    $recusar = "";
    $recebido = "";
    $link = "";
    if(($tipoUsuario==2 ) && $row['status_solic']=="Em Análise"){
        $btnAprovar = ' <a href="add-saida.php?id='.$row['idsolicitacao'].' " data-id="'.$row['idsolicitacao'].'"  class="btn btn-success btn-sm" >Aprovar</a>';
        $recusar = ' <a href="javascript:void();" data-id="'.$row['idsolicitacao'].'"  class="btn btn-danger btn-sm " id="recusa" >Recusar</a>';
    }elseif(($tipoUsuario==1 ) && $row['status_solic']=="Em Análise"){
        $btnExcluir = ' <a href="excluir-solicitacao.php?id='.$row['idsolicitacao'].'  " data-id="'.$row['idsolicitacao'].'"  class="btn btn-danger btn-sm " >Excluir</a>';
        $btnEdit = ' <a href="javascript:void();" data-id="'.$row['idsolicitacao'].'"  class="btn btn-info btn-sm editbtn" >Editar</a>';
    }elseif(($tipoUsuario==1 ) && $row['status_solic']=="Aprovado"){
        $pdf = ' <a href="contrato.php?id='.$row['idsolicitacao'].'" class="btn btn-secondary btn-sm" >Contrato</a>';
        $recebido = ' <a href="javascript:void();" data-id="'.$row['idsolicitacao'].'"  class="btn btn-success btn-sm " id="recebido">Recebido</a>';
    }

    if($row['status_solic']=="Recebido"){
        $link =' <a href="contratos/'.$row['idsolicitacao'].'"> Contrato </a>';
    }
    $data[] = array(
        "idsolicitacao"=>$row['idsolicitacao'],
        "material"=>$row['idmaterial']. " - ". $row['descricao'],
        "qtd"=>$row['qtd'],
        "fornecedor"=>$row['industria']." - " .$row['fantasia'],
        "pedido"=>$row['pedido'],
        "cliente"=>$row['cliente'],
        "rota"=>$row['rota'],
        "num_itens"=>$row['num_itens'],
        "valor"=>"R$ ". str_replace(".",",", $row['valor']) ,
        "situacao"=>$row['status_solic'],
        "obs"=>$row['obs'],
        "link"=>$link,
        "solicitante"=>$row['nome'],
        "acoes"=> $btnAprovar . $recusar . $btnEdit . $btnExcluir . $pdf . $recebido 
    );
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);
