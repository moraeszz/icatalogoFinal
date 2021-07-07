<?php
 
 session_start();
require("../database/conexao.php");
 
$sql = " SELECT * FROM tbl_categoria ";
 
$resultado = mysqli_query($conexao, $sql);

if(!isset($_SESSION["usuarioId"])) {
    $_SESSION["mensagem"] = "Você precisa fazer login para acessar esta página.";
     header("location: ../../produtos/index.php");

}
 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles-global.css" />
    <link rel="stylesheet" href="./categorias.css" />
    <title>Administrar Categorias</title>
</head>

<body>
    <?php
    include("../../componentes/header/header.php");
    ?>
    <div class="content">
        <section class="categorias-container">
            <main>
                <form class="form-categorias" form method="POST" action="acoes.php">
                    <h1 class="span2">Adicionar Categorias</h1>
                    <div class="input-group span2">
                    <input type="hidden" name="acao" value="inserir" />
                        <label for="descricao">Descricao</label>
                        <input type="text" name="descricao" id="descricao" />
                    </div>
        
                    <button type="button" onclick="javascript:window.location.href='../produtos'">Cancelar</button>
                    <button>Salvar</button>
                </form>
    
                <h1>Lista de categorias</h1>
                <?php
                 while ($categoria = mysqli_fetch_array($resultado))  {
                ?>
                <div class="card-categorias">
                <?= $categoria["descricao"] ?>
                <form method="POST" action="acoes.php" value="deletar">
                            <input type="hidden" name="acao" value="deletar">
                            <input type="hidden" name="categoriaId" value="<?= $categoria['id'] ?>" />
                            <button>&#128465;</button>
                </form>
                </div>
                <?php
            }
            ?>
            </main>
        </section>
    </div>
    
</body>

</html>