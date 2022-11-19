<?php

session_start();
require("conexao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false){

    $idUsuario = $_SESSION['idusuario'];
    $nomeUsuario = $_SESSION['nome'];

    //total de entradas de materiais
    $entradas = $db->query("SELECT SUM(qtd) as total FROM entradas");
    $entradas = $entradas->fetch();
    $totalEntradas = $entradas['total'];

    //total de saidas materiais
    $saidas = $db->query("SELECT SUM(qtd) as total FROM saidas");
    $saidas = $saidas->fetch();
    $totalSaidas = $saidas['total'];

    //estoque atual materiais
    $estoque = $totalEntradas-$totalSaidas;

    //total de entradas de brindes
    $entradasBrindes = $db->query("SELECT SUM(qtd) as total FROM brindes_entrada");
    $entradasBrindes = $entradasBrindes->fetch();
    $totalEntradasBrindes = $entradasBrindes['total'];

    //total de saidas de brindes
    $saidasBrindes = $db->query("SELECT SUM(qtd) as total FROM brindes_saida");
    $saidasBrindes = $saidasBrindes->fetch();
    $totalSaidasBrindes = $saidasBrindes['total'];

    //estoque atual materiais
    $estoqueBrindes = $totalEntradasBrindes-$totalSaidasBrindes;

}else{
    header("Location:login.php");
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Friobom - Merchandising</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
        <link rel="manifest" href="assets/favicon/site.webmanifest">
        <link rel="mask-icon" href="assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
    </head>
    <body>
        <div class="container-fluid corpo">
            <div class="menu-lateral" id="menu-lateral">
                <div class="logo">  
                    <img src="assets/images/logo.png" alt="">
                </div>
                <div class="opcoes" >
                    <div class="item">
                        <a href="index.php">
                            <img src="assets/images/menu/inicio.png" alt="">
                        </a>
                    </div>
                    <div class="item">
                        <a class="" onclick="menuDescarga()">
                            <img src="assets/images/menu/material.png" alt="">
                        </a>
                        <nav id="submenuDescarga">
                            <ul class="nav flex-column">
                                <li class="nav-item"> <a class="nav-link" href="material/materiais.php"> Materiais </a> </li>  
                                <li class="nav-item"> <a class="nav-link" href="material/entradas.php">Entradas </a> </li>
                                <li class="nav-item"> <a class="nav-link" href="material/saidas.php">Saídas </a> </li>
                                <li class="nav-item"> <a class="nav-link" href="material/solicitacao-saida.php">Solicitaçõs de Saída </a> </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="item">
                        <a class="" onclick="menuBrinde()">
                            <img src="assets/images/menu/menu-brinde.png" alt="">
                        </a>
                        <nav id="submenuBrinde">
                            <ul class="nav flex-column">
                                <li class="nav-item"> <a class="nav-link" href="brindes/brindes.php"> Brindes </a> </li>  
                                <li class="nav-item"> <a class="nav-link" href="brindes/entradas.php">Entradas </a> </li>
                                <li class="nav-item"> <a class="nav-link" href="brindes/saidas.php">Saídas </a> </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="item">
                        <a onclick="menuFornecedor()">
                            <img src="assets/images/menu/menu-fornecedor.png" >
                        </a>
                        <nav id="submenuFornecedor">
                            <ul class="nav flex-column">
                                <li class="nav-item"> <a class="nav-link" href="fornecedores/form-fornecedor.php">Cadastrar Fornecedor</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="fornecedores/fornecedores.php">Listar Fornecedores</a> </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="item">
                        <a onclick="menuUsuario()">
                            <img src="assets/images/menu/usuarios.png">
                        </a>
                        <nav id="submenuUsuario">
                            <ul class="nav flex-column">
                                <li class="nav-item"> <a class="nav-link" href="usuarios/form-usuario.php"> Cadastrar Usuário </a> </li>
                            </ul> 
                        </nav> 
                    </div>
                    <div class="item">
                        <a href="sair.php">
                            <img src="assets/images/menu/sair.png" alt="">
                        </a>
                    </div>
                </div>                
            </div>
            <!-- Tela com os dados -->
            <div class="tela-principal">
                <div class="menu-superior">
                   <div class="icone-menu-superior">
                        <img src="assets/images/icones/home.png" alt="">
                   </div>
                   <div class="title">
                        <h2>Bem-Vindo <?= ($nomeUsuario) ?></h2>
                   </div>
                   <div class="menu-mobile">
                        <img src="assets/images/icones/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                   </div>
                </div>
                <div class="menu-principal">
                    <div class="area-indice-val">
                        <div class="indice-ind">
                            <div class="indice-ind-tittle">
                                <p>Entradas de Materiais</p>
                            </div>
                            <div class="indice-qtde">
                                <img src="assets/images/icones/entrada-material.png" alt="">
                                <p class="qtde">  <?= $totalEntradas ?> </p>
                            </div>
                        </div>
                        <div class="indice-ind">
                            <div class="indice-ind-tittle">
                                <p>Saídas de Materiais</p>
                            </div>
                            <div class="indice-qtde">
                                <img src="assets/images/icones/saida-material.png" alt="">
                                <p class="qtde"> <?= $totalSaidas ?> </p>
                            </div>
                        </div>
                        <div class="indice-ind">
                            <div class="indice-ind-tittle">
                                <p>Estoque de Materiais</p>
                            </div>
                            <div class="indice-qtde">
                                <img src="assets/images/icones/estoque-material.png" alt="">
                                <p class="qtde"> <?=$estoque?> </p>
                            </div>
                        </div>
                        <div class="indice-ind">
                            <div class="indice-ind-tittle">
                                <p>Entradas de Brindes</p>
                            </div>
                            <div class="indice-qtde">
                                <img src="assets/images/icones/entrada-brinde.png" alt="">
                                <p class="qtde">  <?= $totalEntradasBrindes ?> </p>
                            </div>
                        </div>
                        <div class="indice-ind">
                            <div class="indice-ind-tittle">
                                <p>Saídas de Brindes</p>
                            </div>
                            <div class="indice-qtde">
                                <img src="assets/images/icones/saida-brinde.png" alt="">
                                <p class="qtde"> <?= $totalSaidasBrindes ?> </p>
                            </div>
                        </div>
                        <div class="indice-ind">
                            <div class="indice-ind-tittle">
                                <p>Estoque de Brindes</p>
                            </div>
                            <div class="indice-qtde">
                                <img src="assets/images/icones/estoque-brinde.png" alt="">
                                <p class="qtde"> <?=$estoqueBrindes?> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/menu.js"></script>
    </body>
</html>