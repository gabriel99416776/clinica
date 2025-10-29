<?php

include("../bd.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nome"], $_POST["email"], $_POST["tel"], $_POST["cpf"], $_POST["senha"])) {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];
    $cpf = $_POST["cpf"];
    $senha = $_POST["senha"];

    if (empty($nome) || empty($email) || empty($senha) || empty($tel) || empty($cpf)) {
        header("location: index.php?erro=3");
        exit;
    }

    // Verifica se já existe email ou celular
    $stmt = $conn->prepare("SELECT id FROM tbl_user WHERE email = ? OR celular = ?");
    $stmt->bind_param("ss", $email, $tel);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        header("location: index.php?erro=4");
        $stmt->close();
        exit;
    }
    $stmt->close();

    // Hash da senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere o usuário com ativo = 0 (pendente aprovação)
    $stmt = $conn->prepare("INSERT INTO tbl_user (`nome`, `email`, `celular`, `cpf`, `senha`, `ativo`) VALUES (?, ?, ?, ?, ?, 0)");
    $stmt->bind_param("sssss", $nome, $email, $tel, $cpf, $senhaHash);

    if ($stmt->execute()) {
        // Usuário cadastrado, mas precisa aprovação
        header("location: index.php?sucess=pendente"); // mensagem: "aguardando aprovação do admin"
    } else {
        echo "Erro ao cadastrar usuário: " . $stmt->error;
    }
    $stmt->close();
    exit;
}
