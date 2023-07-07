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

                $arquivo = 'entradas.xls';
                $html = '';
                $html .= '<table border="1">';
                $html .= '<tr>';
                $html .= '<td class="text-center font-weight-bold"> Código  </td>';
                $html .= '<td class="text-center font-weight-bold"> Data de Recebimento </td>';
                $html .= '<td class="text-center font-weight-bold"> Material </td>';
                $html .= '<td class="text-center font-weight-bold">Indústria</td>';
                $html .= '<td class="text-center font-weight-bold">Valor Unit</td>';
                $html .= '<td class="text-center font-weight-bold"> Qtd </td>';
                $html .= '<td class="text-center font-weight-bold"> Valor Total </td>';
                $html .= '<td class="text-center font-weight-bold"> Lançado </td>';
                $html .= '</tr>';

                $sql = $db->query("SELECT * FROM entradas LEFT JOIN material ON entradas.material = material.idmaterial LEFT JOIN industrias ON entradas.industria = industrias.idindustrias LEFT JOIN usuarios ON entradas.usuario = usuarios.idusuarios");
                $dados = $sql->fetchAll();
                foreach($dados as $dado){

                    $html .= '<tr>';
                    $html .= '<td>'.$dado['identradas']. '</td>';
                    $html .= '<td>'. date("d/m/Y", strtotime($dado['data_recebimento']))  . '</td>';
                    $html .= '<td>'. $dado['descricao'] . '</td>';
                    $html .= '<td>'. $dado['fantasia'] .'</td>';
                    $html .= '<td>'. number_format($dado['valor_unit'],2,",",".") . '</td>';
                    $html .= '<td>'. $dado['qtd']. '</td>';
                    $html .= '<td>'. number_format($dado['valor_total'],2,",",".") . '</td>';
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