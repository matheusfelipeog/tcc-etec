<?php
require_once "../../model/dash/dashboard.class.php";

$dash = new Dashboard();

$data = $dash->despesaMensal();

print_r($data);