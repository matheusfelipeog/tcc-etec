<?php

// require_once "../teste_config.php";

// $request = $_POST;

// $dadosEstoque = mysqli_query($conn, "SELECT * FROM estoque");

// $dados = array();

// while($linha = mysqli_fetch_array($dadosEstoque)){
//     $dados[] = $linha;
// }

// $request['data'] = $dados;

// echo json_encode($request);

// Para pegar dados na pagina do ngrok
$response = file_get_contents('http://localhost/controller/estoque/estoque.Listar.php');

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


// DROP TABLE IF EXISTS `estoque`;
// CREATE TABLE IF NOT EXISTS `estoque` (
//   `id` int(11) NOT NULL AUTO_INCREMENT,
//   `nome` varchar(255) COLLATE utf8_bin NOT NULL,
//   `marca` varchar(255) COLLATE utf8_bin NOT NULL,
//   `tipo` varchar(255) COLLATE utf8_bin NOT NULL,
//   `status` varchar(255) COLLATE utf8_bin NOT NULL,
//   `quantidade` int(11) NOT NULL,
//   `custo` decimal(6, 2) NOT NULL,
//   `preco` decimal(6, 2) NOT NULL,
//   PRIMARY KEY (`id`)
// ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

// INSERT INTO `estoque`(`nome`, `marca`, `tipo`, `status`, `quantidade`, `custo`, `preco`) 
// VALUES 
// ('Cerveja', 'Itaipava', 'Venda', 'Alto', 150, 2.50, 4.00),
// ('Cerveja', 'Brahma', 'Venda', 'Médio', 25, 1.99, 3.20),
// ('Cerveja', 'Budweiser', 'Venda', 'Baixo', 6, 3.99, 6.30),
// ('Vinho', 'Marca X', 'Venda', 'Médio', 15, 10.00, 16.00)
