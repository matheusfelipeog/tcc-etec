<?php
require_once "../../model/security.class.php";
require_once "../../model/pdo.Banco.class.php";
require_once "../../model/cliente/cliente.class.php";

// Classe de CRUD da tabela Cliente
$verificar = new Seguranca();
/**
 * Interface da classe Table_Cliente
 */
interface iTable_Cliente
{
    public function insertCliente(Cliente $Cliente);
    public function selectCliente($id);
    public function updateCliente($id, Cliente $Cliente);
    public function deleteCliente($id);
    public function listarClientesArray();
    public function listarClientes();
    public function listarClientesVendas($id);
}
/**
 * Classe responsável pelas alterações de cliente no banco. Aqui contém somente as 
 * consultas e comandos MySQL.
 */
class Table_Cliente extends Banco implements iTable_Cliente
{
    /**
     * Cadastra um cliente no banco.
     * 
     * @param Cliente $Cliente recebe um objeto do tipo cliente.
     * 
     * @return void
     */
    final function insertCliente(Cliente $Cliente)
    {
        global $pdo;
        $bd = new Table_Cliente();
        $bd->conectar();
        // verifica se os dados do cliente estão corretos e de acordo com o banco
        try {
            if ($this->verificarCliente($Cliente->getNome())) {
                $sql = $pdo->prepare("INSERT INTO `cliente`(`nome_cliente`, `situacao`, `descricao`, `tipo_cliente`, `status_cliente`) VALUES(?, ?, ?, ?, ?)");
                $sql->execute(array($Cliente->getNome(), $Cliente->getSituacao(), $Cliente->getDescricao(), $Cliente->getTipo(), $Cliente->getStatus()));
                echo 'Cliente Salvo';
            } else {
                echo 'Cliente Falhou';
                return 050;
            }
        } catch (PDOException $th) {
            echo '#Erro ao salvar o Cliente#';
        }

        $bd->desconectar();
    }

    /**
     * Seleciona um cliente do banco pelo id e retorna seus dados.
     * 
     * @param int $id ID do cliente no banco.
     * 
     * @return array retorna um array com os dados do cliente na seguinte ordem:
     * 
     * 
     * 0 - Nome do Cliente.
     * 
     * 1 - Situação 'Se o cliente está devendo, atrasado ou positivo'.
     * 
     * 2 - Descrição.
     * 
     * 3 - Tipo 'Se o cliente é comum ou mensal'.
     * 
     * 4 - Status 'Se o cliente está ativo no sistema ou não'.
     */
    final function selectCliente($id)
    {
        global $pdo;
        $bd = new Table_Cliente();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT `nome_cliente`, `situacao`, `descricao`, `tipo_cliente`, `status_cliente` FROM `cliente` WHERE id_cliente = ?");
        try {
            $sql->execute(array($id));
            while ($col = $sql->fetch(PDO::FETCH_ASSOC)) {
                $dados[] = $col['nome_cliente'];
                $dados[] = $col['situacao'];
                $dados[] = $col['descricao'];
                $dados[] = $col['tipo_cliente'];
                $dados[] = $col['status_cliente'];
            }
            return $dados;
        } catch (\Throwable $th) {
            echo '#Erro ao selecionar o cliente#';
        }

        $bd->desconectar();
    }

    /**
     * Atualiza os dados de um cliente pelo seu ID
     * 
     * @param int $id ID do cliente respectivo no banco.
     * 
     * @param Cliente $Cliente Objeto do tipo cliente contendo as informações que serão alteradas.
     * 
     * @return bool retorna 'true' se tudo ocorrer bem, caso não retorna o erro do  
     * MySQL 
     */
    final function updateCliente($id, Cliente $Cliente)
    {
        global $pdo;
        $bd = new Table_Cliente();
        $bd->conectar();
        $sql = $pdo->prepare('UPDATE `cliente` SET `nome_cliente`=?,`situacao`=?,`descricao`=? , `tipo_cliente` = ?, `status_cliente` = ? WHERE `id_cliente` = ?');
        try {
            $sql->execute(array($Cliente->getNome(), $Cliente->getSituacao(), $Cliente->getDescricao(), $Cliente->getTipo(), $Cliente->getStatus(), $id));
            return true;
        } catch (PDOException $erro) {
            return $erro;
        }
        $bd->desconectar();
    }


