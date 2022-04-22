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
	$searchQuery = " AND (descricao LIKE :descricao OR tipo LIKE :tipo OR industria LIKE :industria OR usuario LIKE :usuario) ";
    $searchArray = array(
        'descricao'=>"%$searchValue%",
        'tipo'=>"%$searchValue%",
        'industria'=>"%$searchValue%",
        'usuario'=>"%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM material ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM material WHERE 1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $db->prepare("SELECT * FROM material LEFT JOIN industrias ON material.industria = industrias.idindustrias LEFT JOIN usuarios ON material.usuario = usuarios.idusuarios  WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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
    $data[] = array(
            "idmaterial"=>$row['idmaterial'],
            "descricao"=>strtoupper($row['descricao']),
            "tipo"=>strtoupper($row['tipo']),
            "industria"=>strtoupper($row['fantasia']),
            "estoque_minimo"=>$row['estoque_minimo'],
            "total_entrada"=>$row['total_entrada'],
            "total_saida"=>$row['total_saida'],
            "total_estoque"=>$row['total_estoque'],
            "status"=>$row['situacao'],
            "usuario"=>$row['nome'],
            "acoes"=> '<a href="javascript:void();" data-id="'.$row['idmaterial'].'"  class="btn btn-info btn-sm editbtn" >Visualizar</a>  '
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
