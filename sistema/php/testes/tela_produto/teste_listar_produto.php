<?php

// require_once "../teste_config.php";

// $request = $_POST;

// $dadosProdutos = mysqli_query($conn, "SELECT id, nome, marca, tipo, quantidade, quantidade_minima, custo, preco FROM produto WHERE `status` = 'Ativo'");

// $dados = array();

// while($linha = mysqli_fetch_array($dadosProdutos)){
//     $dados[] = $linha;
// }

// $request['data'] = $dados;

// echo json_encode( $request );


// Para pegar dados na pagina do ngrok
$response = file_get_contents('http://localhost/controller/produto/produto.Listar.php');

if ($response) echo $response;
// else header("HTTP/1.1 404 OK");


// echo '{ "data": ' . json_encode( $dados ) . '}';

// Estrutura padrão
// $data = array(
//     array(
//         "2",
//         "Vinho",
//         "Marca Y",
//         "Venda",
//         "Alto",
//         "20",
//         "15.60",
//         "20.30"
//     ),
//     array(
//         "7",
//         "Vinho",
//         "Marca Z",
//         "Venda",
//         "Alto",
//         "20",
//         "15.60",
//         "20.30"
//     )
// );
 
// Para testes
// INSERT INTO `produto`(`nome`, `marca`, `tipo`, `status`, `quantidade`, `custo`, `preco`) 
// VALUES 
// ('coca', 'coca-cola', 'venda', 'Alto', 50, 4.50, 6.00),
// ('macarrao', 'marca Y', 'venda', 'Baixo', 60, 2.00, 3.00),
// ('bala', 'fini', 'venda', 'Alto', 30, 0.50, 1.00),
// ('arroz', 'prato fino', 'venda', 'Medio', 20, 4.50, 6.00)
