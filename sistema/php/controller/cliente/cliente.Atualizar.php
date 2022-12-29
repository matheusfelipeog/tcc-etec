<?php
require_once "../../model/cliente/cliente.class.php";
//require_once "../../model/funcionario/funcionario.class.php";
$cliente = new Cliente();
//$funcionario = new Funcionario();
if(!empty($_POST)){
    //if($funcionario->log_teste()){
        $id        = addslashes(trim($_POST['alt-id']));
        $nome      = addslashes(trim($_POST['alt-nome-cliente']));
        $situacao  = addslashes(trim($_POST['alt-situacao-cliente']));
        $descricao = addslashes(trim($_POST['alt-desc-cliente']));
        $tipo      = addslashes(trim($_POST['alt-tipo-cliente']));
        $status    = addslashes(trim($_POST['alt-status-cliente']));
        $cliente->atualizarCliente($id, $nome, $situacao, $descricao, $tipo, $status);
        //header("location: ../../view/cliente/cliente.Main.php");
    //}
}
