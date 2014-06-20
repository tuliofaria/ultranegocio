<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContatoService
 *
 * @author rafaelsm.com.br
 */
class ContatoService {
    /**
	 * @access public
	 * @param <E> e
	 * @return int
	 * @ParamType e <E>
	 * @ReturnType int
	 */
	private function enviarEmail($nome, $email, $assunto, $msg){
		try{
                $msg .= "<br/><br/><br/><br/><p align='center'><b>SPECom</b> - Plataforma de comércio eletrônico</p>";
		require("/./home/rafaelsm/public_html/phpmailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->Host = "smtp.rafaelsm.com.br";
		$mail->SMTPAuth = true; 
		$mail->Username = 'contato@rafaelsm.com.br'; 
		$mail->Password = 'rv250788';
		$mail->From = $email; // Seu e-mail
		$mail->FromName = $nome; // Seu nome
		$mail->AddAddress($GLOBALS['email'], $funcionario->getNome());
		$mail->IsHTML(true);
		$mail->CharSet = 'utf-8';
		$mail->Subject  = "Dados para acesso - Plataforma SPECom";
		$mail->Body = $msg;
		$mail->AltBody = $msg;
		$enviado = $mail->Send();
		$mail->ClearAllRecipients();
		$mail->ClearAttachments();	 
		// Exibe uma mensagem de resultado
		if ($enviado) {
				0;
		} else {
			echo "Não foi possível enviar o e-mail.<br /><br />";
			echo "<b>Informações do erro:</b> <br />" . $mail->ErrorInfo;
			exit();
		}
			
		}catch(Exception $e){
			$e->getMessage();
		}
	}
}

?>
