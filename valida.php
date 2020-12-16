<?php
echo '<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">';
function enviarEmail($ms_titulo, $ms_email, $ms_body)
{
	require_once "PHPMailer_v5.1/class.phpmailer.php";
	$mail = new PHPMailer();
	$mail->Host = "relay.proderj.rj.gov.br";
	$mail->From = "admConverj@proderj.rj.gov.br"; // Seu e-mail
	$mail->FromName = "Administrador"; // Seu nome

	$mail->AddAddress($ms_email);
	$mail->IsHTML(true);
	$mail->Subject = $ms_titulo;
	$mail->Body = $ms_body;
	$enviado = $mail->Send();
	$mail->ClearAllRecipients();
	$mail->ClearAttachments();
	return $enviado;
}
if (isset($_POST["nome"]) and isset($_POST["e-mail"]) and isset($_POST["telefone"])  and isset($_POST["mensagem"])) {
	$ok = false;
	$remetente = $_POST["e-mail"];
	$nome = $_POST["nome"];
	$telefone = $_POST["telefone"];
	$mensagem = $_POST["mensagem"];
	if (!filter_var($remetente, FILTER_VALIDATE_EMAIL)) {//valida o email
		echo ("<script LANGUAGE='JavaScript'>
	window.alert('O email " . $remetente . " escrito é inválido.');
	window.history.back()
	</script>");
	} elseif (!preg_match('/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/', $nome)) {//valida nome só letras e espaços
		echo ("<script LANGUAGE='JavaScript'>
	window.alert('Preencha o nome sem caracteres especiais e numeros');
	window.history.back()
	</script>");
	} elseif (strlen($nome) < 3) {//nome maior que 3
		echo ("<script LANGUAGE='JavaScript'>
	window.alert('Preencha o nome.');
	window.history.back()
	</script>");
	} elseif (strlen($telefone) != 11) {//telefone no rj tem 11 numeros
		echo ("<script LANGUAGE='JavaScript'>
	window.alert('O número digitado é diferente do padrão. preencha com o ddd e o número.');
	window.history.back()
	</script>");
	} elseif (!is_numeric($telefone)) {//verifica se só tem numeros
		echo ("<script LANGUAGE='JavaScript'>
	window.alert('O número digitado possui caracteres não numéricos. preencha com o ddd e o número.');
	window.history.back()
	</script>");
	} elseif (strlen($mensagem) < 20) {;
		echo ("<script LANGUAGE='JavaScript'>
	window.alert('Preencha a mensagem.');
	window.history.back()
	</script>");
	} else {
		$ok = true;
	}
	$email = "cai16146@cuoly.com";//email do cliente
	$titulo = "Contato IRM";
	$msg = "Nome: " . $nome . "<br>
    Email: " . $remetente . "<br>
    Telefone: " . $telefone . "<br>
    Mensagem: " . $mensagem . "<br>";
	$confirma = enviarEmail($titulo, $email, $msg);
	if ($confirma and $ok == true) {
		echo ("<script LANGUAGE='JavaScript'>
    window.alert('Enviado com sucesso.');
    window.location.href='index.html';
	</script>");
	}
} else {
	echo ("<script LANGUAGE='JavaScript'>
    window.alert('Erro ao enviar.');
    window.history.back()
	</script>");
}
