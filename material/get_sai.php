<?php include('../conexao.php');
$id = $_POST['id'];
$sql = "SELECT * FROM saidas LEFT JOIN material ON saidas.material = material.idmaterial LEFT JOIN industrias ON saidas.industria = industrias.idindustrias WHERE idsaidas='$id' LIMIT 1";
$query = $db->query($sql);
$row = $query->fetch(PDO::FETCH_ASSOC);
echo json_encode($row);
?>
