<?php
require_once "../../model/pdo.Banco.class.php";

class Dashboard extends Banco {

    function lucroAnual(){
        global $pdo;
        $bd = new Dashboard();
        $bd->conectar();
        $anoM = $pdo->prepare("SELECT YEAR(CURRENT_DATE())");
        $anoM->execute();
        $ano = $anoM->fetchColumn();
        $jan = $pdo->prepare("SELECT IFNULL(SUM(pedido.valor), 0) FROM pedido WHERE pedido.data BETWEEN '$ano-01-01' AND '$ano-02-01'");
        $fev = $pdo->prepare("SELECT IFNULL(SUM(pedido.valor), 0) FROM pedido WHERE pedido.data BETWEEN '$ano-02-02' AND '$ano-03-01'");
        $mar = $pdo->prepare("SELECT IFNULL(SUM(pedido.valor), 0) FROM pedido WHERE pedido.data BETWEEN '$ano-03-02' AND '$ano-04-01'");
        $abr = $pdo->prepare("SELECT IFNULL(SUM(pedido.valor), 0) FROM pedido WHERE pedido.data BETWEEN '$ano-04-02' AND '$ano-05-01'");
        $mai = $pdo->prepare("SELECT IFNULL(SUM(pedido.valor), 0) FROM pedido WHERE pedido.data BETWEEN '$ano-05-02' AND '$ano-06-01'");
        $jun = $pdo->prepare("SELECT IFNULL(SUM(pedido.valor), 0) FROM pedido WHERE pedido.data BETWEEN '$ano-06-02' AND '$ano-07-01'");
        $jul = $pdo->prepare("SELECT IFNULL(SUM(pedido.valor), 0) FROM pedido WHERE pedido.data BETWEEN '$ano-07-02' AND '$ano-08-01'");
        $ago = $pdo->prepare("SELECT IFNULL(SUM(pedido.valor), 0) FROM pedido WHERE pedido.data BETWEEN '$ano-08-02' AND '$ano-09-01'");
        $set = $pdo->prepare("SELECT IFNULL(SUM(pedido.valor), 0) FROM pedido WHERE pedido.data BETWEEN '$ano-09-02' AND '$ano-10-01'");
        $out = $pdo->prepare("SELECT IFNULL(SUM(pedido.valor), 0) FROM pedido WHERE pedido.data BETWEEN '$ano-10-02' AND '$ano-11-01'");
        $nov = $pdo->prepare("SELECT IFNULL(SUM(pedido.valor), 0) FROM pedido WHERE pedido.data BETWEEN '$ano-11-02' AND '$ano-12-01'");
        $dez = $pdo->prepare("SELECT IFNULL(SUM(pedido.valor), 0) FROM pedido WHERE pedido.data BETWEEN '$ano-12-02' AND '$ano-12-31'");

        $jan->execute();
        $fev->execute();
        $mar->execute();
        $abr->execute();
        $mai->execute();
        $jun->execute();
        $jul->execute();
        $ago->execute();
        $set->execute();
        $out->execute();
        $nov->execute();
        $dez->execute();

        $meses['Jan'] = $jan->fetchColumn();
        $meses['Fev'] = $fev->fetchColumn();
        $meses['Mar'] = $mar->fetchColumn();
        $meses['Abr'] = $abr->fetchColumn();
        $meses['Mai'] = $mai->fetchColumn();
        $meses['Jun'] = $jun->fetchColumn();
        $meses['Jul'] = $jul->fetchColumn();
        $meses['Ago'] = $ago->fetchColumn();
        $meses['Set'] = $set->fetchColumn();
        $meses['Out'] = $out->fetchColumn();
        $meses['Nov'] = $nov->fetchColumn();
        $meses['Dez'] = $dez->fetchColumn();
        $ano_inteiro = implode(', ', $meses);
        $json = '{"estrutura_do_grafico":{"labels":["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],"data":[' . $ano_inteiro . ']}}';
        return $json;
    }

    function countProdutos(){
        global $pdo;
        $bd = new Dashboard();
        $bd->conectar();
        $sql = $pdo->prepare("SELECT COUNT(produto.id_produto) AS qtd_total_produtos FROM produto WHERE produto.`status` = 'Ativo' AND produto.tipo != 'Preparo'");
        $sql->execute();
        $quantia['qtd_total_produtos'] = $sql->fetchColumn();
        return json_encode($quantia, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    function lucroMensal(){
        global $pdo;
        $bd = new Dashboard();
        $bd->conectar();
        $ano = $pdo->prepare("SELECT YEAR(CURRENT_DATE())");
        $mes = $pdo->prepare("SELECT MONTH(CURRENT_DATE())");
        $ano->execute();
        $mes->execute();
        $ano = $ano->fetchColumn();
        $mes = $mes->fetchColumn();
        $sql = $pdo->prepare("SELECT SUM(pedido.valor) FROM pedido WHERE pedido.data BETWEEN '$ano-$mes-02' AND  DATE_ADD('$ano-$mes-01', INTERVAL 1 MONTH)");
        $sql->execute();
        $lucro['lucro_do_mes'] = $sql->fetchColumn();
        return json_encode($lucro, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    function despesaMensal(){
        global $pdo;
        $bd = new Dashboard();
        $bd->conectar();
        $ano = $pdo->prepare("SELECT YEAR(CURRENT_DATE())");
        $mes = $pdo->prepare("SELECT MONTH(CURRENT_DATE())");
        $ano->execute();
        $mes->execute();
        $ano = $ano->fetchColumn();
        $mes = $mes->fetchColumn();
        $sql = $pdo->prepare("SELECT SUM(produto.custo * itens_vendidos.quantia) AS despesas FROM produto INNER JOIN itens_vendidos ON itens_vendidos.produto_id_produto = produto.id_produto INNER JOIN pedido ON pedido.id_pedido = itens_vendidos.pedido_id_pedido WHERE pedido.data BETWEEN '$ano-$mes-02' AND DATE_ADD('$ano-$mes-01', INTERVAL 1 MONTH)");
        $sql->execute();
        $despesa['despesa_do_mes'] = $sql->fetchColumn();
        return json_encode($despesa, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    function tipoVenda(){
        global $pdo;
        $bd = new Dashboard();
        $bd->conectar();

        $ano = $pdo->prepare("SELECT YEAR(CURRENT_DATE())");
        $mes = $pdo->prepare("SELECT MONTH(CURRENT_DATE())");

        $ano->execute();
        $mes->execute();

        $ano = $ano->fetchColumn();
        $mes = $mes->fetchColumn();

        $sql = $pdo->prepare("SELECT pedido.tipo, SUM(pedido.valor) AS total_de_vendas FROM pedido WHERE pedido.data BETWEEN '$ano-$mes-02' AND DATE_ADD('$ano-$mes-01', INTERVAL 1 MONTH) GROUP BY pedido.tipo");
        $sql->execute();
        while($col =$sql->fetch(PDO::FETCH_ASSOC)){
            $data[] = $col['total_de_vendas'];
        }
        $dados['tipo_de_pagamento'] = $data;
        return json_encode($dados, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}