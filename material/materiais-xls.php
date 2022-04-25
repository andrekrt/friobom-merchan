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

                $arquivo = 'materiais.xls';
                $html = '';
                $html .= '<table border="1">';
                $html .= '<tr>';
                $html .= '<td class="text-center font-weight-bold"> Código  </td>';
                $html .= '<td class="text-center font-weight-bold"> Descrição </td>';
                $html .= '<td class="text-center font-weight-bold"> Tipo </td>';
                $html .= '<td class="text-center font-weight-bold">Estoque Mínimo</td>';
                $html .= '<td class="text-center font-weight-bold"> Total de Entrada </td>';
                $html .= '<td class="text-center font-weight-bold">Total de Saídas</td>';
                $html .= '<td class="text-center font-weight-bold"> Estoque Atual </td>';
                $html .= '<td class="text-center font-weight-bold"> Situação </td>';
                $html .= '<td class="text-center font-weight-bold"> Indústria </td>';
                $html .= '<td class="text-center font-weight-bold"> Lançado </td>';
                $html .= '</tr>';

                $sql = $db->query("SELECT * FROM material LEFT JOIN industrias ON material.industria = industrias.idindustrias LEFT JOIN usuarios ON material.usuario = usuarios.idusuarios");
                $dados = $sql->fetchAll();
                foreach($dados as $dado){

                    $html .= '<tr>';
                    $html .= '<td>'.$dado['idmaterial']. '</td>';
                    $html .= '<td>'. $dado['descricao'] . '</td>';
                    $html .= '<td>'. $dado['tipo'] . '</td>';
                    $html .= '<td>'. $dado['estoque_minimo'] .'</td>';
                    $html .= '<td>'. $dado['total_entrada']. '</td>';
                    $html .= '<td>'.$dado['total_saida'] . '</td>';
                    $html .= '<td>'.$dado['total_estoque'] . '</td>';
                    $html .= '<td>'.$dado['situacao'] . '</td>';
                    $html .= '<td>'.$dado['fantasia'] . '</td>';
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