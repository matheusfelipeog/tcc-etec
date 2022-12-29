<?php
require_once "..\..\model\produto\produto.class.php";
$produto = new Produto();
//Pega a operação a ser realizada
$op = addslashes(trim($_GET['op']));

if ($op == 'delete') {
    echo "olá";
    $id = addslashes(trim($_GET['id']));
    $produto->excluirProduto($id);
} else {
    $nome  = addslashes(trim($_POST['nome']));
    $tipo  = addslashes(trim($_POST['tipo']));
    $marca = addslashes(trim($_POST['marca']));
    $preco = addslashes(trim($_POST['preco']));
    $custo = addslashes(trim($_POST['custo']));
    if ($op == 'insert') {
        $produto->cadastroProduto($nome, $tipo, $marca, $preco, $custo);
    } elseif ($op == 'update') {
        $id = addslashes(trim($_GET['id']));
        $produto->alterarProduto($id, $nome, $tipo, $marca, $preco, $custo);
    }
}
header("Location: ../../view/produto/produtos.Main.php");