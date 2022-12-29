<?php
require_once "../../model/pdo.Banco.class.php";
/**
 * Classe de conexão a tabela produto no banco de dados, é através dela que se realiza o CRUD com a tabela produto.
 */
class Table_Produto extends Banco
{
    /**
     * Faz o Insert de um novo produto no banco.
     *
     * @param Produto $Produto Objeto do tipo produto.
     *
     * @return PDOException Só tem retorno em casos de erro.
     */
    function insertProduto(Produto $Produto)
    {
        global $pdo;
        $bd = new Table_Produto();
        $bd->conectar();
        $sql = $pdo->prepare("INSERT INTO `produto` (`nome`, `marca`, `imagem`, `preco`, `custo`, `quantia`, `quantia_minima`, `tipo`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        try {
            $sql->execute(array($Produto->getNome(), $Produto->getMarca(), $Produto->getimagem(), $Produto->getPreco(), $Produto->getCusto(), $Produto->getQuantia(), $Produto->getQuantiaMinima(), $Produto->getTipo()));
        } catch (PDOException $th) {
            echo '#Erro ao inserir o produto#';
            return $th;
        }
        $bd->desconectar();
    }

    /**
     * Atualiza um registro no banco.
     *
     * @param int $id Código do registro a ser alterado.
     *
     * @param object $Produto Objeto do tipo produto contendo os dados do produto.
     *
     * @return string Retorna somente em casos de erro.
     */
    function updateProduto($id, Produto $Produto)
    {
        global $pdo;
        $bd = new Table_Produto();
        $bd->conectar();
        $sql = $pdo->prepare("UPDATE produto SET nome = ?, marca = ?, imagem = ?, preco = ?, custo = ?, quantia = ?, quantia_minima = ?, tipo = ?, `status` = ? WHERE id_produto = ?");
        try {
            $sql->execute(array($Produto->getNome(), $Produto->getMarca(), $Produto->getimagem(), $Produto->getPreco(), $Produto->getCusto(), $Produto->getQuantia(), $Produto->getQuantiaMinima(), $Produto->getTipo(), $Produto->getStatus(), $id));
        } catch (PDOException $th) {
            echo '#Impossivel alterar os dados, verifique e tente novamente#';
            return $th;
        }
        $bd->desconectar();
    }

    /**
     * Seleciona um produto pelo seu ID.
     *
     * @param int $id ID relativo ao produto a ser selecionado.
     *
     * @return string Retorna somente em casos de erro.
     */
    function selectProduto($id)
    {
        global $pdo;
        $bd = new Table_Produto();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT * FROM `produto` WHERE id_produto = ?");
        try {
            $sql->execute(array($id));
            while ($col = $sql->fetch(PDO::FETCH_ASSOC)) {
                $dados['nome']           = $col['nome'];
                $dados['marca']          = $col['marca'];
                $dados['imagem']         = $col['imagem'];
                $dados['preco']          = $col['preco'];
                $dados['custo']          = $col['custo'];
                $dados['quantia']        = $col['quantia'];
                $dados['quantia_minima'] = $col['quantia_minima'];
                $dados['tipo']           = $col['tipo'];
            }
            return $dados;
        } catch (PDOException $th) {
            echo '#Erro de seleção, verifique e tente novamente#';
            return $th;
        }

        $bd->desconectar();
    }


    /**
     * Seleciona um produto pelo seu ID e retorna um json compatível com o datatables.
     *
     * @param int $id ID relativo ao produto a ser selecionado.
     *
     * @return string Retorna json ou um caso de erro.
     */
    function selectProdutoJson($id)
    {
        global $pdo;
        $bd = new Table_Produto();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT * FROM `produto` WHERE id_produto = ?");
        try {
            $sql->execute(array($id));
            while ($col = $sql->fetch(PDO::FETCH_ASSOC)) {
                $dados['nome']           = $col['nome'];
                $dados['marca']          = $col['marca'];
                $dados['imagem']         = $col['imagem'];
                $dados['preco']          = $col['preco'];
                $dados['custo']          = $col['custo'];
                $dados['quantia']        = $col['quantia'];
                $dados['quantia_minima'] = $col['quantia_minima'];
                $dados['tipo']           = $col['tipo'];
            }
            return '{\"data\":' . json_encode($dados) . '}';
        } catch (PDOException $th) {
            echo '#Erro de seleção, verifique e tente novamente#';
            return $th;
        }
        $bd->desconectar();
    }

    /**
     * Desativa um produto no sistema pelo seu ID.
     *
     * @param int $id ID do produto a ser desativado.
     *
     * @return string Somente retorna em casos de erro.
     */
    function deleteProduto($id)
    {
        global $pdo;
        $bd = new Table_Produto();
        $bd->conectar();
        $sql = $pdo->prepare("UPDATE `produto` SET `status` = 'Desativo' WHERE id_produto = ?");
        try {
            $sql->execute(array($id));
        } catch (PDOException $th) {
            echo '#Não foi possível deletar o produto#';
            return $th;
        }
        $bd->desconectar();
    }


