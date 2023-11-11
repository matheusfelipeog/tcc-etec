<?php
require_once "../../model/produto/produto.class.php";

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
$nome           = addslashes(trim($all_datas[0]['alt-nome-estoque']));
$marca          = addslashes(trim($all_datas[0]['alt-marca-estoque']));
$preco          = addslashes(trim($all_datas[0]['alt-preco-estoque']));
$custo          = addslashes(trim($all_datas[0]['alt-custo-estoque']));
$quantia        = addslashes(trim($all_datas[0]['alt-quantidade-estoque']));
$quantia_minima = addslashes(trim($all_datas[0]['alt-quantidade-minima-estoque']));
$tipo           = addslashes(trim($all_datas[0]['alt-tipo-estoque']));
$status         = addslashes(trim($all_datas[0]['alt-status-estoque']));

$imgDir = '../../img/produto/';

if(empty($all_datas[1])){
    $imagem = '../../img/produto/default.png';
} else {
    $imagem = $imgDir . md5($all_datas[0]['alt-nome-estoque']) . '.jpg';
}
print_r($all_datas);
$produto->alterarProduto($id, $nome, $marca, $imagem, $preco, $custo, $quantia, $quantia_minima, $tipo, $status);
