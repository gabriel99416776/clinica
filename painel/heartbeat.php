<?php
session_start();
include("../bd.php");

if (!isset($_SESSION["usuario_id"])) {
    http_response_code(401);
    echo json_encode(["ok" => false, "msg" => "Sessão inválida"]);
    exit;
}

$user_id = (int) $_SESSION["usuario_id"];
$ts = time();

$stmt = $conn->prepare("UPDATE tbl_user SET last_activity = ? WHERE id = ?");
$stmt->bind_param("ii", $ts, $user_id);
$stmt->execute();

echo json_encode(["ok" => true, "ts" => $ts]);
?>
