<?php
include("../bd.php");

// Tempo máximo sem atividade para considerar "online" (em segundos)
$limite = 60;

$query = "SELECT id, nome, last_activity FROM tbl_user ORDER BY nome ASC";
$result = $conn->query($query);

$usuarios = [];
$agora = time();

while ($row = $result->fetch_assoc()) {
    $online = ($row['last_activity'] && ($agora - $row['last_activity']) <= $limite);
    $usuarios[] = [
        'id' => $row['id'],
        'nome' => $row['nome'],
        'online' => $online
    ];
}

header('Content-Type: application/json');
echo json_encode($usuarios);
?>
