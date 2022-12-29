<?php
require_once '../../model/pdo.Banco.class.php';

class Table_Cozinha extends Banco{

    function selectPratosPreparo(){
        global $pdo;
        $bd = new Table_Cozinha();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT id_cozinha, nome, path_img_produto, pedido_id, quantia FROM pratos_cozinha WHERE `status` != 'Pronto'");
        $sql->execute();
        return $sql->fetchAll();
        $bd->desconectar();
    }

    function selectPratos(){
        global $pdo;
        $bd = new Table_Cozinha();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT id_cozinha AS id, nome AS nome_pedido, quantia AS quantia_pedido, `status` AS status_pedido FROM pratos_cozinha ORDER BY `status` DESC, id_cozinha ASC");
        $sql->execute();
        return $sql->fetchAll();
        $bd->desconectar();
    }

    function updatePrato($id_prato){
        global $pdo;
        $bd = new Table_Cozinha();
        $bd->conectar();
        $sql = $pdo->prepare("UPDATE cozinha SET `status` = 'Pronto' WHERE id_cozinha = ?");
        $sql->execute(array($id_prato));
        $bd->desconectar();
    }

    function deleteCozinha($id_cozinha){
        global $pdo;
        $bd = new Table_Cozinha();
        $bd->conectar();
        $sql = $pdo->prepare("DELETE FROM cozinha WHERE id_cozinha = ?");
        $sql->execute(array($id_cozinha));
        $bd->desconectar();
    }
}
