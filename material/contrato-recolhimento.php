<?php
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
session_start();
use Mpdf\Mpdf;
require_once __DIR__ . '/../vendor/autoload.php';
require("../conexao.php");
require("../conexao-oracle.php");
$tipousuario = $_SESSION['tipoUsuario'];

    $idSolicitacao = filter_input(INPUT_GET, 'id');
    $dataAtual = date('d/m/Y');
    $dataExtenso=utf8_encode(strftime('%d de %B de %Y', strtotime(date('Y-m-d')))) ;

    //consulta mysql
    $sql = $db->prepare("SELECT * FROM saidas LEFT JOIN material ON saidas.material = material.idmaterial WHERE idsaidas = :id");
    $sql->bindValue(':id', $idSolicitacao);
    if($sql->execute()){
        $dadosSolic = $sql->fetch();
        $material = $dadosSolic['descricao'];
        $cliente = $dadosSolic['cliente'];
        $pos = strpos($cliente, "-")?strpos($cliente, "-"):strlen($cliente);
        $cod = substr($cliente, 0, $pos);
        
        //consulta winthor
        $wint = $dbora->prepare("SELECT CODCLI, CLIENTE, ENDERENT, BAIRROENT, MUNICENT, CGCENT FROM FRIOBOM.PCCLIENT where CODCLI = :CODCLI");
        $wint->bindValue(':CODCLI', $cod);
        if($wint->execute()){
            $dadosWint = $wint->fetch();
            $nomeCliente = $dadosWint['CLIENTE'];
            $codCliente = $dadosWint['CODCLI'];
            $rua = $dadosWint['ENDERENT'];
            $bairro = $dadosWint['BAIRROENT'];
            $cidade =  $dadosWint['MUNICENT'];
            $cnpj = $dadosWint['CGCENT'];
            
        }else{
            print_r($wint->errorInfo());
        }

    }else{
        print_r($sql->errorInfo());
    }

    $mpdf = new Mpdf();
    $mpdf->AddPage();
    $mpdf->WriteHTML("
    <!DOCTYPE html>
<html lang='pt-bt'>
<head>
    
</head>
<body>
    <div style='display: flex; flex-direction: column; '>        
        <div style='width: 50%; margin:auto'>
            <img style='width: 300px; ' src='../assets/images/logo.png'> 
        </div>
        <div style='width: 100%; '>
            <h3 style='text-align:center'>CONTRATO DE MATERIAL DE APOIO EM MERCHANDISING</h3>
            <p style='text-align:justify '>Pelo presente instrumento particular de contrato de acordo comercial que entre si fazem de um lado a empresa BASTO MESQUITA DISTRIBUIÇÃO E LOGISTICA LTDA, estabelecida à Rodovia BR 316 KM 357 – Rui Barbosa – Bacabal - MA, inscrita no CNPJ sob n° 12.464.051/0001-53, aqui denominada Fornecedora. </p>
            <p>A FORNECEDORA FRIOBOM esta solicitando o recolhimento do <span style='font-weight:bold'> $material </span>, do cliente <span style='font-weight:bold'> $cliente </span> CNPJ/CPF: <span style='font-weight:bold'> $cnpj </span>, <span style='font-weight:bold'> $rua </span>, BAIRRO: <span style='font-weight:bold'> $bairro </span>, CIDADE: <span style='font-weight:bold'> $cidade </span>  em $dataAtual.</p>
            <p>CLÁUSULA PRIMEIRA – o cliente se compromete em entregar o expositor mencionado acima em perfeitas condições de uso.</p>
            <p>Fica eleito o foro da comarca de Bacabal, Estado do Maranhão, para discussão dos termos do presente contrato.</p>
            <p style='text-align:justify '>E por estarem assim justos e contratados FORNECEDORA E CLIENTE,  firmam o presente instrumento, em uma via de igual forma e teor, perante testemunhas que com elas subscrevem abaixo, para que produza todos os seus efeitos e direito.</p>
            <p style='text-align:right '>Bacabal – MA $dataExtenso.</p>
            <p style='border-top: solid 1px #000; width:75%; text-align:center; margin-top:50px; margin-left:auto; margin-right:auto'> <span style='font-weight:bold'> ". utf8_encode($dadosWint['CLIENTE']). " <br> CÓD: $dadosWint[CODCLI] </span> </p>
        </div>
    </div>
</body>
</html>
    ");
    $mpdf->Output();

?>