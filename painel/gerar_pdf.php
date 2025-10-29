<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

// --- CONEXÃO COM O BANCO ---
include('../bd.php');

// --- CONSULTA AO BANCO ---
$query = "SELECT * FROM agendamento_cli";
$result = mysqli_query($conn, $query);

$total = mysqli_num_rows($result);
$pendentes = $cancelados = $concluidos = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $status = strtolower(trim($row['status']));
    if ($status === 'pendente') $pendentes++;
    elseif ($status === 'cancelado') $cancelados++;
    elseif ($status === 'concluido') $concluidos++;
}

// --- MONTA O HTML ---
$html = '
<html>
<head>
  <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; font-size: 12px;">

  <h1 style="text-align:center; margin-bottom:20px;">Relatório de Agendamentos</h1>

  <div style="width:100%; text-align:center; margin-bottom:20px; font-size:0;">
      <div style="display:inline-block; width:23%; background-color:#17a2b8; color:white; border-radius:12px; margin:2px; padding:10px; box-shadow:0 2px 6px rgba(0,0,0,0.2); vertical-align:top; font-size:12px;">
          <h3 style="margin:0; font-size:22px;">' . $total . '</h3>
          <p style="margin:5px 0 0;">Total</p>
      </div>

      <div style="display:inline-block; width:23%; background-color:#ffc107; color:#212529; border-radius:12px; margin:2px; padding:10px; box-shadow:0 2px 6px rgba(0,0,0,0.2); vertical-align:top; font-size:12px;">
          <h3 style="margin:0; font-size:22px;">' . $pendentes . '</h3>
          <p style="margin:5px 0 0;">Pendentes</p>
      </div>

      <div style="display:inline-block; width:23%; background-color:#dc3545; color:white; border-radius:12px; margin:2px; padding:10px; box-shadow:0 2px 6px rgba(0,0,0,0.2); vertical-align:top; font-size:12px;">
          <h3 style="margin:0; font-size:22px;">' . $cancelados . '</h3>
          <p style="margin:5px 0 0;">Cancelados</p>
      </div>

      <div style="display:inline-block; width:23%; background-color:#28a745; color:white; border-radius:12px; margin:2px; padding:10px; box-shadow:0 2px 6px rgba(0,0,0,0.2); vertical-align:top; font-size:12px;">
          <h3 style="margin:0; font-size:22px;">' . $concluidos . '</h3>
          <p style="margin:5px 0 0;">Concluídos</p>
      </div>
  </div>

  <table style="width:100%; border-collapse:collapse; margin-top:10px;">
    <thead>
      <tr>
        <th style="border:1px solid #ccc; padding:6px; background-color:#f0f0f0;">ID</th>
        <th style="border:1px solid #ccc; padding:6px; background-color:#f0f0f0;">Nome</th>
        <th style="border:1px solid #ccc; padding:6px; background-color:#f0f0f0;">CPF</th>
        <th style="border:1px solid #ccc; padding:6px; background-color:#f0f0f0;">Celular</th>
        <th style="border:1px solid #ccc; padding:6px; background-color:#f0f0f0;">Email</th>
        <th style="border:1px solid #ccc; padding:6px; background-color:#f0f0f0;">Data de Agenda</th>
        <th style="border:1px solid #ccc; padding:6px; background-color:#f0f0f0;">Hora</th>
        <th style="border:1px solid #ccc; padding:6px; background-color:#f0f0f0;">Status</th>
      </tr>
    </thead>
    <tbody>';

$query = "SELECT * FROM agendamento_cli";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($r = mysqli_fetch_assoc($result)) {
        $cel = !empty($r['celular']) ? preg_replace('/(\d{2})(\d{1})(\d{4})(\d{4})/', '($1) $2 $3-$4', $r['celular']) : '';
        $data = !empty($r['data_agenda']) ? date('d/m/Y', strtotime($r['data_agenda'])) : '';
        $html .= '
        <tr>
            <td style="border:1px solid #ccc; padding:6px; text-align:center;">' . $r['id'] . '</td>
            <td style="border:1px solid #ccc; padding:6px;">' . htmlspecialchars($r['nome']) . '</td>
            <td style="border:1px solid #ccc; padding:6px;">' . htmlspecialchars($r['cpf']) . '</td>
            <td style="border:1px solid #ccc; padding:6px;">' . $cel . '</td>
            <td style="border:1px solid #ccc; padding:6px;">' . htmlspecialchars($r['email']) . '</td>
            <td style="border:1px solid #ccc; padding:6px;">' . $data . '</td>
            <td style="border:1px solid #ccc; padding:6px;">' . htmlspecialchars($r['hora_agenda']) . '</td>
            <td style="border:1px solid #ccc; padding:6px;">' . htmlspecialchars($r['status']) . '</td>
        </tr>';
    }
} else {
    $html .= '<tr><td colspan="8" style="border:1px solid #ccc; padding:10px; text-align:center;">Nenhum agendamento cadastrado.</td></tr>';
}

$html .= '
    </tbody>
  </table>

</body>
</html>';

// --- GERA O PDF ---
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("relatorio_agendamentos.pdf", ["Attachment" => true]);
