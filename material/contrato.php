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
    $sql = $db->prepare("SELECT * FROM solicitacao_saida_material LEFT JOIN material ON solicitacao_saida_material.material = material.idmaterial LEFT JOIN industrias ON material.industria = industrias.idindustrias WHERE idsolicitacao = :id");
    $sql->bindValue(':id', $idSolicitacao);
    if($sql->execute()){
        $dadosSolic = $sql->fetch();
        $pedido = $dadosSolic['pedido'];
        $qtdMaterial = $dadosSolic['qtd'];
        $material = $dadosSolic['descricao'];
        $fornecedor  = $dadosSolic['fantasia'];

        //consulta winthor
        $wint = $dbora->prepare("SELECT pcclient.codcli, pcclient.cliente, pcclient.municent, pcpedc.codusur, pcusuari.nome, pcclient.cgcent, pcclient.bairroent, pcclient.enderent FROM friobom.pcpedc LEFT JOIN friobom.pcclient ON pcpedc.codcli = pcclient.codcli LEFT JOIN friobom.PCUSUARI ON pcpedc.codusur = pcusuari.codusur where numped = :pedido");
        $wint->bindValue(':pedido', $pedido);
        if($wint->execute()){
            $dadosWint = $wint->fetch();
            
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
            <p style='text-align:justify '>Pelo presente instrumento particular de contrato de acordo comercial que entre si fazem de um lado a empresa BASTO MESQUITA DISTRIBUIÇÃO E LOGISTICA LTDA, estabelecida à Rodovia BR 316 KM 357 – Rui Barbosa – Bacabal - MA, inscrita no CNPJ sob n° 12.464.051/0001-53, aqui denominada Fornecedora, e do outro lado Cliente. <br> <span style='font-weight:bold'> RCA: $dadosWint[CODUSUR], ". utf8_encode($dadosWint['NOME']) ."  <br> CIDADE: ". utf8_encode($dadosWint['MUNICENT'])."-MA <br> </span> A FORNECEDORA entregou ao <span style='font-weight:bold'> ". utf8_encode($dadosWint['CLIENTE']) . " </span> CNPJ/CPF: <span style='font-weight:bold'> $dadosWint[CGCENT], ". utf8_encode($dadosWint['ENDERENT']).", BAIRRO: ". utf8_encode($dadosWint['BAIRROENT']).", </span> em $dataAtual, <span style='font-weight:bold'> $qtdMaterial – ". utf8_encode($material) .". </span>  </p>

            <p>CLÁUSULA PRIMEIRA – Se compromete a conservação do material até o dia troca de atualização ou AÇÃO.</p>
            <p>CLÁUSULA SEGUNDA – O EXPOSITOR é de uso exclusivo dos produtos ". utf8_encode($fornecedor) .", não podendo armazenar/expor outros produtos no mesmo.</p>
            <p>CLÁUSULA TERCEIRA – O não cumprimento do acordo implica na devolução para a fornecedora do objeto mencionado neste contrato.</p>
            <p>Fica eleito o foro da comarca de Bacabal, Estado do Maranhão, para discussão dos termos do presente contrato.</p>
            <p style='text-align:justify '>E por estarem assim justos e contratados FORNECEDORA E CLIENTE ,  firmam o presente instrumento, em uma via de igual forma e teor, perante testemunhas que com elas subscrevem abaixo, para que produza todos os seus efeitos e direito.</p>
            <p style='text-align:right '>Bacabal – MA $dataExtenso.</p>
            <p style='border-top: solid 1px #000; width:75%; text-align:center; margin-top:50px; margin-left:auto; margin-right:auto'> <span style='font-weight:bold'> ". utf8_encode($dadosWint['CLIENTE']). " <br> CÓD: $dadosWint[CODCLI] </span> </p>
        </div>
    </div>
</body>
</html>
    ");
    $mpdf->Output();

?>