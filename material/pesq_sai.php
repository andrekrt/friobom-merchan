<?php
include '../conexao.php';

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
	$searchQuery = " AND (descricao LIKE :descricao OR nome LIKE :nome OR fantasia LIKE :fantasia OR cliente LIKE :cliente OR rota LIKE :rota) ";
    $searchArray = array(
        'descricao'=>"%$searchValue%",
        'nome'=>"%$searchValue%",
        'fantasia'=>"%$searchValue%",
        'cliente'=>"%$searchValue%",
        'rota'=>"%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM saidas LEFT JOIN material ON saidas.material = material.idmaterial LEFT JOIN industrias ON saidas.industria = industrias.idindustrias");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM saidas LEFT JOIN material ON saidas.material = material.idmaterial LEFT JOIN industrias ON saidas.industria = industrias.idindustrias WHERE 1".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $db->prepare("SELECT * FROM saidas LEFT JOIN material ON saidas.material = material.idmaterial LEFT JOIN industrias ON saidas.industria = industrias.idindustrias LEFT JOIN usuarios ON saidas.usuario = usuarios.idusuarios WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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
    $contrato=""; 
    $recolher="";
    $link = "";
    if($row['tipo']=="Expositor" && $row['status_saida']=="Implementado"){
        $contrato = '<a href="contrato-recolhimento.php?id='.$row['idsaidas'].' " data-id="'.$row['idsaidas'].'"  class="btn btn-secondary btn-sm deleteBtn" >Contrato de Recolhimento</a>';
        $recolher = '  <a href="javascript:void();" data-id="'.$row['idsaidas'].'" id="recolher"  class="btn btn-success btn-sm editbtn" >Recolher</a>';
    }

    if($row['status_saida']=="Recolhido"){
        $link =' <a href="contratos/recolhimentos/'.$row['idsaidas'].'"> Contrato </a>';
    }

    $data[] = array(
            "idsaidas"=>$row['idsaidas'],
            "data_saida"=>date("d/m/Y", strtotime($row['data_saida'])),
            "material"=>$row['descricao'],
            "fornecedor"=>$row['industria']." - " .$row['fantasia'],
            "qtd"=>$row['qtd'],
            "cliente"=>$row['cliente'],
            "rota"=>$row['rota'],
            "promotor"=>$row['promotor'],
            "situacao"=>$row['status_saida'],
            "contrato"=>$link,
            "usuario"=>$row['nome'],
            "acoes"=>$contrato. $recolher
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