    /**
     * Retorna um array com todos os produtos ativos no sistema.
     *
     * @return array Lista dos produtos e seus relativos dados.
     */
    function listarProdutosArray()
    {
        global $pdo;
        $bd = new Table_Produto();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT id_produto, nome, marca, tipo, quantia, quantia_minima, custo, preco FROM `produto` WHERE `status` = 'Ativo' AND `tipo` != 'Interno'");
        try {
            $sql->execute();
            $dados = $sql->fetchAll();
            return $dados;
        } catch (\Throwable $th) {
            echo '#Erro ao listar os produtos#';
            return $th;
        }
        $bd->desconectar();
    }

    /**
     * Retorna um array com todos os produtos ativos no sistema.
     *
     * @return array Lista dos produtos e seus relativos dados.
     */
    function listarEstoqueArray()
    {
        global $pdo;
        $bd = new Table_Produto();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT id_produto, nome, marca, tipo, status, quantia, quantia_minima, custo, preco FROM `produto`");
        try {
            $sql->execute();
            $dados = $sql->fetchAll();
            return $dados;
        } catch (\Throwable $th) {
            echo '#Erro ao listar os produtos#';
            return $th;
        }
        $bd->desconectar();
    }

    /**
     * Lista os produtos junto da função de excluir e alterar, SOMENTE PARA TESTES.
     *
     * @return void
     */
    function listarProduto()
    {
        global $pdo;
        $bd = new Table_Produto();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT `id_produto`, `nome_produto`, `tipo`, `marca`, `preco`, `estoque_id_estoque`, `custo`, `status_produto` FROM `produto` WHERE `status_produto` = 1");
        $sql->execute();
        echo "<table class='table table-bordered table-striped text-center container'>
                <tr class='thead-dark'>
                    <th>ID</th>
                    <th>NOME</th>
                    <th>MARCA</th>
                    <th>IMAGEM</th>
                    <th>PRECO</th>
                    <th>CUSTO</th>
                    <th>QUANTIA</th>
                    <th>QUANTIA MINIMA</th>
                    <th>TIPO</th>
                    <th>STATUS</th>
                    <th>AÇÕES</th>
                </tr>";
        while ($col = $sql->fetch(PDO::FETCH_ASSOC)) {
            $id             = $col['id_produto'];
            $nome           = $col['nome'];
            $marca          = $col['marca'];
            $imagem         = $col['imagem'];
            $preco          = $col['preco'];
            $custo          = $col['custo'];
            $quantia        = $col['quantia'];
            $quantia_minima = $col['quantia_minima'];
            $tipo           = $col['tipo'];
            $status         = $col['status'];

            echo "
                <tr>
                    <td>$id</td>
                    <td><a href='produtos.Update.php?id=$id'>$nome</a></td>
                    <td>$marca</td>
                    <td>$imagem</td>
                    <td>$preco</td>
                    <td>$custo</td>
                    <td>$quantia</td>
                    <td>$quantia_minima</td>
                    <td>$tipo</td>
                    <td>$status</td>
                    <td><a href='../../controller/produto/produto.Excluir.php?id=$id'>Excluir</a></td>
                </tr>";
        }
        echo '</table>';
        $bd->desconectar();
    }

    /**
     * Aumenta a quantidade de um produto pelo seu ID.
     *
     * @param int $quantia Quantidade a ser somada ao produto.
     *
     * @param int $id Id do produto a ter sua quantidade alterada.
     *
     * @return string Retorna somente em casos de erro.
     */
    function updateEstoque($quantia, $id)
    {
        global $pdo;
        $bd = new Table_Produto();
        $bd->conectar();
        $sql = $pdo->prepare("UPDATE `produto` SET `quantia` = `quantia` + ? WHERE `id_produto` = ? AND `tipo` != 'Preparo'");
        try {
            $sql->execute(array($quantia, $id));
            $sql = $pdo->prepare("SELECT COUNT(*) FROM produto WHERE id_produto = ? AND tipo = 'Preparo'");
            $sql->execute(array($id));
            $test = $sql->fetchColumn();
            if($test > 0){
                echo '#DeletarInvalidoPreparo#';
            }
        } catch (PDOException $th) {
            echo '#Erro ao atualizar a quantidade#';
            return $th;
        }
        $bd->desconectar();
    }

    /**
     * Verifica o tipo do produto,se for do tipo Preparo, ele deve bloquear a adição de quantidade
     *
     * @param string $nome Nome do produto
     *
     * @return bool
     */
    function produtoNome($nome)
    {
        global $pdo;
        $bd = new Table_Produto();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT * FROM `produto` WHERE nome = ?");
        $sql->execute(array($nome));
        $data = $sql->rowCount();
        if ($data == 0) {
            return false;
        } else if ($data == 1) {
            while ($col = $sql->fetch(PDO::FETCH_ASSOC)) {
                $id = $col['id_produto'];
                $tipo = $col['tipo'];
            }
            if ($tipo == 'Preparo') {
                echo '#AdiçãoInvalidaPreparo#';
                return -1;
            } else {
                return $id;
            }
        }
        $bd->desconectar();
    }

    function selectNotificacoes(){
        global $pdo;
        $bd = new Table_Produto();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT produto.id_produto AS id, produto.nome, produto.quantia AS quantidade, produto.quantia_minima AS quantidade_minima FROM produto WHERE produto.quantia <= produto.quantia_minima AND produto.tipo != 'Preparo' AND `status` = 'Ativo'");
        $sql->execute();
        return $sql->fetchAll();
    }
}
