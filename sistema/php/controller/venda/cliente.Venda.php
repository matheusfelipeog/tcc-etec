<?php
require_once "../../model/cliente/cliente.class.php";
require_once  "../../model/funcionario/funcionario.class.php";
$cliente = new Cliente();
$funcionario = new Funcionario();

$id = $_POST['pesquisa-id-cliente'];
//if ($funcionario->log_teste()) {
if ($_POST['tipoDeConsumo'] == 'Cliente') {
    $data = $cliente->listarClienteVendas($id);
} else if ($_POST['tipoDeConsumo'] == 'Funcionario'){
    $data = $funcionario->listarFuncionarioConsumo($id);
}
print_r($data);
//}