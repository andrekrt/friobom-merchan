<?php include('../conexao.php');
$id = $_POST['id'];
$sql = "SELECT * FROM brindes_entrada LEFT JOIN brindes ON brindes_entrada.brinde = brindes.idbrindes WHERE idbrindes_entrada='$id' LIMIT 1";
$query = $db->query($sql);
$row = $query->fetch(PDO::FETCH_ASSOC);
echo json_encode($row);
?>
