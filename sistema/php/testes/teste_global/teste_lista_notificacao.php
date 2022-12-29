<?php

    // require_once "../teste_config.php";

    // $query = mysqli_query($conn, "SELECT id, nome, quantidade, quantidade_minima FROM estoque WHERE quantidade <= quantidade_minima AND tipo != 'Preparo'");

    // $response = [
    //     'lista_de_notificacao' => []
    // ];

    // while($linha = mysqli_fetch_array($query)){
    //     array_push($response['lista_de_notificacao'], $linha);
    // }

    // echo json_encode( $response );

    // Todo o script abaixo é somente para testes entre Ajax e ngrok

    // Cria uma instância de cURL
    $curl = curl_init();

    // Opções da requisição
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://localhost/controller/global/notificacoes.php', // URL DE DESTINO AQUI
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $_POST
    ]);
    // Executa a request e armazena a response na variável
    $response = curl_exec($curl);

    // Fecha a requisição e limpa a memória
    curl_close($curl);

    if ($response) echo $response;
    // else header("HTTP/1.1 404");
