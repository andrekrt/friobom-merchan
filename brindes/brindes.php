<?php

session_start();
require("../conexao.php");

if (isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario'] == 99)) {
    
} else {
    echo "<script>alert('Acesso não permitido');</script>";
    echo "<script>window.location.href='../index.php'</script>";
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
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

    <!-- arquivos para datatable -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/af-2.3.7/date-1.1.0/r-2.2.9/rg-1.1.3/sc-2.0.4/sp-1.3.0/datatables.min.css"/>    

</head>
<body>
    <div class="container-fluid corpo">
        <?php require('../menu-lateral.php') ?>
        <!-- Tela com os dados -->
        <div class="tela-principal">
            <div class="menu-superior">
                <div class="icone-menu-superior">
                    <img src="../assets/images/icones/Icon-brinde.png" alt="">
                </div>
                <div class="title">
                    <h2>Brindes</h2>
                </div>
                <div class="menu-mobile">
                    <img src="../assets/images/icones/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                </div>
            </div>
            <!-- dados exclusivo da página-->
            <div class="menu-principal">
                <div class="icon-exp">
                    <div class="area-opcoes-button">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalCadastrar" data-whatever="@mdo" name="idpeca">Novo Brinde</button>
                    </div>
                    <a href="brindes-xls.php" ><img src="../assets/images/excel.jpg" alt=""></a>    
                </div>
                <div class="table-responsive">
                    <table id='brindes' class='table table-striped table-bordered nowrap text-center' style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center text-nowrap" > Código </th>
                                <th scope="col" class="text-center text-nowrap" > Descrição </th>
                                <th scope="col" class="text-center text-nowrap">Marca</th>
                                <th scope="col" class="text-center text-nowrap">Tipo</th>
                                <th scope="col" class="text-center text-nowrap">Total de Entradas</th>
                                <th scope="col" class="text-center text-nowrap">Total de Saídas</th>
                                <th scope="col" class="text-center text-nowrap">Estoque Atual</th>
                                <th scope="col" class="text-center text-nowrap">Cadastrado por</th>
                                <th scope="col" class="text-center text-nowrap"> Ações </th> 
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/menu.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/af-2.3.7/date-1.1.0/r-2.2.9/rg-1.1.3/sc-2.0.4/sp-1.3.0/datatables.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $('#brindes').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'pesq_brinde.php'
                },
                'columns': [
                    {data: 'idbrindes'},
                    { data: 'descricao'},
                    { data: 'marca'},
                    { data: 'tipo'},
                    { data: 'total_entrada'},
                    { data: 'total_saida'},
                    { data: 'total_estoque'},
                    { data: 'usuario'},
                    { data: 'acoes'},
                ],
                "language":{
                    "url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                }
            });
            
        });

        //abrir modal
        $('#brindes').on('click', '.editbtn', function(event){
            var table = $('#brindes').DataTable();
            var trid = $(this).closest('tr').attr('id');
            var id = $(this).data('id');

            $('#modalEditar').modal('show');

            $.ajax({
                url:"get_brinde.php",
                data:{id:id},
                type:'post',
                success: function(data){
                    var json = JSON.parse(data);
                    $('#id').val(json.idbrindes);
                    $('#descricao').val(json.descricao);
                    $('#tipo').val(json.tipo);
                    $('#marca').val(json.marca);
                }
            })
        });
        
    </script>

<!-- modal visualisar e editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Brinde</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="atualiza-brinde.php" method="post" >
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="trid" id="trid" value="">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="descricao" class="col-form-label">Descrição</label>
                            <input type="text" name="descricao" required class="form-control" id="descricao" value="">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="marca" required class="col-form-label">Marca</label>
                            <input type="text" name="marca" id="marca" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="tipo" class="col-form-label">Tipo</label>
                            <select  required name="tipo" id="tipo" class="form-control">
                                <option value=""></option>
                                <option value="Tv">Tv</option>
                                <option value="Microondas">Microondas</option>
                                <option value="Air Flyer">Air Flyer</option>
                                <option value="Tanquinho">Tanquinho</option>
                                <option value="Aspirador de Pó">Aspirador de Pó</option>
                                <option value="Churrasqueira Elétrica">Churrasqueira Elétrica</option>
                                <option value="Fogão">Fogão</option>
                                <option value="Batedeira">Batedeira</option>
                                <option value="Ventilador">Ventilador</option>
                                <option value="Fone de Ouvidos">Fone de Ouvido</option>
                                <option value="Relógio">Relógio</option>
                                <option value="Caixa de Som">Caixa de Som</option>
                            </select>
                        </div>
                    </div>    
            </div>
            <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </div>
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </form> 
            </div>
        </div>
    </div>
</div>
<!-- Finalizar modal editar -->

<!-- modal cadastrar brinde -->
<div class="modal fade" id="modalCadastrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Novo Brinde</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="add-brinde.php" method="post" >
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="descricao" class="col-form-label">Descrição</label>
                            <input type="text" name="descricao" required class="form-control" id="descricao" value="">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="marca" required class="col-form-label">Marca</label>
                            <input type="text" name="marca" id="marca" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="tipo" class="col-form-label">Tipo</label>
                            <select  required name="tipo" id="tipo" class="form-control">
                                <option value=""></option>
                                <option value="Tv">Tv</option>
                                <option value="Microondas">Microondas</option>
                                <option value="Air Flyer">Air Flyer</option>
                                <option value="Tanquinho">Tanquinho</option>
                                <option value="Aspirador de Pó">Aspirador de Pó</option>
                                <option value="Churrasqueira Elétrica">Churrasqueira Elétrica</option>
                                <option value="Fogão">Fogão</option>
                                <option value="Batedeira">Batedeira</option>
                                <option value="Ventilador">Ventilador</option>
                                <option value="Fone de Ouvidos">Fone de Ouvido</option>
                                <option value="Relógio">Relógio</option>
                                <option value="Caixa de Som">Caixa de Som</option>
                            </select>
                        </div>
                    </div>  
            </div>
            <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </form> 
            </div>
        </div>
    </div>
</div>

</body>
</html>