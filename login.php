<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['login']) || !isset($_POST['senha'])) {
        echo "Campos obrigatórios não preenchidos.";
        exit;
    }

    $login = trim($_POST['login']);
    $senha = trim($_POST['senha']);

    $sql = "SELECT usuarios_id, senha FROM usuarios WHERE login = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $senha_hash);
        $stmt->fetch();

        if (password_verify($senha, $senha_hash)) {
            $_SESSION['usuario_id'] = $id;
            $_SESSION['login'] = $login;
            header("Location: painel.php");
            exit;
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Usuário não encontrado.";
    }

    $stmt->close();
    $conexao->close();
}
?>
