<?php
require_once "..\..\model\produto\produto.class.php";

$produto = new Produto();

// A query post, exemplo: nome=fulano&idade=20&sexo=masculino
$query_post = $_POST['data'];

$data = []; // Para armazenar o array com os dados finais
foreach ( explode('&', $query_post) as $post_separados) {

    // Separa chave=valor, Sendo agora um array de 2 posições: [0] a chave e [1] o valor
    $chave_valor = explode('=', $post_separados); 

    // Popula o array final para o formato correto, ficando [chave] => valor
    $data[urldecode($chave_valor[0])] = urldecode($chave_valor[1]);           
}

$all_datas = array($data, $_FILES);

$id             = addslashes(trim($all_datas[0]['alt-id']));
$nome           = addslashes(trim($all_datas[0]['alt-nome-produto']));
$marca          = addslashes(trim($all_datas[0]['alt-marca-produto']));
$preco          = addslashes(trim($all_datas[0]['alt-preco-produto']));
$custo          = addslashes(trim($all_datas[0]['alt-custo-produto']));
$quantia        = addslashes(trim($all_datas[0]['alt-quantidade-produto']));
$quantia_minima = addslashes(trim($all_datas[0]['alt-quantidade-minima-produto']));
$tipo           = addslashes(trim($all_datas[0]['alt-tipo-produto']));

$imgDir = '../../img/produto/';

if(empty($all_datas[1])){
    $imagem = '../../img/produto/default.png';
} else {
    $imagem = $imgDir . md5($all_datas[0]['alt-nome-produto']) . '.jpg';
}

$produto->alterarProduto($id, $nome, $marca, $imagem, $preco, $custo, $quantia, $quantia_minima, $tipo, $status = 1);

//header("Location: ../../view/produto/produtos.Main.php");
