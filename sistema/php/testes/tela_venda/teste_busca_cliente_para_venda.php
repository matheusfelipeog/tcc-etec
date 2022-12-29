<?php

    // require_once "../teste_config.php";

    // print_r($_POST);

    // $request_pesquisa_id = $_POST['pesquisa-id-cliente'];

    // $query = mysqli_query($conn, "SELECT id, nome FROM cliente WHERE id = $request_pesquisa_id LIMIT 1");

    // // $dados = array();

    // $response = [
    //     'cliente' => []
    // ];

    // while($linha = mysqli_fetch_array($query)){
    //     // $response['response'] = $linha;
    //     array_push($response['cliente'], $linha);
    // }

    // echo json_encode( $response );


    // Cria uma instância de cURL
    $curl = curl_init();

    // Opções da requisição
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://localhost/controller/venda/cliente.Venda.php', // URL DE DESTINO AQUI
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $_POST
    ]);
    // Executa a request e armazena a response na variável
    $response = curl_exec($curl);

    // Fecha a requisição e limpa a memória
    curl_close($curl);

    if ($response) echo $response;
    // else header("HTTP/1.1 404");