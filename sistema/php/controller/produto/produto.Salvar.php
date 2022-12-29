<?php
require_once '../../model/produto/produto.class.php';
require_once '../../model/itens_entrada/entrada.class.php';

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

$nome            = addslashes(trim($all_datas[0]['add-nome-produto']));
$marca           = addslashes(trim($all_datas[0]['add-marca-produto']));
$preco           = addslashes(trim($all_datas[0]['add-preco-produto']));
$custo           = addslashes(trim($all_datas[0]['add-custo-produto']));
$quantia         = addslashes(trim($all_datas[0]['add-quantidade-produto']));
$quantia_minima  = addslashes(trim($all_datas[0]['add-quantidade-minima-produto']));
$tipo            = addslashes(trim($all_datas[0]['add-tipo-produto']));

$imgDir = '../../img/produto/';

if(empty($all_datas[1])){
    $imagem = '../../img/produto/default.png';
} else {
    $imagem = $imgDir . md5($all_datas[0]['add-nome-produto']) . '.jpg';
}
// Descomente para pegar uma imagem e move-la para uma pasta
/*
$imagem = $_FILES["imagem"]["name"];
$separa = explode(".", $imagem);
$separa = array_reverse($separa);
$extensao = $separa[0];
$imagemF = strtolower(str_replace(' ', '', $nome)) . "." . $extensao;
*/
//if (move_uploaded_file($_FILES['imagem']['tmp_name'], $imgDir . $imagemF)) {
    $id = $produto->verificarProduto($nome);
    if(isset($all_datas[0]['add-mais-unid-produto'])){
        $entrada = new Entrada();
        $unidades = addslashes(trim($all_datas[0]['add-mais-unid-produto']));
        $entrada->salvarEntrada($id, $unidades);
        $produto->adicionarEstoque($unidades, $id);
    } else if($id == false || $id == -1){
        $produto->cadastroProduto($nome, $marca, $imagem, $preco, $custo, $quantia, $quantia_minima, $tipo);
    }
//}
