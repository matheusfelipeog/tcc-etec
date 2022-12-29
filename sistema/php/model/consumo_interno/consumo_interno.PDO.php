<?php
require_once "../../model/pdo.Banco.class.php";

class Table_Consumo extends Banco{
    function insertConsumo($id_funcionario, $id_pedido){
        global $pdo;
        $bd = new Table_Consumo();
        $bd->conectar();
        $sql = $pdo->prepare("INSERT INTO consumo_interno VALUES (DEFAULT, $id_funcionario, $id_pedido)");
        $sql->execute();
    }
}