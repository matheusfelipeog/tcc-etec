<?php
require_once "../../model/cliente/cliente.class.php";
//require_once "../../model/funcionario/funcionario.class.php";
$cliente = new Cliente();
if (!empty($_POST)) {
    //if (Funcionario::log_teste()) {
        print_r($_POST);
        $nome      = addslashes(trim($_POST['add-nome-cliente']));
        $situacao  = addslashes(trim($_POST['add-situacao-cliente']));
        $descricao = addslashes(trim($_POST['add-desc-cliente']));
        $tipo      = addslashes(trim($_POST['add-tipo-cliente']));
        $cliente->cadastroCliente($nome, $situacao, $descricao, $tipo);
        //header("location: ../../view/cliente/cliente.Main.php");
    //} else {
        //header("location: ../../view/login.php");
    //}
}
