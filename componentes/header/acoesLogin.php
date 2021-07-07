<?php
session_start();
require("../../database/conexao.php");

function validarCampos()
{
  $erros = [];

  if (!isset($_POST["usuario"]) || $_POST["usuario"] == "") {
    $erros[] = "O campo usuário é obrigatório";
  }
  if (!isset($_POST["senha"]) || $_POST["senha"] == "") {
    $erros[] = "O campo usuário é obrigatório";
  }

  return $erros;
}

switch ($_REQUEST["acao"]) {
  case "login":

    $erros = validarCampos();

    if (count($erros) > 0) {
      $_SESSION["erros"] = $erros;
      header("location: ../../produtos/index.php");
    }
    //implementar hoje   
    //receber os campos usuário e senha do post  
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    //montaro sql select na tabela tbl_administrador    

    $sql = "SELECT * FROM tbl_administrador WHERE usuario = '$usuario' ";

    //executar o sql    
    $resultado  = mysqli_query($conexao, $sql);
    //verificar se o usuário existe   
    $usuario = mysqli_fetch_array($resultado);
    //verificar se a senha está correta      
    if (!$usuario || !password_verify($senha, $usuario["senha"])) {
      $mensagem = "Usuário e/ou senha invalidos";
    } else {
      //se estiver correta, salvar o id e o nome do usuário na sessão $_SESSION     
      $_SESSION["usuarioId"] = $usuario["id"];
      $_SESSION["usuarioNome"] = $usuario["nome"];

      $mensagem = "Bem vindo, "  . $usuario["nome"];
    }

    $_SESSION["mensagem"] = $mensagem;
    //se a senha estiver errada, criar uma mensagem de "usuário e/ou senha inválidos"     
    header("location: ../../produtos/index.php");
    //redirecionar para a tela de listagem de produtos     
    break;
  case "logout":
    //destruir a sessão 
    session_destroy();
    //redirecionar para index de produtos
    header("location: ../../produtos/index.php");
    break;
}