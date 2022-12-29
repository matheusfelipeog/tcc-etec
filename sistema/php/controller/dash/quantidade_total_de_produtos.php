<?php
require_once  "../../model/dash/dashboard.class.php";

$dash = new Dashboard();

$data = $dash->countProdutos();

print_r($data);

