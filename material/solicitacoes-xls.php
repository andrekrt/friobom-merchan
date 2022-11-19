<?php

session_start();
require("../conexao.php");

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Planilha</title>
    </head>
    <body>
        <?php
        
            if($_SESSION['idusuario']){

                $arquivo = 'saidas.xls';
                $html = '';
                $html .= '<table border="1">';
                $html .= '<tr>';
                $html .= '<td class="text-center font-weight-bold"> Código  </td>';
                $html .= '<td class="text-center font-weight-bold"> Data Solicitação  </td>';
                $html .= '<td class="text-center font-weight-bold"> Material </td>';
                $html .= '<td class="text-center font-weight-bold"> Qtd de Material </td>';
                $html .= '<td class="text-center font-weight-bold"> Código Indústria </td>';
                $html .= '<td class="text-center font-weight-bold">Indústria</td>';
                $html .= '<td class="text-center font-weight-bold"> Pedido </td>';
                $html .= '<td class="text-center font-weight-bold"> Código Cliente </td>';
                $html .= '<td class="text-center font-weight-bold"> Nome Cliente </td>';
                $html .= '<td class="text-center font-weight-bold"> Nº Itens </td>';
                $html .= '<td class="text-center font-weight-bold"> Valor Total </td>';
                $html .= '<td class="text-center font-weight-bold"> Status </td>';
                $html .= '<td class="text-center font-weight-bold"> Data de Respota </td>';
                $html .= '<td class="text-center font-weight-bold"> Motivo de Recusa </td>';
                $html .= '<td class="text-center font-weight-bold"> Data de Recebimento </td>';
                $html .= '<td class="text-center font-weight-bold"> Solicitante </td>';
                $html .= '</tr>';

                $sql = $db->query("SELECT * FROM solicitacao_saida_material LEFT JOIN material ON solicitacao_saida_material.material = material.idmaterial LEFT JOIN industrias ON material.industria = industrias.idindustrias LEFT JOIN usuarios ON solicitacao_saida_material.solicitante = usuarios.idusuarios");
                $dados = $sql->fetchAll();
                foreach($dados as $dado){
                    $cliente = explode("-",$dado['cliente']);
            
                    $html .= '<tr>';
                    $html .= '<td>'.$dado['idsolicitacao']. '</td>';
                    $html .= '<td>'. date("d/m/Y H:i", strtotime($dado['data_solicitacao']))  . '</td>';
                    $html .= '<td>'. $dado['descricao'] . '</td>';
                    $html .= '<td>'. $dado['qtd'] . '</td>';
                    $html .= '<td>'. $dado['idindustrias'] . '</td>';
                    $html .= '<td>'. $dado['fantasia'] .'</td>';
                    $html .= '<td>'. $dado['pedido']. '</td>';
                    $html .= '<td>'.$cliente['0'] . '</td>';
                    $html .= '<td>'.$cliente['1'] . '</td>';
                    $html .= '<td>'. $dado['num_itens']. '</td>';
                    $html .= '<td>'. "R$ ".number_format($dado['num_itens'],"2",",","."). '</td>';
                    $html .= '<td>'.$dado['status_solic'] . '</td>';
                    $html .= '<td>'.date("d/m/Y H:i", strtotime($dado['data_resposta'])) . '</td>';
                    $html .= '<td>'.$dado['obs'] . '</td>';
                    $html .= '<td>'.date("d/m/Y H:i", strtotime($dado['data_recebimento'])) . '</td>';
                    $html .= '<td>'.$dado['nome'] . '</td>';
                    $html .= '</tr>';

                }

                $html .= '</table>';

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'.$arquivo.'"');
                header('Cache-Control: max-age=0');
                header('Cache-Control: max-age=1');

                echo $html;

            }
        
        ?>
    </body>
</html>