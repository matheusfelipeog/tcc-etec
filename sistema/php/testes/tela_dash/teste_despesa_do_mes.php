<?php

// echo json_encode( [ 'despesa_do_mes' => 738.30 ] );

$response = file_get_contents('http://localhost/controller/dash/despesa_do_mes.php');

if ($response) echo $response;
// else header("HTTP/1.1 404 OK");