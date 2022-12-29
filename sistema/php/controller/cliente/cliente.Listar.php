<?php
require_once "../../model/cliente/cliente.class.php";
$cliente = new Cliente();


//if ($funcionario->log_teste()) {
    $data = $cliente->listarClienteJson();
    print_r($data);
//}
