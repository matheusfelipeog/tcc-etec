<?php
require_once "../../model/funcionario/funcionario.class.php";

$funcionario = new funcionario();

$nome = $_POST['nome'];
$login = $_POST['login'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$acesso = $_POST['acesso'];

$funcionario->salvarFuncionario($nome, $login, $email, $senha, $acesso);
header("location: ../../view/login.php");
