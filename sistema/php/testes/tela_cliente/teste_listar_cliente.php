<?php

// require_once "../teste_config.php";

// $request = $_POST;

// $dadosCliente = mysqli_query($conn, "SELECT id, nome, situacao, divida, tipo, `status`, DATE_FORMAT(data_cadastro, '%d/%m/%Y') as data_cadastro, descricao FROM cliente");

// $dados = array();

// while($linha = mysqli_fetch_array($dadosCliente)){
//     $dados[] = $linha;
// }

// $request['data'] = $dados;

// echo json_encode($request, JSON_UNESCAPED_UNICODE);

// echo '<pre>';
// print_r ($request['data']);


// Para pegar dados na pagina do ngrok
$response = file_get_contents('http://localhost/controller/cliente/cliente.Listar.php');

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


// DROP TABLE IF EXISTS `cliente`;
// CREATE TABLE IF NOT EXISTS `cliente` (
//   `id` int(11) NOT NULL AUTO_INCREMENT,
//   `nome` varchar(255) COLLATE utf8_bin NOT NULL,
//   `situacao` varchar(255) COLLATE utf8_bin NOT NULL,
//   `tipo` varchar(255) COLLATE utf8_bin NOT NULL,
//   `status` varchar(255) COLLATE utf8_bin NOT NULL,
//   `data_cadastro` date NULL,
//   `descricao` varchar(255) NULL,
//   PRIMARY KEY (`id`)
// ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

// INSERT INTO `cliente`(`nome`, `situacao`, `tipo`, `status`, `data_cadastro`, `descricao`) 
// VALUES 
// ('matheus', 'Em dia', 'Mensal', 'Ativo', '2011-12-20', 'Uma descrição qualquer aqui'),
// ('brenda', 'Em aberto', 'Semanal', 'Ativo', '2010-10-20', 'Outra descrição qualquer aqui'),
// ('Escanor do sol nascente', 'Em dia', 'N/D', 'Ativo', '2005-04-12', 'Mais uma descrição qualquer aqui'),
// ('Sasuke uchiha', 'Em debito', 'Mensal', 'Desativo', '2009-12-12', 'Uma descrição qualquer aqui')
