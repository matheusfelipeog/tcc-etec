<?php
require_once "../../model/pedido/pedido.class.php";
$pesquisa = $_POST['pesquisa'];
$pedido = new Pedido();

$dados = $pedido->pesquisarProdutos($pesquisa);
print_r($dados);

