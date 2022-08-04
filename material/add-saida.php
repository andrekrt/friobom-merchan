<?php

session_start();
require("../conexao.php");
require("funcao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false && ($_SESSION['tipoUsuario'] == 2 || $_SESSION['tipoUsuario'] == 99)){

    $idSolicitacao = filter_input(INPUT_GET, 'id');
    $dataSaida = date("Y-m-d");
    $usuario = $_SESSION['idusuario'];
    
    $consulta = $db->prepare("SELECT * FROM solicitacao_saida_material LEFT JOIN material ON solicitacao_saida_material.material = material.idmaterial LEFT JOIN industrias ON material.industria = industrias.idindustrias LEFT JOIN usuarios ON solicitacao_saida_material.solicitante = usuarios.idusuarios  WHERE idsolicitacao = :id");
    $consulta->bindValue(':id', $idSolicitacao);
    $consulta->execute();
    $dadosSolic = $consulta->fetch();

    //echo "$usuario<br>$material<br>$fornecedor<br>$saida<br>$qtd<br>$cliente<br>$rota";

    $sql = $db->prepare("INSERT INTO saidas (data_saida, material, industria,  qtd, cliente, rota, usuario) VALUES (:saida, :material, :industria, :qtd, :cliente, :rota, :usuario)");
    $sql->bindValue(':saida', $dataSaida);
    $sql->bindValue(':material', $dadosSolic['material']);
    $sql->bindValue(':industria', $dadosSolic['industria']);
    $sql->bindValue(':qtd', $dadosSolic['qtd']);
    $sql->bindValue(':cliente', $dadosSolic['cliente']);
    $sql->bindValue(':rota', $dadosSolic['rota']);
    $sql->bindValue(':usuario', $usuario);
    
    if($sql->execute()){
        contaEstoque($dadosSolic['material']);
        $atualiza = $db->prepare("UPDATE solicitacao_saida_material SET status_solic = :situacao WHERE idsolicitacao = :id");
        $atualiza->bindValue(':situacao', 'Aprovado');
        $atualiza->bindValue(':id', $idSolicitacao);
        if($atualiza->execute()){
            echo "<script> alert('Saida Lançada!!!')</script>";
            echo "<script> window.location.href='solicitacao-saida.php' </script>";
        }else{
            print_r($atualiza->errorInfo());
        }
        
    }else{
        print_r($sql->errorInfo());
    }

    
}else{
    echo "<script> alert('Acesso não permitido')</script>";
    echo "<script> window.location.href='index.php' </script>";
}

?>