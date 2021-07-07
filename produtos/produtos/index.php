<?php
require("../../database/conexao.php");

$pesquisa = isset($_GET["p"]) ? $_GET["p"] : null;

if($pesquisa){
    $sql = "SELECT p. *, c.descricao as categoria FROM tbl_produto p
    INNER JOIN tbl_categoria c ON p.categoria_id = c.id WHERE p.descricao LIKE '%$pesquisa%' 
    OR c.descricao LIKE '%$pesquisa%'";


}else{
$sql = "SELECT p.*, c.descricao as categoria FROM tbl_produto p
INNER JOIN tbl_categoria c ON p.categoria_id = c.id
ORDER BY p.id DESC; ";

}
$resultado = mysqli_query($conexao, $sql) or die (mysqli_error($conexao));

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles-global.css" />
    <link rel="stylesheet" href="./produtos.css" />
    <title>Administrar Produtos</title>
</head>

<body>
   <?php
   include("../../componentes/header/header.php")
   ?>
    <div class="content">
     
        <section class="produtos-container">
        <?php
        //* se existir um usuario na sessão  mostra botão
        if(isset($_SESSION["usuarioId"])){
        ?>
            <header>
                <button onclick="javascript:window.location.href ='./novo/'">Novo Produto</button>
                <button onclick="javascript:window.location.href ='../categoria'">Adicionar Categorias</button>
            </header>
            <?php
        }
        ?>
            <main>
                <?php
                while ($produto = mysqli_fetch_array($resultado)) {
                 if($produto["desconto"] >0){
                 $desconto = $produto["desconto"] / 100;
                 $valor = $produto["valor"] = $desconto * $produto["valor"];
                 }else{
                 $valor = $produto["valor"];
                 }

                 $qtdeParcelas = $valor > 1000 ? 12 : 6;

                 $valorParcela = $valor / $qtdeParcelas;

                 $valorParcela = number_format($valorParcela, 2, ",",".");
                 ?>


                <article class="card-produto">
                    <figure>
                        <img src="fotos/<?= $produto["imagem"] ?>" />
                    </figure>
                    <section>
                        
                        <span class="preco">R$ <?= number_format($produto["valor"], 2, ",",".") ?></span>
                        <span class="parcelamento">ou em <em><?= $qtdeParcelas ?>x R$<?= $valorParcela ?> sem juros </em> </span>

                        <span class="descricao"><?= $produto["descricao"] ?></span>
                        <span class="categoria">
                            <em><?= $produto["categoria"] ?></em>
                            <?php 
                                if(isset($_SESSION["usuarioId"])   ){
                            ?>
                            <img class="imagem-produto" onclick="javascript: window.location = './editar/index.php?id=<?=$produto['id'] ?>'" src="/backend/projeto-php/icatalogo-parte1/imgs/editar-arquivo.png" />
                            <img class="imagem-produto" onclick="deletar(<?= $produto['id'] ?>)" src="https://icons.veryicon.com/png/o/construction-tools/coca-design/delete-189.png" />
                            <?php 
                                }
                            ?>
                        </span>
                    </section>
                    <footer>

                    </footer>
                    <form id="form-deletar" method="POST" action="./novo/taskActions.php">
                        <input type="hidden" name="acao" value="deletar"/>
                        <input id="categoria-id" type="hidden" name="categoriaId" value=""/>
                    </form>
                </article>
                <?php
                }
                ?>
               </main>
               </section>
               
    </div>
    <footer>
        SENAI 2021 - Todos os direitos reservados
    </footer>
    <script lang="javascript"> 

    function deletar(categoriaId){
        if (confirm("Deseja realmente excluir este produto?")) {
        document.querySelector("#categoria-id").value = categoriaId;

        document.querySelector("#form-deletar").submit();
         }
    }
    </script>
</body>

</html>