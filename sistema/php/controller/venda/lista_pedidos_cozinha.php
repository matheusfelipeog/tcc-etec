<?php
require_once '../../model/cozinha/cozinha.class.php';

$cozinha = new Cozinha();

$data = $cozinha->listarPratos();

print_r($data);