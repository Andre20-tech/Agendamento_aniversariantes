<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit;
}

include '../conexao.php'; 

$sql = "SELECT * FROM clientes ORDER BY nome ASC";
$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Clientes</h2>
        <a href="clientes_cadastro.php" class="btn btn-success mb-3">Novo Cliente</a>
        <a href="../painel.php" class="btn btn-secondary mb-3">Voltar ao Painel</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Aniversário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($cliente = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($cliente['nome']) ?></td>
                    <td><?= htmlspecialchars($cliente['email']) ?></td>
                    <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                    <td><?= date('d/m/Y', strtotime($cliente['data_aniversario'])) ?></td>
                    <td>
                        <a href="cliente_editar.php?id=<?= $cliente['cliente_id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="cliente_excluir.php?id=<?= $cliente['cliente_id'] ?>" class="btn btn-danger btn-sm">Excluir</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
