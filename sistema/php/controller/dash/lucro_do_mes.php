<?php

require_once "../../model/dash/dashboard.class.php";

$dash = new Dashboard();

$data = $dash->lucroMensal();

print_r($data);
