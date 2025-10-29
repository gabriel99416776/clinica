<?php
include 'bd.php';

if (!isset($_POST['data'])) {
    echo '<option value="">Selecione uma data primeiro</option>';
    exit;
}

$dataSelecionada = $_POST['data'];

// Gera todos os horários possíveis de 08:00 às 18:00
$horarios = [];
for ($hora = strtotime('08:00'); $hora <= strtotime('18:00'); $hora += 30 * 60) {
    $horarios[] = date('H:i', $hora);
}

// Busca os horários já agendados nessa data
$stmt = $conn->prepare("SELECT hora_agenda FROM agendamento_cli WHERE data_agenda = ? AND status = 'pendente'");
$stmt->bind_param("s", $dataSelecionada);
$stmt->execute();
$result = $stmt->get_result();

$ocupados = [];
while ($row = $result->fetch_assoc()) {
    $ocupados[] = substr($row['hora_agenda'], 0, 5);
}

// Gera o HTML dos options
foreach ($horarios as $hora) {
    if (in_array($hora, $ocupados)) {
        echo "<option value='$hora' disabled style='color:#999;'>$hora (ocupado)</option>";
    } else {
        echo "<option value='$hora'>$hora</option>";
    }
}
?>