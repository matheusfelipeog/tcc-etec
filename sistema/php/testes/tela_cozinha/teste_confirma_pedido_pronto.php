<?php

include "../teste_config.php";

// print_r($_POST);

// $pedido_pronto = $_POST['pedido_pronto'];

// $sqld = "UPDATE `cozinha` SET `status_pedido`= 'Pronto' WHERE id = " . $pedido_pronto['idpedido'];
// $query = $conn->query($sqld);


// Todo o script abaixo é somente para testes entre Ajax e ngrok

// Cria uma instância de cURL
$curl = curl_init();

// Opções da requisição
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://localhost/controller/cozinha/confirma_pedido_pronto.php', // URL DE DESTINO AQUI
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => http_build_query($_POST)
]);
// Executa a request e armazena a response na variável
$response = curl_exec($curl);

// Fecha a requisição e limpa a memória
curl_close($curl);

if ($response) echo $response;
// else header("HTTP/1.1 404");