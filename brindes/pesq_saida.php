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
	$searchQuery = " AND (descricao LIKE :descricao OR marca LIKE :marca OR tipo LIKE :tipo OR cliente LIKE :cliente OR rca LIKE :rca OR obs LIKE :obs ) ";
    $searchArray = array(
        'descricao'=>"%$searchValue%",
        'marca'=>"%$searchValue%",
        'tipo'=>"%$searchValue%",
        'cliente'=>"%$searchValue%",
        'rca'=>"%$searchValue%",
        'obs'=>"%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM brindes_saida  LEFT JOIN brindes ON brindes_saida.brinde = brindes.idbrindes LEFT JOIN usuarios ON brindes_saida.usuario = usuarios.idusuarios");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM brindes_saida  LEFT JOIN brindes ON brindes_saida.brinde = brindes.idbrindes LEFT JOIN usuarios ON brindes_saida.usuario = usuarios.idusuarios WHERE 1".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $db->prepare("SELECT * FROM brindes_saida  LEFT JOIN brindes ON brindes_saida.brinde = brindes.idbrindes LEFT JOIN usuarios ON brindes_saida.usuario = usuarios.idusuarios WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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
            "idbrindes_saida"=>$row['idbrindes_saida'],
            "data_saida"=>date("d/m/Y", strtotime($row['data_saida'])),
            "brinde"=>$row['descricao'],
            "tipo"=>$row['tipo'],
            "marca"=>$row['marca'],
            "qtd"=>$row['qtd'],
            "cliente"=>$row['cliente'],
            "cidade"=>$row['cidade'],
            "rca"=>$row['rca'],
            "obs"=>$row['obs'],
            "usuario"=>$row['nome'],
            "acoes"=> '<a href="javascript:void();" data-id="'.$row['idbrindes_saida'].'"  class="btn btn-info btn-sm editbtn" >Editar</a>  <a href="excluir-saida.php?id='.$row['idbrindes_saida'].' " data-id="'.$row['idbrindes_saida'].'"  class="btn btn-danger btn-sm deleteBtn" >Excluir</a>'
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
