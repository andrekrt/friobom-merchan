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

                $arquivo = 'saida-brindes.xls';
                $html = '';
                $html .= '<table border="1">';
                $html .= '<tr>';
                $html .= '<td class="text-center font-weight-bold"> Código  </td>';
                $html .= '<td class="text-center font-weight-bold"> Data de Saída </td>';
                $html .= '<td class="text-center font-weight-bold"> Brinde </td>';
                $html .= '<td class="text-center font-weight-bold">Tipo</td>';
                $html .= '<td class="text-center font-weight-bold"> Marca </td>';
                $html .= '<td class="text-center font-weight-bold">Qtd</td>';
                $html .= '<td class="text-center font-weight-bold">Cliente</td>';
                $html .= '<td class="text-center font-weight-bold">Cidade</td>';
                $html .= '<td class="text-center font-weight-bold">RCA</td>';
                $html .= '<td class="text-center font-weight-bold">Obs</td>';
                $html .= '<td class="text-center font-weight-bold"> Lançado por </td>';
                $html .= '</tr>';

                $sql = $db->query("SELECT * FROM brindes_saida  LEFT JOIN brindes ON brindes_saida.brinde = brindes.idbrindes LEFT JOIN usuarios ON brindes_saida.usuario = usuarios.idusuarios");
                $dados = $sql->fetchAll();
                foreach($dados as $dado){

                    $html .= '<tr>';
                    $html .= '<td>'.$dado['idbrindes_saida']. '</td>';
                    $html .= '<td>'. date("d/m/Y", strtotime($dado['data_saida'])) . '</td>';
                    $html .= '<td>'. $dado['descricao'] . '</td>';
                    $html .= '<td>'. $dado['tipo'] .'</td>';
                    $html .= '<td>'. $dado['marca']. '</td>';
                    $html .= '<td>'.$dado['qtd'] . '</td>';
                    $html .= '<td>'.$dado['cliente'] . '</td>';
                    $html .= '<td>'.$dado['cidade'] . '</td>';
                    $html .= '<td>'.$dado['rca'] . '</td>';
                    $html .= '<td>'.$dado['obs'] . '</td>';
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