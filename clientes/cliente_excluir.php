<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit;
}

include '../conexao.php';

if (!isset($_GET['id'])) {
    echo "ID do cliente não informado.";
    exit;
}

$id = $_GET['id'];

$sql = "DELETE FROM clientes WHERE cliente_id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Cliente excluído com sucesso!'); window.location.href='clientes.php';</script>";
} else {
    echo "<script>alert('Erro ao excluir cliente.'); window.history.back();</script>";
}

$stmt->close();
$conexao->close();
?>