    /**
     * Desativa um cliente pelo ID.
     * 
     * @param int $id ID do cliente relativo ao banco.
     */
    final function deleteCliente($id)
    {
        global $pdo;
        $bd = new Table_Cliente();
        $bd->conectar();
        $sql = $pdo->prepare("UPDATE `cliente` SET `status_cliente` = 'Desativo' WHERE `id_cliente` = ?");
        try {
            $sql->execute(array($id));
            echo "!Excluidos com sucesso!";
        } catch (\Throwable $th) {
            echo '#Erro ao deletar o cliente#';
        }
        $bd->desconectar();
    }

    /**
     * Retorna um json listando todos os cliente para que se possa utiliza-lo no AJAX.
     * 
     * @return array $dados Lista de todos os clientes
     */
    final public function listarClientesArray()
    {
        global $pdo;
        $bd = new Table_Cliente();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT id_cliente, nome_cliente, situacao, divida, tipo_cliente, `status_cliente`, DATE_FORMAT(data_cliente, '%d/%m/%Y') as data_cliente, descricao FROM devedores");
        $sql->execute();
        return $sql->fetchAll();
    }

    final public function listarClientesVendas($id)
    {
        global $pdo;
        $bd = new Table_Cliente();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT id_cliente, nome_cliente FROM cliente WHERE id_cliente = ? AND `status_cliente` = 'Ativo'");
        $sql->execute(array($id));
        return $sql->fetchAll();
    }
    /**
     * Listar clientes com opções de exclusão e alterar, SOMENTE PARA TESTES
     */
    final function listarClientes()
    {
        global $pdo;
        $bd = new Table_Cliente();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT * FROM cliente WHERE `status_cliente` = 1 ORDER BY `nome_cliente`");
        $sql->execute();
        $i = 0;
        echo "
        <table class='table table-bordered table-striped text-center container'>
            <tr class='thead-dark'>
                <th>ID</th>
                <th>Nome</th>
                <th>Situação</th>
                <th>Descrição</th>
                <th>tipo</th>
            </tr>
        ";
        while ($col = $sql->fetch(PDO::FETCH_ASSOC)) {
            $id        = $col['id_cliente'];
            $nome      = $col['nome_cliente'];
            $situacao  = $col['situacao'];
            $descricao = $col['descricao'];
            echo "
                <tr>
                    <td>$id</td>
                    <td><a href = 'cliente.Update.php?id=$id'>$nome</a></td>
                    <td>$situacao</td>
                    <td>$descricao</td>
                    <td><a href='../../controller/cliente/cliente.Excluir.php?id=$id'>Excluir</a></td>
                </tr>
            ";
            $i++;
        }
        echo "</table>";
        $bd->desconectar();
    }

    /**
     * Verifica se um cliente existe antes de Cadastra-lo.
     *
     * @param string $nome Nome do cliente que será cadastrado.
     * 
     * @return bool Caso o cliente não exista no banco ele retorna 'TRUE' se o cliente 
     * existir retorna 'FALSE'.
     */
    final function verificarCliente($nome)
    {
        global $pdo;
        $bd = new Table_Cliente();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT COUNT(*) FROM `cliente` WHERE nome_cliente = ?");
        try {
            $sql->execute(array($nome));
            $data = $sql->fetchColumn();
            while ($col = $sql->fetchAll(PDO::FETCH_ASSOC)) {
                $id = $col['id_produto'];
            }
            if ($data == 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $th) {
            echo '#Erro ao verificar o cliente#';
        }
    }

    /**
     * Define um cliente para o status 'Ativo'
     * 
     * @param int $id ID so cliente a ser ativado
     * 
     * @return void
     */
    function ativarCliente($id)
    {
        global $pdo;
        $bd = new Table_Cliente();
        $bd->conectar();
        $sql = $pdo->prepare("UPDATE cliente SET status_cliente = ? WHERE id_cliente = ?");
        try {
            $sql->execute(array('Ativo', $id));
        } catch (\Throwable $th) {
            echo '#Erro ao ativar o cliente#';
        }
    }

    /**
     * Define um cliente para o status 'Desativo'
     * 
     * @param int $id ID so cliente a ser ativado
     * 
     * @return void
     */
    function desativarCliente($id)
    {
        global $pdo;
        $bd = new Table_Cliente();
        $bd->conectar();
        $sql = $pdo->prepare("UPDATE cliente SET status_cliente = ? WHERE id_cliente = ?");
        try {
            $sql->execute(array('Desativo', $id));
        } catch (\Throwable $th) {
            echo '#Erro ao desativar o cliente#';
        }
    }

    function addCredito($credito, $id_cliente){
        global $pdo;
        $bd = new Table_Cliente();
        $bd->conectar();
        $sql = $pdo->prepare("UPDATE cliente SET credito = credito + ? WHERE id_cliente = ?");
        $sql->execute(array($credito, $id_cliente));
    }
}
