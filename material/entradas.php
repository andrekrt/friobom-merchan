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

    <!-- select02 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    

</head>
<body>
    <div class="container-fluid corpo">
        <?php require('../menu-lateral.php') ?>
        <!-- Tela com os dados -->
        <div class="tela-principal">
            <div class="menu-superior">
                <div class="icone-menu-superior">
                    <img src="../assets/images/icones/icon-material.png" alt="">
                </div>
                <div class="title">
                    <h2>Entradas</h2>
                </div>
                <div class="menu-mobile">
                    <img src="../assets/images/icones/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                </div>
            </div>
            <!-- dados exclusivo da página-->
            <div class="menu-principal">
                <div class="icon-exp">
                    <div class="area-opcoes-button">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalEntrada" data-whatever="@mdo" name="idpeca">Nova Entrada</button>
                    </div>
                    <a href="entradas-xls.php" ><img src="../assets/images/excel.jpg" alt=""></a>    
                </div>
                <div class="table-responsive">
                    <table id='tableEnt' class='table table-striped table-bordered nowrap text-center' style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center text-nowrap" > Código </th>
                                <th scope="col" class="text-center text-nowrap" > Data de Recebimento </th>
                                <th scope="col" class="text-center text-nowrap">Material</th>
                                <th scope="col" class="text-center text-nowrap">Fornecedor</th>
                                <th scope="col" class="text-center text-nowrap">Qtd</th>
                                <th scope="col" class="text-center text-nowrap">Valor Unit</th>
                                <th scope="col" class="text-center text-nowrap">Valor Total</th>
                                <th scope="col" class="text-center text-nowrap">Nº NF</th>
                                <th scope="col" class="text-center text-nowrap">Rua</th>
                                <th scope="col" class="text-center text-nowrap">Prédio</th>
                                <th scope="col" class="text-center text-nowrap">Nível</th>
                                <th scope="col" class="text-center text-nowrap">Apartamento</th>
                                <th scope="col" class="text-center text-nowrap">Lançado por:</th>
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
    <script src="../assets/js/jquery.mask.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/af-2.3.7/date-1.1.0/r-2.2.9/rg-1.1.3/sc-2.0.4/sp-1.3.0/datatables.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $('#tableEnt').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'pesq_ent.php'
                },
                'columns': [
                    {data: 'identradas'},
                    { data: 'data_recebimento'},
                    { data: 'material'},
                    { data: 'fornecedor'},
                    {data: 'qtd'},
                    {data: 'valor_unit'},
                    {data: 'valor_total'},
                    {data: 'num_nf'},
                    {data: 'rua'},
                    {data: 'predio'},
                    {data: 'nivel'},
                    {data: 'apartamento'},
                    { data: 'usuario'},
                    { data: 'acoes'},
                ],
                "language":{
                    "url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                }
            });
            
        });

        //abrir modal
        $('#tableEnt').on('click', '.editbtn', function(event){
            var table = $('#tableEnt').DataTable();
            var trid = $(this).closest('tr').attr('id');
            var id = $(this).data('id');

            $('#modalEditar').modal('show');

            $.ajax({
                url:"get_entr.php",
                data:{id:id},
                type:'post',
                success: function(data){
                    var json = JSON.parse(data);
                    $('#id').val(json.identradas);
                    $('#materialEdit').val(json.material);
                    $('#qtd').val(json.qtd);
                    $('#recebimento').val(json.data_recebimento);
                    $('#usuario').val(json.usuario);
                    var industria = json.industria + " - " + json.fantasia;
                    $('#fornecedorEdit').val(industria);
                    $('#rua').val(json.rua);
                    $('#predio').val(json.predio);
                    $('#nivel').val(json.nivel);
                    $('#apartamento').val(json.apartamento);
                    $('#nf').val(json.num_nf);
                }
            })
        });
        
    </script>

