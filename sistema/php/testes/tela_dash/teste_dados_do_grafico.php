<?php

// $dados = [
//     'estrutura_do_grafico' => [
//         'labels' => [],
//         'data' => []
//     ]
// ];

// array_push(
//     $dados['estrutura_do_grafico']['labels'], "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" // MESES
// );

// array_push(
//     $dados['estrutura_do_grafico']['data'], 400.00, 543.00, 505.60, 780.40, 1000.00, 450.00, 480.00, 820.00, 670.00, 840.00, 999.00, 900  // VALORES DOS MESES
// );

// echo json_encode($dados);

$response = file_get_contents('http://localhost/controller/dash/lucro.Anual.php');

if ($response) echo $response;
