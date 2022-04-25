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
                $html .= '<td class="text-center font-weight-bold"> Data de Saída </td>';
                $html .= '<td class="text-center font-weight-bold"> Material </td>';
                $html .= '<td class="text-center font-weight-bold">Indústria</td>';
                $html .= '<td class="text-center font-weight-bold"> Qtd </td>';
                $html .= '<td class="text-center font-weight-bold"> Cliente </td>';
                $html .= '<td class="text-center font-weight-bold"> Rota </td>';
                $html .= '<td class="text-center font-weight-bold"> Lançado </td>';
                $html .= '</tr>';

                $sql = $db->query("SELECT * FROM saidas LEFT JOIN material ON saidas.material = material.idmaterial LEFT JOIN industrias ON saidas.industria = industrias.idindustrias LEFT JOIN usuarios ON saidas.usuario = usuarios.idusuarios");
                $dados = $sql->fetchAll();
                foreach($dados as $dado){

                    $html .= '<tr>';
                    $html .= '<td>'.$dado['idsaidas']. '</td>';
                    $html .= '<td>'. date("d/m/Y", strtotime($dado['data_saida']))  . '</td>';
                    $html .= '<td>'. $dado['descricao'] . '</td>';
                    $html .= '<td>'. $dado['fantasia'] .'</td>';
                    $html .= '<td>'. $dado['qtd']. '</td>';
                    $html .= '<td>'. $dado['cliente']. '</td>';
                    $html .= '<td>'. $dado['rota']. '</td>';
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