<?php
require_once "../../model/dash/dashboard.class.php";

$dash = new Dashboard();

$data = $dash->lucroAnual();

print_r($data);
