<?php

// echo json_encode( [ 'tipo_de_pagamento' => [2, 50, 38] ] ) ;

// Para pegar dados na pagina do ngrok
$response = file_get_contents('http://localhost/controller/dash/tipo_vendas.php');

if ($response) echo $response;
// else header("HTTP/1.1 404 OK");
