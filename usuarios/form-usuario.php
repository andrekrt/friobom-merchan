<?php 

session_start();
require("../conexao.php");

if(isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario'] == 99)){

    
}else{
    echo "<script>alert('Acesso não permitido');</script>";
    echo "<script>window.location.href='../index.php'</script>";
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Friobom - Merchandising</title>
        <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
        <link rel="manifest" href="../assets/favicon/site.webmanifest">
        <link rel="mask-icon" href="../assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
    </head>
    <body>
        <div class="container-fluid corpo">
            <?php require('../menu-lateral.php') ?>
            <!-- Tela com os dados -->
            <div class="tela-principal">
                <div class="menu-superior">
                    <div class="icone-menu-superior">
                        <img src="../assets/images/icones/icon-usuario.png" alt="">
                    </div>
                    <div class="title">
                        <h2>Cadastrar Usuário</h2>
                    </div>
                    <div class="menu-mobile">
                        <img src="../assets/images/icones/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                    </div>
                </div>
                <!-- dados exclusivo da página-->
                <div class="menu-principal">
                    <form action="add-usuario.php" method="post" >
                        <div id="formulario">
                            <div class="form-row">
                                <div class="form-group col-md-3 espaco ">
                                    <label for="nome">Nome </label>
                                    <input type="text" required name="nome" class="form-control" id="nome">
                                </div>
                                <div class="form-group col-md-3 espaco ">
                                    <label for="cpf"> CPF(Somente Números) </label>
                                    <input type="text" required name="cpf" id="cpf" class="form-control">
                                </div>
                                <div class="form-group col-md-3 espaco ">
                                    <label for="email">E-mail </label>
                                    <input type="email" required name="email" id="email" class="form-control">
                                </div>
                                <div class="form-group col-md-3 espaco ">
                                    <label for="tipo">Tipo de Usuário</label>
                                    <select name="tipo" id="tipo" class="form-control">
                                        <option value=""></option>
                                        <option value="1">Merchandising</option>
                                        <option value="2">Apoio</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 espaco ">
                                    <label for="senha">Senha</label>
                                    <input type="password" required name="senha" id="senha" class="form-control">
                                </div>
                                
                            </div>
                            
                        </div>
                        <button type="submit" class="btn btn-primary"> Cadastrar </button>
                    </form>
                </div>
            </div>
        </div>

        <script src="../assets/js/jquery.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/menu.js"></script>
    </body>
</html>