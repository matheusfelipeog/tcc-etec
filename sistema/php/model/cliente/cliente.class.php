<?php
require_once "../../model/security.class.php";
require_once "cliente.PDO.php";
$teste_unitario = new Seguranca();
$bd = new Table_Cliente();


/**
 * Interface para classe Cliente
 */
interface iCliente
{
    public function getNome();
    public function getSituacao();
    public function getDescricao();
    public function getTipo();

    public function setNome($n);
    public function setSituacao($s);
    public function setDescricao($d);
    public function setTipo($t);

    public function cadastroCliente($nome, $situacao, $descricao, $tipo);
    public function atualizarCliente($id, $nome, $situacao, $descricao, $tipo, $status);
    public function excluirCliente($id);
}
/**
 * Classe responsável pelos dados do cliente e de aplicar as regras de negócio.
 * 
 * @copyright (c) 2019, Patrick Dantas ETEC Jardim Ângela. 
 */
final class Cliente implements iCliente
{
    private $nome;
    private $situacao;
    private $descricao;
    private $tipo;
    private $status;

    // Getters

    function getNome()
    {
        return $this->nome;
    }

    function getSituacao()
    {
        return $this->situacao;
    }

    function getDescricao()
    {
        return $this->descricao;
    }

    function getTipo()
    {
        return $this->tipo;
    }

    function getStatus()
    {
        return $this->status;
    }

    // Setters

    function setNome($n)
    {
        $this->nome = $n;
    }

    /**
     * Recebe um valor de 1 a 3 e dependendo do valor define a situação do cliente:
     * 
     * 1 - Em dia
     * 
     * 2 - Em Aberto
     * 
     * 3 - Em débito
     * 
     * @param int $s valor relativo a situação
     * 
     * @return void
     */
    function setSituacao($s)
    {
        switch ($s) {
            case 1:
                $this->situacao = 'Em dia';
                break;
            case 2:
                $this->situacao = 'Em aberto';
                break;
            case 3:
                $this->situacao = 'Em débito';
                break;
        }
    }


    function setDescricao($d)
    {
        $this->descricao = $d;
    }

    /**
     * Define o tipo do cliente de acordo com o valor a receber:
     * 
     * 1 - Comum
     * 
     * 2 - Mensal
     * 
     * @param int $t Valor referente ao tipo do cliente.
     * 
     * @return void
     */
    function setTipo($t)
    {
        switch ($t) {
            case 1:
                $this->tipo = 'Comum';
                break;

            case 2:
                $this->tipo = 'Mensal';
                break;
        }
    }

    /**
     * Define se um cliente está ou não ativo no sistema:
     * 
     * 1 - Ativo
     * 
     * 2 - Desativo
     * 
     * @param int $s Número relativo ao status do cliente
     * 
     * @return void
     */
    function setStatus($s)
    {
        switch ($s) {
            case 1:
                $this->status = 'Ativo';
                break;
            case 2:
                $this->status = 'Desativo';
                break;
        }
    }

    // ----------------------------------------------------------------

    /**
     * Define os dados de um Cliente.
     * 
     * @param string $nome Nome do Cliente.
     * 
     * @param string $situacao Situação do cliente, divida, atraso ou positivo.
     * 
     * @param string $descricao Breve descrição do cliente.
     * 
     * @param string $tipo Se o cliente é 'C' Comum ou 'M' Mensal.
     * 
     * @param string $status Se o cliente está ou não ativo no sistema, tem 'Ativo' como valor padrão
     * 
     * @return void
     */
    private function dadosCliente($nome, $situacao, $descricao, $tipo, $status = 1)
    {
        $this->setNome($nome);
        $this->setSituacao($situacao);
        $this->setDescricao($descricao);
        $this->setTipo($tipo);
        $this->setStatus($status);
    }

    /**
     * Faz as verificações de segurança nos dados do cliente e caso todas 
     * passarem na verificação, elas serão salvas no banco.
     * 
     * @param string $nome Nome do Cliente.
     * 
     * @param string $situacao Situação do cliente, divida, atraso ou positivo.
     * 
     * @param string $descricao Breve descrição do cliente.
     * 
     * @param string $tipo Se o cliente é 'C' Comum ou 'M' Mensal.
     */
    final function cadastroCliente($nome, $situacao, $descricao, $tipo)
    {
        global $bd;
        global $teste_unitario;
        $this->dadosCliente($nome, $situacao, $descricao, $tipo);
        //if ($teste_unitario->clienteTestes($this)) {
            $bd->insertCliente($this);
        /*} else {
            echo '#Os dados do cliente contém erros#';
            header("HTTP/1.0 400 Inválida");
        }*/
    }

    /**
     * Atualiza os dados do cliente.
     * 
     * @param int $id Codigo do cliente a ter suas informações alteradas.
     * 
     * @param string $nome Nome do Cliente.
     * 
     * @param string $situacao Situação do cliente, divida, atraso ou positivo.
     * 
     * @param string $descricao Breve descrição do cliente.
     * 
     * @param string $tipo Se o cliente é 'C' Comum ou 'M' Mensal.
     */
    final function atualizarCliente($id, $nome, $situacao, $descricao, $tipo, $status)
    {
        global $bd;
        global $teste_unitario;
        $this->dadosCliente($nome, $situacao, $descricao, $tipo, $status);
        if ($teste_unitario->clienteTestes($this)) {
            $bd->updateCliente($id, $this);
        } else {
            header("HTTP/1.0 400 Inválida");
        }
    }
    /**
     * Desativa clientes na base de dados.
     * 
     * @param array $id ID dos clientes no banco.
     * 
     * @return void
     */
    final function excluirCliente($id)
    {
        global $bd;
        foreach ($id as $key => $value) {
            $bd->deleteCliente($value);
        }
    }


    /**
     * Lista os clientes comum json
     * 
     * @return void
     */
    function listarClienteJson()
    {
        global $bd;
        $data['data'] = $bd->listarClientesArray();
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }





    function listarClienteVendas($id)
    {
        $bd = new Table_Cliente();
        $data['cliente'] = $bd->listarClientesVendas($id);
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }



    /**
     * Ativa ou desativa um cliente.
     * 
     * @param int $op 1 - para ativar um cliente, 2 - para desativar um cliente
     * 
     * @param int $id Código do cliente a ser alterado
     */
    function alterarStatus($op, $id)
    {
        global $bd;
        switch ($op) {
            case 1:
                $bd->ativarCliente($id);
                break;
            case 2:
                $bd->desativarCliente($id);
                break;
        }
    }

    function clienteCredito($credito, $id_cliente){
        $bd = new Table_Cliente();
        $bd->addCredito($credito, $id_cliente);
    }
}
