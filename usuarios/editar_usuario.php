<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit;
}

include '../conexao.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID do usuário não informado.'); window.location.href='usuarios.php';</script>";
    exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM usuarios WHERE usuarios_id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if (!$usuario) {
    echo "<script>alert('Usuário não encontrado.'); window.location.href='usuarios.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $login = $_POST['login'];

    // Atualizar senha apenas se for preenchida
    if (!empty($_POST['senha'])) {
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET nome = ?, login = ?, senha = ? WHERE usuarios_id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sssi", $nome, $login, $senha, $id);
    } else {
        $sql = "UPDATE usuarios SET nome = ?, login = ? WHERE usuarios_id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssi", $nome, $login, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Usuário atualizado com sucesso!'); window.location.href='usuarios.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar: " . $conexao->error . "');</script>";
    }

    $stmt->close();
    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Usuário</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="login" class="form-label">Login</label>
                <input type="text" class="form-control" id="login" name="login" value="<?= htmlspecialchars($usuario['login']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Nova Senha (opcional)</label>
                <input type="password" class="form-control" id="senha" name="senha">
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
