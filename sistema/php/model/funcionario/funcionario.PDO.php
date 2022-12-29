<?php
require_once "../../model/pdo.Banco.class.php";
require_once "../../model/funcionario/funcionario.class.php";
/**
 * Classe responsável pelas alterações no banco na tabela funcionarios
 *
 * @copyright (c) 2019, ETEC Jardim Ângela.
 */
class Table_Funcionario extends Banco
{
    /**
     * Verifica se o usuário existe e se sua senha está correta
     *
     * @param string $login Nome do usuário no sistema
     * @param string $senha Senha do usuário
     * @return int $dados Retorna 0 senão existir, 1 se existir
     */
    function login($login, $email, $senha)
    {
        global $pdo;
        $bd = new Table_Funcionario();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT * FROM funcionarios WHERE `login` = ? AND `email` = ? AND `status` = ?");
        $sql->execute(array($login, $email, 1));
        $dados['verificacao'] = $sql->rowCount();
        if ($dados['verificacao'] == 1) {
            while ($col = $sql->fetch(PDO::FETCH_ASSOC)) {
                $senhaDB         = $col['senha'];
                $key             = $col['chave'];
                $dados['acesso'] = $col['acesso'];
                $dados['id']     = $col['id_funcionarios'];
                echo '<pre>';
                print_r($col);
            }

            if ($this->pass_decrypt($senha, $senhaDB, $key)) {
                $dados['log_teste'] = True;
                $dados['key'] = $key;
                echo '--- Encrypity-------';
            } else {
                $dados['log_teste'] = False;
                echo '----- NOT --------<br>';
            }
        }
        return $dados;
    }

    /**
     * Realiza a verificação da senha.
     *
     * @param string $pass Senha do usuário.
     *
     * @param string $passDB Senha armazenada no Banco.
     *
     * @param string $key Chave de verificação de senha.
     *
     * @return bool Retorna true caso a senha esteja correta, e false se errada.
     */
    private function pass_decrypt($pass, $passDB, $key)
    {
        $user_pass = hash_hmac('sha256', $pass, $key);
        return password_verify($user_pass, $passDB);
    }

    function log_bd_test($login, $email, $senha)
    {
        global $pdo;
        $bd = new Table_Funcionario();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT * FROM funcionarios WHERE `login` = ? AND `email` = ? `status` = ?");
        $sql->execute(array($login, $email, 1));
        $dados['verificacao'] = $sql->rowCount();
        if ($dados['verificacao'] == 1) {
            while ($col = $sql->fetch(PDO::FETCH_ASSOC)) {
                $senhaDB = $col['senha'];
            }
            $dados['senha'] = password_verify($senha, $senhaDB);
        }
        echo '<pre>' . print_r($dados) . '</pre>';
        return $dados;
    }

    /**
     * Retorna os dados de um funcionario pelo seu id
     *
     * @param integer $id Código unico de identificação do usuário
     *
     * @return array Retorna um array com os seguintes dados:
     *
     * 0 - id do funcionario
     *
     * 1 - nome do funcionario
     *
     * 2 - login do funcionario
     *
     * 3 - senha do funcionario
     *
     * 4 - acesso
     *
     * 5 - data de admissão
     *
     * 6 - data de dispensa
     *
     * 7 - status
     */
    function selectFuncionario($id)
    {
        global $pdo;
        $bd = new Table_Funcionario();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT * FROM funcionarios WHERE id_funcionarios = ?");
        $sql->execute(array($id));
        while ($col = $sql->fetch(PDO::FETCH_ASSOC)) {
            $dados[] = $col['id_funcionarios'];
            $dados[] = $col['nome'];
            $dados[] = $col['login'];
            $dados[] = $col['senha'];
            $dados[] = $col['acesso'];
            $dados[] = $col['admitido'];
            $dados[] = $col['dispensa'];
            $dados[] = $col['status'];
        }
        return $dados;
    }
    /**
     * Faz o INSERT do funcionario no banco.
     *
     * @param Funcionario $Funcionario Objeto Funcionario vindo da classe funcionario.
     * @return void
     */
    function insertFuncionario(Funcionario $Funcionario)
    {
        global $pdo;
        $bd = new Table_Funcionario();
        $bd->conectar();
        $sql = $pdo->prepare("INSERT INTO funcionarios (nome, `login`, email, senha, chave, acesso) VALUES (?, ?, ?, ?, ?, ?)");
        $sql->execute(array($Funcionario->getNome(), $Funcionario->getLogin(), $Funcionario->getEmail(), $Funcionario->getSenha(), $Funcionario->getKey(), $Funcionario->getAcesso()));
    }
    /**
     * Faz o Update de um funcionário pelo seu ID
     *
     * @param int $id ID do funcionario
     * @param Funcionario $Funcionario Objeto Funcionario vindo da classe funcionario.class.
     * @return void
     */
    function updateFuncionario($id, Funcionario $Funcionario)
    {
        global $pdo;
        $bd = new Table_Funcionario();
        $bd->conectar();
        $sql = $pdo->prepare("UPDATE `funcionarios` SET nome = ?, `login` = ?, senha = ?, acesso = ? WHERE id_funcionarios = ?;");
        $sql->execute(array($Funcionario->getNome(), $Funcionario->getLogin(), $Funcionario->getSenha(), $Funcionario->getAcesso(), $id));
    }

    /**
     * Desativa um funcionario no sistema e define a data em qual foi dispensado
     * no banco.
     * 
     * @param int $id Codigo do funcionario no sistema.
     * 
     * @return void
     */
    function deleteFuncionario($id)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $date = date('Y-m-d H:i');
        global $pdo;
        $bd = new Table_Funcionario();
        $bd->conectar();
        $sql = $pdo->prepare("UPDATE `funcionarios` SET `dispensa` = ?, `status` = 0 WHERE id_funcionarios = $id");
        $sql->execute(array($date));
    }

    function listarFuncionarioArray()
    {
        global $pdo;
        $bd = new Table_Funcionario();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT * FROM `funcionarios`");
        $sql->execute();
        while ($col = $sql->fetch(PDO::FETCH_ASSOC)) {
            $dados[] = $col['id_funcionarios'];
            $dados[] = $col['nome'];
            $dados[] = $col['login'];
            $dados[] = $col['email'];
            $dados[] = $col['acesso'];
            $dados[] = $col['admitido'];
            $dados[] = $col['dispensa'];
        }
        return "{\"data\":" . json_encode($dados) . '}';
    }

    final public function listarFuncionarioVendas($id)
    {
        global $pdo;
        $bd = new Table_Cliente();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT id_funcionarios AS id_cliente, nome AS nome_cliente FROM funcionarios WHERE id_funcionarios = ? AND `status` = 1");
        $sql->execute(array($id));
        return $sql->fetchAll();
    }
}
