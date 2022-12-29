<?php
require_once "../../model/pdo.Banco.class.php";

class Table_Contas extends Banco {

    function insertContas($id_cliente, $id_pedido){
        global $pdo;
        $bd = new Table_Contas();
        $bd->conectar();
        $sql = $pdo->prepare("INSERT INTO contas VALUES ($id_cliente, DEFAULT, $id_pedido)");
        $sql->execute();
    }
}