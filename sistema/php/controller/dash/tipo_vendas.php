<?php

require_once "../../model/dash/dashboard.class.php";

$dash = new Dashboard();

$data = $dash->tipoVenda();

print_r($data);