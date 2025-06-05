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
    echo "ID do cliente não fornecido.";
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $data_aniversario = $_POST['data_aniversario'];
    

    $sql = "UPDATE clientes SET nome=?, email=?, telefone=?, data_aniversario=? WHERE cliente_id=?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssssi", $nome, $email, $telefone, $data_aniversario, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Cliente atualizado com sucesso!'); window.location.href='clientes.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar cliente.');</script>";
    }

    $stmt->close();
} else {
    $sql = "SELECT * FROM clientes WHERE cliente_id=?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        echo "Cliente não encontrado.";
        exit;
    }

    $cliente = $resultado->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Editar Cliente</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome *</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>">
        </div>
        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($cliente['telefone']) ?>">
        </div>
        <div class="mb-3">
            <label for="data_aniversario" class="form-label">Data de Aniversário</label>
            <input type="date" class="form-control" id="data_aniversario" name="data_aniversario" value="<?= htmlspecialchars($cliente['data_aniversario']) ?>">
        </div>
        <div class="mb-3">
            <label for="observacoes" class="form-label">Observações</label>
            <textarea class="form-control" id="observacoes" name="observacoes"><?= htmlspecialchars($cliente['observacoes']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="clientes.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
