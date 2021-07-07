<?php
session_start();
require("../../database/conexao.php");

function validarCampos(){
    $erros = [];

    if(!isset($_POST["descricao"]) || $_POST["descricao"] == ""){
      $erros[] = "O campo descrição é obrigatório";
    }
    return $erros;
}
switch($_POST["acao"]){
    case "inserir":

        $erros = validarCampos();

        if(count($erros) > 0){
            $_SESSION["mensagem"] = $erros[0];

            header("location: index.php");

            exit();
        }
    // se houver o envio do formulário com uma tarefa
        if (isset($_POST["descricao"])) {
            $categoria = $_POST["descricao"];
                $sqlDescricao = "INSERT INTO tbl_categoria (descricao) VALUES ('$categoria')";
                $resultado= mysqli_query($conexao, $sqlDescricao);

                if($resultado){
                $_SESSION["mensagem"] = "Categoria incluída com sucesso";
            }else{
                $_SESSION["mensagem"] = "Ops, erro ao incluir categoria";
            }
        }
        
            header("location: index.php");
            break;

            case "deletar":
                if(isset($_POST["categoriaId"])) {
                $categoriaId = $_POST["categoriaId"];
                //declarar o sql de delete

                $sqlDelete = " DELETE FROM tbl_categoria WHERE id = ('$categoriaId') ";
                
                //executar o sql
                $resultado = mysqli_query($conexao, $sqlDelete);

                if($resultado){
                 $_SESSION["mensagem"] = "Categoria excluída com sucesso";
                }else{
                    $_SESSION["mensagem"] = "Ops, problema ao excluir"; 
                }
                header('location: index.php');
                }
                break;
}