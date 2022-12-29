<?php
require_once "../../model/pdo.Banco.class.php";
/**
 * Classe de CRUD com a tabela itens_entrada.
 */
class Table_Entrada extends Banco
{
    /**
     * Faz o insert da entrada no banco.
     * 
     * @param int $id Id do produto que foi alterado.
     * 
     * @return string Retorna somente em caso de erro.
     */
    function insertEntrada($id, $quantia)
    {
        global $pdo;
        $bd = new Table_Entrada();
        $bd->conectar();
        $sql = $pdo->prepare("INSERT INTO itens_entrada (quantia, produto_id_produto) VALUES (?, ?)");
        try {
            $sql->execute(array($quantia, $id));
        } catch (PDOException $th) {
            echo '#Erro ao inserir entrada#';
            return $th;
        }
        $bd->desconectar();
    }
}
