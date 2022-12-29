<?php

require_once "../../model/cliente/cliente.class.php";

$cliente = new Cliente();

$credito = addslashes(trim($_POST['valor_a_pagar']));
$id_cliente = addslashes(trim($_POST['id-cliente']));

$cliente->clienteCredito($credito, $id_cliente);