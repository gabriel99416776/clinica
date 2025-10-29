<?php
include("../bd.php");
session_start();

$usuario_id = $_SESSION['usuario_id'] ?? null;

if ($usuario_id && !empty($_POST['fotoBase64'])) {
    $fotoBase64 = $_POST['fotoBase64'];
    // Remove prefixo
    $fotoBase64 = preg_replace('#^data:image/\w+;base64,#i', '', $fotoBase64);

    $stmt = $conn->prepare("UPDATE tbl_user SET foto_64 = ? WHERE id = ?");
    $stmt->bind_param("si", $fotoBase64, $usuario_id);
    $stmt->execute();
    $stmt->close();
}
header("Location: dashboard.php"); // volta para o perfil
exit;
