<?php

include "../teste_config.php";

$lista_de_id = $_POST;

// Caso tenha retorno de msg de erro especifica
// header("HTTP/1.0 200 OK");


// foreach($lista_de_id as $chave => $valor){
//     echo "$valor";
// }

// foreach($lista_de_id as $chave => $valor){
//     $sqld = "DELETE FROM produto WHERE id=$valor";
//     $query = $conn->query($sqld);
// }

// print_r($lista_de_id);



// Todo o script abaixo é somente para testes entre Ajax e ngrok

// Cria uma instância de cURL
$curl = curl_init();

// Opções da requisição
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://localhost/controller/produto/produto.Deletar.php', // URL DE DESTINO AQUI
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $lista_de_id
]);
// Executa a request e armazena a response na variável
$response = curl_exec($curl);

// Fecha a requisição e limpa a memória
curl_close($curl);

if ($response) echo $response;
// else header("HTTP/1.1 404");