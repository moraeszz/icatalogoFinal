<?php
session_start();

if (!isset($_SESSION["usuarioId"])) {
 
 $_SESSION["mensagens"] ="Acesso negado, voce precisa logar.";

 header("location: ../../index.php");

}

require("../../database/conexao.php");

$produtoId = $_GET["id"];
$sqlProduto = " SELECT * FROM tbl_produto WHERE id = $produtoId";
$resultado = mysqli_query($conexao, $sqlProduto);
$produto = mysqli_fetch_array($resultado);
 if(!$produto){
    echo "Produto não encontrado!";

    exit();
 }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../styles-global.css" />
  <link rel="stylesheet" href="./editar.css" />
  <title>Editar Produtos</title>
</head>

<body>
<?php
  include("../../componentes/header/header.php");
?>
  <header>
    <input type="search" placeholder="Pesquisar" />
  </header>
  <div class="content">
    <section class="produtos-container">
      <main>
        <form class="form-produto" method="POST" action="taskActions.php" enctype="multipart/form-data">
        <input type="hidden" name="acao" value="editar" />
        <input type="hidden" name="produtoId" value="<?= $produto["id"]?>" />
          <h1>Cadastro de produto</h1>
          <ul>
          <?php
            //verifica se existe erros na sessão do usuario
            if(isset($_SESSION['erros'])){
              $erros = $_SESSION['erros'];
              foreach ($erros as $erro) {
          ?>
            <li><?= $erro ?></li>
          <?php
              }
              //eliminar da sessão os erros ja mostrado
              unset($_SESSION['erros']);
            }
          ?>
          </ul>
          <div class="input-group span2">
            <label for="descricao">Descrição</label>
            <input name="descricao" type="text" value="<?=$produto['descricao'] ?>" id="descricao" required>
          </div>
          <div class="input-group">
            <label for="peso">Peso</label>
            <input name="peso" type="text" value="<?=$produto['peso'] ?>"id="peso" required>
          </div>
          <div class="input-group">
            <label for="quantidade">Quantidade</label>
            <input name="quantidade" type="text" value="<?=$produto['quantidade'] ?>"id="quantidade" required>
          </div>
          <div class="input-group">
            <label for="cor">Cor</label>
            <input name="cor" type="text" value="<?=$produto['cor'] ?>" id="cor" required>
          </div>
          <div class="input-group">
            <label for="tamanho">Tamanho</label>
            <input name="tamanho" type="text" value="<?=$produto['tamanho'] ?>" id="tamanho">
          </div>
          <div class="input-group">
            <label for="valor">Valor</label>
            <input name="valor" type="text" value="<?=$produto['valor'] ?>"id="valor" required>
          </div>
          <div class="input-group">
            <label for="desconto">Desconto</label>
            <input name="desconto" type="text" value="<?=$produto['desconto'] ?>" id="desconto">
          </div>
          <div class="input-group">
            <label for="categoria">Categoria</label>
            <select type="text" name="categoria"  id="categoria">
              <option value="">Selecione</option>
              <?php
              while($categoria = mysqli_fetch_array($resultado)) {
              ?>
              <option value="<?= $categoria["id"] ?>" <?= $categoria["id"] == $produto["categoria_id"] ? "selected" : "" ?>>
               <?= $categoria["descricao"] ?>
              </option>
               <?php
              }
              ?>
            </select>
          </div>
          <div class="input-group">
          <label for="foto">Foto</label>
          <input type="file" name="foto" id="foto" accept="image/*">
          </div>
          <button onclick="javascript:window.location.href = '../'">Cancelar</button>
          <button>Salvar</button>
        </form>
      </main>
    </section>
  </div>
  <footer>
    SENAI 2021 - Todos os direitos reservados
  </footer>
</body>

</html>
© 2021 GitHub, Inc.