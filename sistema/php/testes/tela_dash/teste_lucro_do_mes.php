<?php

// echo json_encode( [ 'lucro_do_mes' => 1253.50 ] ) ;

// Para pegar dados na pagina do ngrok
$response = file_get_contents('http://localhost/controller/dash/lucro_do_mes.php');

if ($response) echo $response;
// else header("HTTP/1.1 404 OK");