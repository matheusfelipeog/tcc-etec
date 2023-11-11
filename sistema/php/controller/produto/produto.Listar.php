<?php
require_once "../../model/produto/produto.class.php";

$produto = new Produto();

$data = $produto->listarProdutos();
print_r($data);

//header("Location: ../../view/produto/produtos.Main.php");
