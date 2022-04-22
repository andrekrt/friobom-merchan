<?php include('../conexao.php');
$id = $_POST['id'];
$sql = "SELECT * FROM entradas LEFT JOIN material ON entradas.material = material.idmaterial LEFT JOIN industrias ON entradas.industria = industrias.idindustrias WHERE identradas='$id' LIMIT 1";
$query = $db->query($sql);
$row = $query->fetch(PDO::FETCH_ASSOC);
echo json_encode($row);
?>
