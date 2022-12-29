<?php
require_once "../../model/cliente/cliente.class.php";
$op = addslashes(trim($_GET['op']));
$cliente = new Cliente();

// Define a operação a ser feita
if ($op == "delete") {
    // Deletar Cliente
    $id = addslashes(trim($_GET['id']));
    $cliente->excluirCliente($id);

} else {
    $nome      = addslashes(trim($_POST['nome']));
    $situacao  = addslashes(trim($_POST['situacao']));
    $descricao = addslashes(trim($_POST['descricao']));
    $tipo      = addslashes(trim($_POST['tipo']));

    if ($op == "update") {
        // Atualizar Cliente
        $id = $_GET['id'];
        $cliente->atualizarCliente($id, $nome, $situacao, $descricao, $tipo);

    } elseif ($op == "insert") {
        // Cadastrar Cliente
        $cliente->cadastroCliente($nome, $situacao, $descricao, $tipo);
    } else{
        return 051;
    }
}
header("location: ../../view/cliente/cliente.Main.php");
