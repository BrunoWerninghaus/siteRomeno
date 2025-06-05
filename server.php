<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "romenno";

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checa conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para enviar dados do formulário para o banco de dados
function enviarDadosFormulario($nome, $email, $mensagem) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO formulario (nome, email, mensagem) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Erro na preparação: " . $conn->error);
    }
    $stmt->bind_param("sss", $nome, $email, $mensagem);
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $mensagem = $_POST['mensagem'] ?? '';

    if (enviarDadosFormulario($nome, $email, $mensagem)) {
        header("Location: index.html?msg=Dados+enviados+com+sucesso!");
        exit;
    } else {
        header("Location: index.html?msg=Erro+ao+enviar+dados.");
        exit;
    }
}
