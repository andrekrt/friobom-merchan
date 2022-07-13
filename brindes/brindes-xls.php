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

                $arquivo = 'brindes.xls';
                $html = '';
                $html .= '<table border="1">';
                $html .= '<tr>';
                $html .= '<td class="text-center font-weight-bold"> Código  </td>';
                $html .= '<td class="text-center font-weight-bold"> Descrição </td>';
                $html .= '<td class="text-center font-weight-bold"> Marca </td>';
                $html .= '<td class="text-center font-weight-bold">Tipo</td>';
                $html .= '<td class="text-center font-weight-bold"> Total de Entrada </td>';
                $html .= '<td class="text-center font-weight-bold">Total de Saídas</td>';
                $html .= '<td class="text-center font-weight-bold"> Estoque Atual </td>';
                $html .= '<td class="text-center font-weight-bold"> Cadastrado por </td>';
                $html .= '</tr>';

                $sql = $db->query("SELECT * FROM brindes LEFT JOIN usuarios ON brindes.usuario = usuarios.idusuarios");
                $dados = $sql->fetchAll();
                foreach($dados as $dado){

                    $html .= '<tr>';
                    $html .= '<td>'.$dado['idbrindes']. '</td>';
                    $html .= '<td>'. $dado['descricao'] . '</td>';
                    $html .= '<td>'. $dado['marca'] . '</td>';
                    $html .= '<td>'. $dado['tipo'] .'</td>';
                    $html .= '<td>'. $dado['total_entrada']. '</td>';
                    $html .= '<td>'.$dado['total_saida'] . '</td>';
                    $html .= '<td>'.$dado['total_estoque'] . '</td>';
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