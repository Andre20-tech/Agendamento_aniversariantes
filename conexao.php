<?php

$host = "al_tech.mysql.dbaas.com.br"; 
$usuario = "al_tech";
$senha = "Agendamento@2";
$banco = "al_tech";

$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}
?>