<!-- modal visualisar e editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Entrada</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="atualiza-entrada.php" method="post" >
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="trid" id="trid" value="">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="materialEdit" class="col-form-label">Material</label>
                            <select readonly="" style="pointer-events: none; touch-action: none;" name="material" required id="materialEdit" class="form-control">
                                <option value=""></option>
                                <?php 
                                $sql = $db->query("SELECT * FROM material");
                                $materiais = $sql->fetchAll();
                                foreach($materiais as $material):
                                ?>
                                <option value="<?=$material['idmaterial']?>"><?=$material['descricao']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="fornecedorEdit" class="col-form-label">Fornecedor</label>
                            <input type="text" readonly name="fornecedorEdit" id="fornecedorEdit" class="form-control">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="recebimento" class="col-form-label">Data de Recebimento</label>
                            <input type="date" name="recebimento" id="recebimento" required class="form-control">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="qtd" required class="col-form-label">Qtd</label>
                            <input type="number" name="qtd" id="qtd" class="form-control">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="valorEdit" required class="col-form-label">Valor Unit. (R$)</label>
                            <input type="text" name="valorEdit" id="valorEdit" class="form-control">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="nf" required class="col-form-label">Nº NF</label>
                            <input type="number" name="nf" id="nf" class="form-control">
                        </div>
                    </div>   
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="rua" required class="col-form-label">Rua</label>
                            <input type="text" name="rua" id="rua" class="form-control">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="predio" required class="col-form-label">Prédio</label>
                            <input type="text" name="predio" id="predio" class="form-control">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="nivel" required class="col-form-label">Nível</label>
                            <input type="text" name="nivel" id="nivel" class="form-control">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="apartamento" required class="col-form-label">Apartamento</label>
                            <input type="text" name="apartamento" id="apartamento" class="form-control">
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

<!-- modal cadastrar material -->
<div class="modal fade" id="modalEntrada" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nova Entrada</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="add-entrada.php" method="post" >
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="material" class="col-form-label">Material</label>
                            <select name="material" required id="material" class="form-control">
                                <option value=""></option>
                                <?php 
                                $sql = $db->query("SELECT * FROM material");
                                $materiais = $sql->fetchAll();
                                foreach($materiais as $material):
                                ?>
                                <option value="<?=$material['idmaterial']?>"><?=$material['descricao']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="fornecedor" class="col-form-label">Fornecedor</label>
                            <input type="text" readonly name="fornecedor" required class="form-control" id="fornecedor">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="recebimento" class="col-form-label">Data de Recebimento</label>
                            <input type="date" name="recebimento" id="recebimento" required class="form-control">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="qtd" required class="col-form-label">Qtd</label>
                            <input type="number" name="qtd" id="qtd" class="form-control">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="valor" required class="col-form-label">Valor Unit. (R$)</label>
                            <input type="text" name="valor" id="valor" class="form-control">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="nf" required class="col-form-label">Nº NF</label>
                            <input type="number" name="nf" id="nf" class="form-control">
                        </div>
                    </div>  
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="rua" required class="col-form-label">Rua</label>
                            <input type="text" name="rua" id="rua" class="form-control">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="predio" required class="col-form-label">Prédio</label>
                            <input type="text" name="predio" id="predio" class="form-control">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="nivel" required class="col-form-label">Nível</label>
                            <input type="text" name="nivel" id="nivel" class="form-control">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="apartamento" required class="col-form-label">Apartamento</label>
                            <input type="text" name="apartamento" id="apartamento" class="form-control">
                        </div>
                    </div> 
            </div>
            <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Lançar</button>
                    </div>
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </form> 
            </div>
        </div>
    </div>
</div>
<!-- finalizar modal cadastro -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function(){
        $('#material').select2({
            width: '100%',
            dropdownParent:"#modalEntrada"
        });

        //preencher fornecedor
        $("select[name='material']").change(function(){
            var $fornecedor = $("input[name='fornecedor']");
            var codMaterial = $(this).val();

            $.getJSON('consultaForn.php', {codMaterial},
                function(retorno){
                    $fornecedor.val(retorno.fornecedor);
                }
            );
        });

        //preencher fornecedor editar
        $("select[name='materialEdit']").change(function(){
            var $fornecedor = $("input[name='fornecedorEdit']");
            var codMaterial = $(this).val();

            $.getJSON('consultaForn.php', {codMaterial},
                function(retorno){
                    $fornecedor.val(retorno.fornecedor);
                }
            );
        });

        //mascara de dinheiro
        $('#valor').mask("#.##0,00", {reverse: true});
        $('#valorEdit').mask("#.##0,00", {reverse: true});
    });

    
</script>
</body>
</html>