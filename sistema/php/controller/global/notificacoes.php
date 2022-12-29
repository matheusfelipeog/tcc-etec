<?php

require_once "../../model/produto/produto.class.php";

$notificacao = new Produto();

$data = $notificacao->notificacoes();

print_r($data);