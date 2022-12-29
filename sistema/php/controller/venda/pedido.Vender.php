<?php

require_once "../../model/pedido/pedido.class.php";
require_once "../../model/itens_vendidos/vendidos.class.php";
require_once  "../../model/contas/contas.PDO.php";

$pedido = new Pedido();
$vendidos = new Venda();
$total = $_POST['valorTotalDaCompra'];
$forma_de_pagamento = $_POST['formaDePagamento'];
$produtosLista = $_POST['listaDeCompras'];

print_r($_POST);

if (isset($_POST['dadosCliente']) && isset($_POST['tipoDeConsumo'])) {

    if ($_POST['tipoDeConsumo'] == 'Cliente') {

        $forma_de_pagamento = 'Fiado';
        $id_pedido = $pedido->novaVenda($total, $forma_de_pagamento);
        $vendidos->salvarItensVendidos($id_pedido, $produtosLista);
        $id_cliente= $_POST['dadosCliente']['id'];
        $pedido->anexarCliente($id_cliente, $id_pedido);

    } else if ($_POST['tipoDeConsumo'] == 'Funcionario') {

        $forma_de_pagamento = 'Interno';
        $id_pedido = $pedido->novaVenda($total, $forma_de_pagamento);
        $vendidos->salvarItensVendidos($id_pedido, $produtosLista);
        $id_funcionario = $_POST['dadosCliente']['id'];
        $pedido->anexarFuncionario($id_funcionario, $id_pedido);
    }

} else {

    $id_pedido = $pedido->novaVenda($total, $forma_de_pagamento);
    $vendidos->salvarItensVendidos($id_pedido, $produtosLista);

}

