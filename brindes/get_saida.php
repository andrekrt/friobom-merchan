<?php include('../conexao.php');
$id = $_POST['id'];
$sql = "SELECT * FROM brindes_saida  LEFT JOIN brindes ON brindes_saida.brinde = brindes.idbrindes LEFT JOIN usuarios ON brindes_saida.usuario = usuarios.idusuarios WHERE idbrindes_saida='$id' LIMIT 1";
$query = $db->query($sql);
$row = $query->fetch(PDO::FETCH_ASSOC);
echo json_encode($row);
?>
