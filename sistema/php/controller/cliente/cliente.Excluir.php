<?php
require_once "../../model/cliente/cliente.class.php";
//require_once "../../model/funcionario/funcionario.class.php";
$cliente = new Cliente();
//$funcionario = new Funcionario();
if (!empty($_POST)) {
    //if ($funcionario->log_teste()) {
        //if ($_SESSION['acesso'] == 'US') {
            $id = $_POST;
            $cliente->excluirCliente($id);
            //header("location: ../../view/cliente/cliente.Main.php");
        //}else{
            //header('HTTP/1.0 401 Unauthorized');
        //}
    //}
}
