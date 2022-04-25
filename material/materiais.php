<?php

session_start();
require("../conexao.php");

if (isset($_SESSION['idusuario']) && empty($_SESSION['idusuario'])==false) {
    
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
                    <h2>Materiais</h2>
                </div>
                <div class="menu-mobile">
                    <img src="../assets/images/icones/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                </div>
            </div>
            <!-- dados exclusivo da página-->
            <div class="menu-principal">
                <div class="icon-exp">
                    <div class="area-opcoes-button">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalCadastrar" data-whatever="@mdo" name="idpeca">Novo Material</button>
                    </div>
                    <a href="materiais-xls.php" ><img src="../assets/images/excel.jpg" alt=""></a>    
                </div>
                <div class="table-responsive">
                    <table id='tableMat' class='table table-striped table-bordered nowrap text-center' style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center text-nowrap" > Código </th>
                                <th scope="col" class="text-center text-nowrap" > Descrição </th>
                                <th scope="col" class="text-center text-nowrap">Tipo</th>
                                <th scope="col" class="text-center text-nowrap">Fornecedor</th>
                                <th scope="col" class="text-center text-nowrap">Estoque Mínimo</th>
                                <th scope="col" class="text-center text-nowrap">Total de Entradas</th>
                                <th scope="col" class="text-center text-nowrap">Total de Saídas</th>
                                <th scope="col" class="text-center text-nowrap">Estoque Atual</th>
                                <th scope="col" class="text-center text-nowrap">Status</th>
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
            $('#tableMat').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'pesq_mat.php'
                },
                'columns': [
                    {data: 'idmaterial'},
                    { data: 'descricao'},
                    { data: 'tipo'},
                    { data: 'industria'},
                    {data: 'estoque_minimo'},
                    { data: 'total_entrada'},
                    { data: 'total_saida'},
                    { data: 'total_estoque'},
                    { data: 'status'},
                    { data: 'usuario'},
                    { data: 'acoes'},
                ],
                "language":{
                    "url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                }
            });
            
        });

        //abrir modal
        $('#tableMat').on('click', '.editbtn', function(event){
            var table = $('#tableForn').DataTable();
            var trid = $(this).closest('tr').attr('id');
            var id = $(this).data('id');

            $('#modalEditar').modal('show');

            $.ajax({
                url:"get_mat.php",
                data:{id:id},
                type:'post',
                success: function(data){
                    var json = JSON.parse(data);
                    $('#id').val(json.idmaterial);
                    $('#descricao').val(json.descricao);
                    $('#tipo').val(json.tipo);
                    $('#minimo').val(json.estoque_minimo);
                    $('#fornecedor').val(json.industria);
                    $('#usuario').val(json.usuario);
                }
            })
        });
        
    </script>

<!-- modal visualisar e editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="atualiza-material.php" method="post" >
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="trid" id="trid" value="">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="descricao" class="col-form-label">Descrição</label>
                            <input type="text" name="descricao" required class="form-control" id="descricao" value="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="tipo" required class="col-form-label">Tipo de Material</label>
                            <select name="tipo" id="tipo" class="form-control">
                                <option value=""></option>
                                <option value=""></option>
                                <option value="Bobina Forração">Bobina Forração</option>
                                <option value="Cantoneira">Cantoneira</option>
                                <option value="Wobble">Wobble</option>
                                <option value="Clip Strips">Clip Strips</option>
                                <option value="Precificador">Precificador</option>
                                <option value="Expositor">Expositor</option>
                                <option value="Régua">Régua</option>
                                <option value="Cartaz">Cartaz</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="minimo" class="col-form-label">Estoque Mínimo</label>
                            <input type="number" name="minimo" id="minimo" required class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="fornecedor" required class="col-form-label">Fornecedor</label>
                            <select name="fornecedor" requireds id="fornecedor" class="form-control">
                                <option value=""></option>
                            <?php 
                            $sql = $db->query("SELECT * FROM industrias WHERE ativo = 1");
                            $industrias = $sql->fetchAll();
                            foreach($industrias as  $industria):
                            ?>
                                <option value="<?=$industria['idindustrias']?>"><?=$industria['idindustrias']." - ". $industria['fantasia']?></option>
                            <?php endforeach; ?>
                                
                            </select>
                        </div>
                    </div>    
            </div>
            <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </div>
                    <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </form> 
            </div>
        </div>
    </div>
</div>
<!-- Finalizar modal editar -->

<!-- modal cadastrar material -->
<div class="modal fade" id="modalCadastrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Novo Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="add-material.php" method="post" >
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="descricao" class="col-form-label">Descrição</label>
                            <input type="text" name="descricao" required class="form-control" id="descricao" value="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="tipo" required class="col-form-label">Tipo de Material</label>
                            <select name="tipo" id="tipo" class="form-control">
                                <option value=""></option>
                                <option value="Bobina Forração">Bobina Forração</option>
                                <option value="Cantoneira">Cantoneira</option>
                                <option value="Wobble">Wobble</option>
                                <option value="Clip Strips">Clip Strips</option>
                                <option value="Precificador">Precificador</option>
                                <option value="Expositor">Expositor</option>
                                <option value="Régua">Régua</option>
                                <option value="Cartaz">Cartaz</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="minimo" class="col-form-label">Estoque Mínimo</label>
                            <input type="number" name="minimo" id="minimo" required class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="fornecedor" required class="col-form-label">Fornecedor</label>
                            <select name="fornecedor" requireds id="fornecedorCad" class="form-control">
                                <option value=""></option>
                            <?php 
                            $sql = $db->query("SELECT * FROM industrias WHERE ativo = 1");
                            $industrias = $sql->fetchAll();
                            foreach($industrias as  $industria):
                            ?>
                                <option value="<?=$industria['idindustrias']?>"><?=$industria['idindustrias']." - ". $industria['fantasia']?></option>
                            <?php endforeach; ?>
                                
                            </select>
                        </div>
                    </div>   
            </div>
            <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                    <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </form> 
            </div>
        </div>
    </div>
</div>
<!-- finalizar modal cadastro -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function(){
        $('#fornecedorCad').select2({
            width: '100%',
            dropdownParent:"#modalCadastrar"
        });
    });
</script>
</body>
</html>