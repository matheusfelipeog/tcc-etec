<?php
require_once "../../model/itens_entrada/entrada.PDO.php";

$bd = new Table_Entrada();
/**
 * Representa as entradas de produtos no sistema.
 */
class Entrada{
    private $quantia;
    private $id_produto;

// Getters
    function getQuantia(){
        return $this->quantia;
    }

    function getId(){
        return $this->id_produto;
    }

// Setters
    function setQuantia($q){
        $this->quantia = $q;
    }

    function setId($id){
        $this->id_produto = $id;
    }

// ---------------------------------------------------------------

/**
 * Insere os dados de uma entrada.
 *
 * @param int $id ID do produto a ter a quantia alterada.
 *
 * @param int $quantia
 *
 * @return void
 */
    private function dadosEntrada($id, $quantia){
        $this->setQuantia($quantia);
        $this->setId($id);
    }

/**
 * Salva a entrada no banco
 *
 * @param int $id Id do produto que teve a quantia redefinida, tem como padrão -1.
 *
 * @param int $quantia Quanto que foi aderido no produto.
 *
 * @return void
 */
    function salvarEntrada($id, $quantia){
        $bd = new Table_Entrada();
        if ($id >= 0){
            $this->dadosEntrada($id, $quantia);
            $bd->insertEntrada($id, $quantia);
        }
    }
}
