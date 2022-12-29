<?php
require_once "../../model/itens_vendidos/vendidos.PDO.php";
require_once "../../model/produto/produto.class.php";
class Venda{
    private $quantia;
    private $id_produto;
    private $id_pedido;

    /**
     * @return mixed
     */
    public function getQuantia()
    {
        return $this->quantia;
    }

    /**
     * @param mixed $quantia
     */
    public function setQuantia($quantia)
    {
        $this->quantia = $quantia;
    }

    /**
     * @return mixed
     */
    public function getIdProduto()
    {
        return $this->id_produto;
    }

    /**
     * @param mixed $id_produto
     */
    public function setIdProduto($id_produto)
    {
        $this->id_produto = $id_produto;
    }

    /**
     * @return mixed
     */
    public function getIdPedido()
    {
        return $this->id_pedido;
    }

    /**
     * @param mixed $id_pedido
     */
    public function setIdPedido($id_pedido)
    {
        $this->id_pedido = $id_pedido;
    }

//---------------------------------------------------------------
    function salvarItensVendidos($id_pedido, $produtosLista){
        foreach ($produtosLista as $prod){
            $bd = new Table_Vendidos();
            $bd->insertItem($prod[2], $id_pedido, $prod[0]);
            $bd = new Produto();
            $bd->retirarEstoque($prod[2], $prod[0]);
        }
    }
}