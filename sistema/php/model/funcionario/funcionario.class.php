<?php

require_once "funcionario.PDO.php";
$bd = new Table_Funcionario();

/**
 * Classe que representa um funcionário, faz a verificação dos dados antes de qualquer alteração no banco, para qualquer tarefa relacionada ao funcionario deve ser criada nesta classe.
 */
class Funcionario
{
    /**
     * @var string $nome nome do funcionario
     *
     * @var string $login nome do usuario no sistema
     *
     * @var string $senha senhado usuario
     *
     * @var string $acesso define nivel de acesso de usuário
     */
    private $nome;
    private $login;
    private $email;
    private $senha;
    private $acesso;
    private $key;

    // ------------------ Getters ---------------
    function getNome()
    {
        return $this->nome;
    }

    function getLogin()
    {
        return $this->login;
    }

    function getEmail()
    {
        return $this->email;
    }

    function getSenha()
    {
        return $this->senha;
    }

    function getAcesso()
    {
        return $this->acesso;
    }

    function getKey()
    {
        return $this->key;
    }

    // --------------------- Setters ---------------
    function setNome($n)
    {
        $this->nome = $n;
    }

    function setLogin($l)
    {
        $this->login = $l;
    }

    function setEmail($e)
    {
        $this->email = $e;
    }

    function setSenha($s)
    {
        $key = MD5('key-mamaezona-' . mt_rand());
        $this->key = $key;
        $this->senha = password_hash(hash_hmac('sha256', $s, $key), PASSWORD_ARGON2I);
    }

    function setAcesso($a)
    {
        $this->acesso = $a;
    }
    // --------------------------------------------------
    /**
     * Realiza o login do usuário, caso o login e a senha estejam corretos,
     * abre uma sessão para o usuario.
     *
     * @param string $login nome do usuario no sistema
     * @param string $senha senha do usuario
     * @return void
     */
    function logar($login, $email, $senha)
    {
        global $bd;
        $dados = $bd->login($login, $email, $senha);
        echo '<pre>' . print_r($dados) . '</pre>';
        if ($dados['verificacao'] == 1 && $dados['log_teste'] == True) {
            session_start();
            $_SESSION['login'] = $login;
            $_SESSION['email'] = $email;
            $_SESSION['passHash'] = hash_hmac('sha256', $senha, $dados['key']);
            $_SESSION['acesso'] = $dados['acesso'];
            if ($_SESSION['acesso'] == 'CM') {
                header("location: ../../view/funcionario/funcionario.Usuario.php");
            } else if ($_SESSION['acesso'] == 'US') {
                header("location: ../../view/funcionario/funcionario.Gerente.php");
            } else {
                session_destroy();
                header("location: ../../view/funcionario/funcionario.Main.php");
            }
        } else {
            header("location: ../../view/login.php");
        }
    }

    /**
     * Testa se o login foi realizado checando as variaveis de sessão e as comparando no banco, se não estiverem definidas ou não baterem no banco a sessãoe destruida.
     *
     * @return void
     */
    static function log_teste()
    {
        global $bd;
        if (!isset($_SESSION)) {
            
            //header("Location: ../../view/login.php");
        } else {
            if (!isset($_SESSION['login']) || !isset($_SESSION['email'])) {
                header('HTTP/1.0 401 Não Autorizado');
                session_destroy();
                header("Location: ../../view/login.php");
            } else {
                $dados = $bd->log_bd_test($_SESSION['login'], $_SESSION['email'], $_SESSION['passHash']);
                if ($dados['login'] != $_SESSION['login'] || $dados['email'] != $_SESSION['email'] || $dados['senha'] != true) {
                    header('HTTP/1.0 401 Não Autorizado');
                    session_destroy();
                    header("Location: ../../view/login.php");
                } else{
                    return True;
                    header('HTTP/1.0 200 OK');
                }
            }
        }
    }
    /**
     * Insere os dados em um objeto funcionario
     *
     * @var string $nome nome do funcionario
     *
     * @var string $login nome do usuario no sistema
     *
     * @var string $senha senhado usuario
     *
     * @var string $acesso define nivel de acesso de usuário
     *
     * @return void
     */
    private function dadosFuncionario($nome, $login, $email, $senha, $acesso = 'CM')
    {
        $this->setNome($nome);
        $this->setLogin($login);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setAcesso($acesso);
    }

    /**
     * Verifica os dados do funcionário antes de inserir no objeto, caso corretos o os envia para serem salvos no banco.
     *
     * @param string $nome nome do funcionario
     *
     * @param string $login nome do usuario no sistema
     *
     * @param string $senha senhado usuario
     *
     * @param string $acesso define nivel de acesso de usuário
     *
     * @return void
     */
    function salvarFuncionario($nome, $login, $email, $senha, $acesso = 'CM')
    {
        global $bd;
        $this->dadosFuncionario($nome, $login, $email, $senha, $acesso);
        $bd->insertFuncionario($this);
    }

    /**
     * Atualiza os dados de um funcionario.
     * 
     * @param int $id Codigo do funcionario que será atualizado.
     * 
     * @param string $nome nome do funcionario.
     * 
     * @param string $login nome do funcionario no sistema.
     *
     * @param string $login nome do usuario no sistema.
     *
     * @param string $senha senhado usuario.
     *
     * @param string $acesso define nivel de acesso de usuário.
     * 
     * @return void
     */
    function atualizarFuncionario($id, $nome, $login, $email, $senha, $acesso = 'CM')
    {
        global $bd;
        $this->dadosFuncionario($nome, $login, $email, $senha, $acesso);
        $bd->updateFuncionario($id, $this);
    }


    function listarFuncionarioConsumo($id)
    {
        global $bd;
        $data['cliente'] = $bd->listarFuncionarioVendas($id);
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Desativa um funcionario no sistema.
     * 
     * @param int $id Código do funcionario.
     * 
     * @return void
     */
    function excluirFuncionario($id)
    {
        global $bd;
        $bd->deleteFuncionario($id);
    }
}
