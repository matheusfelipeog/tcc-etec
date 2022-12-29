<?php 
require_once '../../model/pedido/pedido.PDO.php';
require_once '../../model/contas/contas.PDO.php';
require_once '../../model/consumo_interno/consumo_interno.PDO.php';

class Pedido{

    private $valor;
    private $tipo;
    private $desconto;
    private $acrescimo;

    // ------- Getters ---------
    function getValor(){
        return $this->valor;
    }

    function getTipo(){
        return $this->tipo;
    }
    
    function getDesconto(){
        return $this->desconto;
    }

    function getAcrescimo(){
        return $this->acrescimo;
    }

    // -------- Setters ------------

    function setValor($v){
        $this->valor = $v;
    }

    function setTipo($t){
        $this->tipo = $t;
    }

    function setDesconto($d){
        $this->desconto = $d;
    }

    function setAcrescimo($a){
        $this->acrescimo = $a;
    }

// -------------------------------------------------
    function  dadosVenda($valor, $tipo, $desconto = 0, $acrescimo = 0){
        $this->setValor($valor);
        $this->setTipo($tipo);
        $this->setDesconto($desconto);
        $this->acrescimo($acrescimo);
    }


    function pesquisarProdutos($texto){
        $bd = new Table_Pedido();
        $dados['response'] = $bd->selectProdutos($texto);
        return json_encode($dados, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    function novaVenda($valor, $forma_de_pagamento){
        $bd = new Table_Pedido();
        return $bd->insertPedido($valor, $forma_de_pagamento);
    }

    function anexarCliente($id_cliente, $id_pedido){
        $bd = new Table_Contas();
        $bd->insertContas($id_cliente, $id_pedido);
    }

    function anexarFuncionario($id_funcionario, $id_pedido){
        $bd = new Table_Consumo();
        $bd->insertConsumo($id_funcionario, $id_pedido);
    }
}