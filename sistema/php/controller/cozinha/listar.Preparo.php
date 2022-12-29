<?php

require_once '../../model/cozinha/cozinha.class.php';

$cozinha = new Cozinha();

print_r($cozinha->listarPratosPreparo());
