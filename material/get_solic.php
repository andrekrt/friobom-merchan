<?php include('../conexao.php');
$id = $_POST['id'];
$sql = "SELECT * FROM solicitacao_saida_material LEFT JOIN material ON solicitacao_saida_material.material = material.idmaterial LEFT JOIN industrias ON material.industria = industrias.idindustrias WHERE idsolicitacao='$id' LIMIT 1";
$query = $db->query($sql);
$row = $query->fetch(PDO::FETCH_ASSOC);
echo json_encode($row);
?>
