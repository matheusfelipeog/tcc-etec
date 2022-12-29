<?php
require_once "../../model/produto/produto.PDO.php";
require_once '../../model/produto/produto.class.php';
$bd = new Table_Produto();
interface iProduto
{ }

class Produto
{
    private $nome;
    private $marca;
    private $imagem;
    private $preco;
    private $custo;
    private $quantia;
    private $quantia_minima;
    private $tipo;
    private $status;
    // -------------- GETTERS ---------------
    function getNome()
    {
        return $this->nome;
    }

    function getMarca()
    {
        return $this->marca;
    }

    function getimagem()
    {
        return $this->imagem;
    }

    function getPreco()
    {
        return $this->preco;
    }

    function getCusto()
    {
        return $this->custo;
    }

    function getQuantia()
    {
        return $this->quantia;
    }

    function getQuantiaMinima()
    {
        return $this->quantia_minima;
    }

    function getTipo()
    {
        return $this->tipo;
    }

    function getStatus()
    {
        return $this->status;
    }

    // --------- SETTERS ------------
    function setNome($nome)
    {
        $this->nome = stripslashes($nome);
    }

    function setMarca($marca)
    {
        $this->marca = stripslashes($marca);
    }

    function setImagem($img)
    {
        $this->imagem = stripslashes($img);
    }

    function setPreco($preco)
    {
        $this->preco = stripslashes($preco);
    }

    function setCusto($custo)
    {
        $this->custo = stripslashes($custo);
    }

    function setQuantia($q)
    {
        $this->quantia = stripslashes($q);
    }

    function setQuantiaMinima($qm)
    {
        $this->quantia_minima = stripslashes($qm);
    }
    /**
     * Define o tipo do produto de acordo com o valor recebido
     *
     * 1 - 'Comum'
     *
     * 2 - 'Preparo'
     *
     * 3 - 'Interno'
     *
     * @param int $tipo Valor relativo ao tipo
     *
     * @return void
     */
    function setTipo($tipo)
    {
        switch ($tipo) {
            case 1:
                $this->tipo = 'Comum';
                break;
            case 2:
                $this->tipo = 'Preparo';
                $this->quantia = 1;
                $this->quantia_minima = 0;
                break;
            case 3:
                $this->tipo = 'Interno';
                break;
        }
    }

    function setStatus($status)
    {
      switch ($status) {
          case 1:
              $this->status = 'Ativo';
              break;
          case 2:
              $this->status = 'Desativo';
              break;
      }
    }
    // -------------- Métodos ----------------
    /**
     * Define os dados de um objeto produto
     *
     * @param string $nome Nome do Produto
     *
     * @param string $marca Marca do Produto
     *
     * @param string $imagem Caminho da imagem do produto
     *
     * @param double $preco Preço do produto
     *
     * @param double $custo Custo ao dono do produto
     *
     * @param int $quantia Quantidade do produto
     *
     * @param int $quantia_minima Quantidade minima que este produto deve ter no estoque
     *
     * @param string $tipo Se este produto precisa ser preparado, ou se é comum, ou se é interno
     *
     * @param string $status Se o produto esta ativo ou Desativo
     *
     * @return void
     */
    private function dadosProduto($nome, $marca, $imagem, $preco, $custo, $quantia, $quantia_minima, $tipo, $status = 1)
    {
        $this->setNome($nome);
        $this->setMarca($marca);
        $this->setImagem($imagem);
        $this->setPreco($preco);
        $this->setCusto($custo);
        $this->setQuantia($quantia);
        $this->setQuantiaMinima($quantia_minima);
        $this->setTipo($tipo);
        $this->setStatus($status);
    }

    /**
     * Cadastra um produto no sistema
     *
     * @param string $nome Nome do Produto
     *
     * @param string $marca Marca do Produto
     *
     * @param string $imagem Caminho da imagem do produto
     *
     * @param double $preco Preço do produto
     *
     * @param double $custo Custo ao dono do produto
     *
     * @param int $quantia Quantidade do produto
     *
     * @param int $quantia_minima Quantidade minima que este produto deve ter no estoque
     *
     * @param string $tipo Se este produto precisa ser preparado, ou se é comum, ou se é interno
     *
     * @return void
     */
    function cadastroProduto($nome, $marca, $imagem, $preco, $custo, $quantia, $quantia_minima, $tipo)
    {
        $bd = new Table_Produto();
        $this->dadosProduto($nome, $marca, $imagem, $preco, $custo, $quantia, $quantia_minima, $tipo);
        $bd->insertProduto($this);
    }

    /**
     * Atualiza um produto no sistema
     *
     * @param int $id Código do produto no sistema
     *
     * @param string $nome Nome do Produto
     *
     * @param string $marca Marca do Produto
     *
     * @param string $imagem Caminho da imagem do produto
     *
     * @param double $preco Preço do produto
     *
     * @param double $custo Custo ao dono do produto
     *
     * @param int $quantia Quantidade do produto
     *
     * @param int $quantia_minima Quantidade minima que este produto deve ter no estoque
     *
     * @param string $tipo Se este produto precisa ser preparado, ou se é comum, ou se é interno
     *
     * @return void
     */
    function alterarProduto($id, $nome, $marca, $imagem, $preco, $custo, $quantia, $quantia_minima, $tipo, $status)
    {
        $bd = new Table_Produto();
        $this->dadosProduto($nome, $marca, $imagem, $preco, $custo, $quantia, $quantia_minima, $tipo, $status);
        $bd->updateProduto($id, $this);
    }

    /**
     * Desativa produtos no sistema
     *
     * @param array $id Lista dos IDs a serem desativados
     *
     * @return void
     */
    function excluirProduto($id)
    {
        $bd = new Table_Produto();
        foreach ($id as $key => $value) {
            $bd->deleteProduto($value);
        }
    }

    /**
     * Adiciona quantidade a um produto
     *
     * @param int $quantia Quantidade a ser somada ao produto
     *
     * @param int $id Id do produto a ter a quantidade redefinida
     *
     * @return void
     */
    function adicionarEstoque($quantia, $id = -1)
    {
        $bd = new Table_Produto();
        if ($id <= 0) { } else {
            $bd->updateEstoque($quantia, $id);
        }
    }

    /**
     * Retira quantidade a um produto
     *
     * @param int $quantia Quantidade a ser retirada ao produto
     *
     * @param int $id Id do produto a ter a quantidade redefinida
     *
     * @return void
     */
    function retirarEstoque($quantia, $id)
    {
        $bd = new Table_Produto();
        if ($id < 0) { } else {
            $bd->updateEstoque(-1 * $quantia, $id);
        }
    }

    /**
     * Lista os produtos de forma compativel com o datatables no Front
     *
     * @return void
     */
    function listarProdutos()
    {
        $bd = new Table_Produto();
        $data['data'] = $bd->listarProdutosArray();
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Verifica se um produto é do tipo 'Preparo', caso seja retorna false
     * se não for ele retorna o ID do produto
     *
     * @param string $nome Nome do produto
     *
     * @return bool Retorna falso se o produto for do tipo preparo, caso não retorna o ID do produto
     */
    function verificarProduto($nome)
    {
        $bd = new Table_Produto();
        return $bd->produtoNome($nome);
    }

    function notificacoes(){
        $bd = new Table_Produto();
        $data['lista_de_notificacao'] = $bd->selectNotificacoes();
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

}
