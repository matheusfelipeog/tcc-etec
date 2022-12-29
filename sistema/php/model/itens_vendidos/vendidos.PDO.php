<?php
require_once '../../model/pdo.Banco.class.php';
class Table_Vendidos extends Banco{
    function insertItem($quantia, $id_pedido, $id_produto){
        global $pdo;
        $bd = new Table_Vendidos();
        $bd->conectar();
        $sql = $pdo->prepare("INSERT INTO itens_vendidos VALUES (?, ?, ?)");
        $sql->execute(array($quantia, $id_pedido, $id_produto));
    }
}