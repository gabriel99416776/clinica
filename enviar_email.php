<?php
include 'bd.php'; // Inclua o arquivo de conexão com o banco de dados


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'painel/vendor/autoload.php'; // ou os requires manuais

// Recebendo dados do formulário
$nome    = $_POST['nome'] ?? '';
$cpf     = $_POST['cpf'] ?? '';
$celular = $_POST['celular'] ?? '';
$email   = $_POST['email'] ?? '';
$data    = $_POST['data'] ?? '';
$hora    = $_POST['hora'] ?? '';

if (empty($nome) || empty($cpf) || empty($celular) || empty($email) || empty($data) || empty($hora)) {
    echo "<script>alert('Por favor, preencha todos os campos.'); window.location='index.php';</script>";
    exit;
}
$stmt = $conn->prepare("INSERT INTO agendamento_cli (nome, cpf, celular, email, data_agenda, hora_agenda) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $nome, $cpf, $celular, $email, $data, $hora);
$stmt->execute();



$mail = new PHPMailer(true);

try {
    // Configuração do servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username = 'gabrielfortaleza4@gmail.com';
    $mail->Password = 'eowz ymih zemi clwi';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Remetente e destinatário
    $mail->setFrom('SEU_EMAIL@gmail.com', 'Clínica');
    $mail->addAddress($email, $nome); // envia para o e-mail do formulário

    // Conteúdo do e-mail
    $mail->isHTML(true);
    $mail->Subject = 'Agendamento Confirmado';
    $mail->Body = "
        <html>
        <head><meta charset='UTF-8'></head>
        <BODY bgColor=#ffffff>

    <div align='center'>
    <font face='verdana' size='2'>
    Caso não consiga visualizar, acesse: <a href=$nome>$cpf</a></font><br>
    <table border='0' cellpadding='0' cellspacing='0' style='border-collapse: collapse' width='700'>
    <tr><td bgcolor='#f2f2f2'><img src='https://efolia.com.br/admin/imagens/email_cima_2.png' border='0'><td></tr>
    <tr><td bgcolor='#f2f2f2'>
    <h2>Olá  $nome  ,</h2>
    <p>
    <center>
    <h4>Você solicitou uma nova senha para acessar seu cadastro facial.<br>Basta clicar no botão abaixo para criar uma nova senha.</h4>
    <a href=$email><img src='https://leaotickets.com.br/cadfacial/cpass/nnsenha.png' width='300' border='0'></a>
    <p>
    &nbsp;
    <br>
    </center>
    <td></tr>
    <tr><td bgcolor='#f2f2f2'><img src='http://efolia.com.br/admin/imagens/email_baixo.png' border='0'><td></tr>
    </table>
    </div>
        </body>
        </html>";
    $mail->send();
    echo "<script>alert('Agendamento enviado com sucesso!'); window.location='index.php';</script>";
} catch (Exception $e) {
    echo "Erro ao enviar: {$mail->ErrorInfo}";
}
