<?php

include "../teste_config.php";

// print_r($_POST);

// $pedido_visualizado = $_POST['pedido_visualizado'];


// $sqld = "DELETE FROM cozinha WHERE id = " . $pedido_visualizado['idpedido'];
// $query = $conn->query($sqld);


// print_r($lista_de_id);



// Todo o script abaixo é somente para testes entre Ajax e ngrok

// Cria uma instância de cURL
$curl = curl_init();

// Opções da requisição
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://localhost/controller/venda/confirma_view_pedido.php', // URL DE DESTINO AQUI
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS =>  http_build_query($_POST)
]);
// Executa a request e armazena a response na variável
$response = curl_exec($curl);

// Fecha a requisição e limpa a memória
curl_close($curl);

if ($response) echo $response;
// else header("HTTP/1.1 404");