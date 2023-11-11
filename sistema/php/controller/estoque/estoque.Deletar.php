<?php
require_once "../../model/produto/produto.class.php";

$produto = new Produto();



if (isset($_POST['quantidade_a_deletar'])) {
    $id = addslashes(trim($_POST['id_produto']));
    $quantia = addslashes(trim($_POST['quantidade_a_deletar']));
    $produto->retirarEstoque($quantia, $id);
}else{
    $produto->excluirProduto($_POST);
}
