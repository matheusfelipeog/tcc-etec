<?php
require_once '../../model/cozinha/cozinha.PDO.php';

class Cozinha{
    function listarPratosPreparo(){
        $bd = new Table_Cozinha();
        $data['lista_de_pedidos'] = $bd->selectPratosPreparo();
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    function listarPratos(){
        $bd = new Table_Cozinha();
        $data['lista_de_pedidos'] = $bd->selectPratos();
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    function pratoPronto($id_prato){
        $bd = new Table_Cozinha();
        $bd->updatePrato($id_prato);
    }

    function apagarPrato($id_cozinha){
        $bd = new Table_Cozinha();
        $bd->deleteCozinha($id_cozinha);
    }
}
