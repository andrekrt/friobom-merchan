<div class="menu-lateral" id="menu-lateral">
    <div class="logo">  
        <img src="../assets/images/logo.png" alt="">
    </div>
    <div class="opcoes" >
        <div class="item">
            <a href="../index.php">
                <img src="../assets/images/menu/inicio.png" alt="">
            </a>
        </div>
        <div class="item">
            <a class="" onclick="menuDescarga()">
                <img src="../assets/images/menu/material.png" alt="">
            </a>
            <nav id="submenuDescarga">
                <ul class="nav flex-column">
                    <li class="nav-item"> <a class="nav-link" href="../material/materiais.php"> Materiais </a> </li>  
                    <li class="nav-item"> <a class="nav-link" href="../material/entradas.php">Entradas </a> </li>
                    <li class="nav-item"> <a class="nav-link" href="../material/saidas.php">Saídas </a> </li>
                    <li class="nav-item"> <a class="nav-link" href="../material/solicitacao-saida.php">Solicitaçõs de Saída </a> </li>
                </ul>
            </nav>
        </div>
        <div class="item">
            <a class="" onclick="menuBrinde()">
                <img src="../assets/images/menu/menu-brinde.png" alt="">
            </a>
            <nav id="submenuBrinde">
                <ul class="nav flex-column">
                    <li class="nav-item"> <a class="nav-link" href="../brindes/brindes.php"> Brindes </a> </li>  
                    <li class="nav-item"> <a class="nav-link" href="../brindes/entradas.php">Entradas </a> </li>
                    <li class="nav-item"> <a class="nav-link" href="../brindes/saidas.php">Saídas </a> </li>
                </ul>
            </nav>
        </div>
        <div class="item">
            <a onclick="menuFornecedor()">
                <img src="../assets/images/menu/menu-fornecedor.png" >
            </a>
            <nav id="submenuFornecedor">
                <ul class="nav flex-column">
                    <li class="nav-item"> <a class="nav-link" href="../fornecedores/form-fornecedor.php">Cadastrar Fornecedor</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="../fornecedores/fornecedores.php">Listar Fornecedores</a> </li>
                </ul>
            </nav>
        </div>
        <div class="item">
            <a onclick="menuUsuario()">
                <img src="../assets/images/menu/usuarios.png">
            </a>
            <nav id="submenuUsuario">
                <ul class="nav flex-column">
                    <li class="nav-item"> <a class="nav-link" href="../usuarios/form-usuario.php"> Cadastrar Usuário </a> </li>
                </ul> 
            </nav> 
        </div>
        <div class="item">
            <a href="../sair.php">
                <img src="../assets/images/menu/sair.png" alt="">
            </a>
        </div>
    </div>                
</div>