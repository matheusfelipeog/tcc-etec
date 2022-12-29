<?php

// require_once "../teste_config.php";

// // $request = $_POST;

// $dados = mysqli_query($conn, "SELECT * FROM estoque WHERE tipo != 'Preparo' AND `status` = 'Ativo'");

// // echo count($dadosEstoque);

// // $dados = array();

// // while($linha = mysqli_fetch_array($dadosEstoque)){
// //     array_push($dados, $linha);
// // }

// echo json_encode( [ 'qtd_total_produtos' => mysqli_num_rows($dados) ] );
// echo "<pre>";
// print_r( mysqli_num_rows($dados) );

// Para pegar dados na pagina do ngrok
$response = file_get_contents('http://localhost/controller/dash/quantidade_total_de_produtos.php');

if ($response) echo $response;
// else header("HTTP/1.1 404 OK");
