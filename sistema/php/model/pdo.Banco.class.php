<?php
interface iBanco
{
    public function conectar($nome = "mamaezona", $host = "localhost", $usuario = "root", $senha = "");
    public function desconectar();
}

/**
 * Classe de conexão ao banco:
 *  Cria a conexão com o banco de dados, e não cria objetos,
 * ao precisar fazer uma alteração no banco, deve-se extender esta classe
 * a outra classe que conterá os metodos de alteração. 
 * 
 * @copyright (c) 2019, Patrick Dantas ETEC Jardim Ângela
 */
abstract class Banco
{
    /**
     * @var object Recebe os comandos MySQL e os executa no banco através de um objeto do tipo PDO
     */
    protected $pdo;
    /**
     * @var string Retorna a mensagem de erro em caso de erros no MySQL
     */
    public $msg;

    /**
     * Método responsável pela conexão do banco, a conexão tem como codificação de caractéres o UTF-8.
     * 
     * @param string $nome Nome do banco de dados que sera usado na conexão atual, caso não seja passado parâmetro terá como valor padrão 'mamaezona'.
     * 
     * @param string $host Local de conexão do banco de dados, caso não seja passado parâmetro terá como padrão 'localhost'. 
     *
     * @param string $usuario Usuario do banco que fara a conexão, caso não informado terá como padrão 'root'.
     * 
     * @param string $senha Senha do usuario que conectará ao banco, caso não informado terá como padrão ''. 
     * 
     * @return int retorna o erro em caso do MySQL em casos de falha
     */
    function conectar($nome = "mamaezona", $host = "localhost", $usuario = "root", $senha = "")
    {
        global $pdo;
        try {
            $pdo = new PDO("mysql:dbname=" . $nome . "; host=" . $host, $usuario, $senha, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        } catch (PDOException $erro) {
            global $msg;
            $msg = $erro->getMessage();
            return $msg;
            header('HTTP/1.0 410 GONE');
        }
    }
    /**
     * Destrói a conexão com o banco de dados.
     */
    function desconectar()
    {
        global $pdo;
        $pdo = null;
    }
}
