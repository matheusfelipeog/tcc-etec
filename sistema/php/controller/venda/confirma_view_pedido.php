<?php

require_once '../../model/cozinha/cozinha.class.php';

$cozinha = new Cozinha();

$id_prato = addslashes(trim($_POST['pedido_visualizado']['idpedido']));

$cozinha->apagarPrato($id_prato);
