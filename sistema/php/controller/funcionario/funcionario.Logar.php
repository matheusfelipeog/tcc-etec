<?php

require_once "../../model/funcionario/funcionario.class.php";

$login = $_POST['login'];
$email = $_POST['email'];
$senha = $_POST['senha'];

$log = new Funcionario();
echo 'olá';
$log->logar($login, $email, $senha);
