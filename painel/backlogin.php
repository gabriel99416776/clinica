<?php
include("../bd.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"], $_POST["senha"])) {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    if (empty($email) || empty($senha)) {
        header("location: index.php?erro=2");
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        if (password_verify($senha, $usuario["senha"])) {

            if ($usuario["ativo"] == 0) {
                header("location: dashboard.php?erro=pendente");
                exit;
            }

            session_start();
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["usuario_nome"] = $usuario["nome"];
            $_SESSION["usuario_celular"] = $usuario["celular"];
            $_SESSION["usuario_email"] = $usuario["email"];
            $_SESSION["usuario_cpf"] = $usuario["cpf"];
            $_SESSION["usuario_permissao"] = $usuario["permissao"];

            // 🔹 ATUALIZA o campo last_activity no login
            $ts = time();
            $update = $conn->prepare("UPDATE tbl_user SET last_activity = ? WHERE id = ?");
            $update->bind_param("ii", $ts, $usuario["id"]);
            $update->execute();

            header("location: dashboard.php");
            exit;
        }
    }

    $stmt->close();
    header("location: index.php?erro=1");
    exit;
}
?>
