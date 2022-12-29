<?php
require_once "../../model/pdo.Banco.class.php";

class Table_Pedido extends Banco{

    function insertPedido($valor, $tipo, $desconto = 0, $acrescimo = 0){
        global $pdo;
        $bd = new Table_Pedido();
        $bd->conectar();
        $sql = $pdo->prepare("INSERT INTO pedido (valor, tipo, desconto, acrescimo) VALUES (?, ?, ?, ?)");
        try {
            $sql->execute(array($valor, $tipo, $desconto, $acrescimo));
            $sql = $pdo->prepare("SELECT MAX(id_pedido) FROM pedido");
            $sql->execute();
            return $sql->fetchColumn();
        } catch (PDOException $th) {
            echo '#Erro ao listar os produtos#';
            return $th;
        }
        $this->desconectar();
    }

    function selectProdutos($pesquisa){
        global $pdo;
        $bd = new Table_Pedido();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT id_produto, nome, quantia, preco, quantia, tipo FROM produto WHERE LOWER(nome) LIKE LOWER(?) AND quantia > 0 AND tipo != 'Interno' LIMIT 5");
        try {
            $sql->execute(array($pesquisa . '%'));
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $th) {
            echo '#Erro ao listar os produtos#';
            return $th;
        }
        $this->desconectar();
    }
}