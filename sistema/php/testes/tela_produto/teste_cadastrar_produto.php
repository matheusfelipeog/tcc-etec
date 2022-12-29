<?php

// require_once "../teste_config.php";

// A query post, exemplo: nome=fulano&idade=20&sexo=masculino
$query_post = $_POST['data'];

$data = []; // Para armazenar o array com os dados finais
foreach ( explode('&', $query_post) as $post_separados) {

    // Separa chave=valor, Sendo agora um array de 2 posições: [0] a chave e [1] o valor
    $chave_valor = explode('=', $post_separados); 

    // Popula o array final para o formato correto, ficando [chave] => valor
    $data[urldecode($chave_valor[0])] = urldecode($chave_valor[1]);           
}

// print_r($data);

// print_r ($_FILES);


$all_datas = array($data, $_FILES);

// print_r($all_datas);


// Todo o script abaixo é somente para testes entre Ajax e ngrok

// Cria uma instância de cURL
$curl = curl_init();

// Opções da requisição
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://localhost/controller/produto/produto.Salvar.php', // URL DE DESTINO AQUI
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => http_build_query($all_datas)
]);
// Executa a request e armazena a response na variável
$response = curl_exec($curl);

// Fecha a requisição e limpa a memória
curl_close($curl);

if ($response) echo $response;
// else header("HTTP/1.1 404");