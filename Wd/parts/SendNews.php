<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: Oficerov Kirill
 * Date: 10.06.13
 */

class Wd_Parts_SendNews {

	const SEND_NEWS_URL = '/send_news';

	public static function is_page_send_news() {
		return (strpos($_SERVER['REQUEST_URI'], self::SEND_NEWS_URL) === 0) && (count($_POST));
	}

	/**
	 * @param $data post data ($_POST)
	 */
	public static function save_news($data) {
		header('Content-type: application/json');
		$errors = array();
		if(!isset($data['header'])) {
			$errors[] = 'Заголовок новости не задан';
			echo json_encode(array('errors' => $errors));
		}
		if(!isset($data['content'])) {
			$errors[] = 'Заголовок новости не задан';
			echo json_encode(array('errors' => $errors));
		}

		if (!class_exists('PHPMailer')) {
			require_once(DOCUMENT_ROOT . "wp-includes/class-phpmailer.php");
		}
		try {

		$mail = new PHPMailer(false);
		$mail->MailerDebug = false;



//			$mail->IsSMTP();
//			$mail->Host = $admin_options['smtp_host'];
//			if ($admin_options['smtp_authentication'] == 1) {
//				$mail->SMTPAuth = true;
//				$mail->Username = $admin_options['smtp_username'];
//				$mail->Password = $admin_options['smtp_password'];
//				$mail->Port = $admin_options['smtp_port'];
//			} else
//				$mail->SMTPAuth = false;

//		$admin_options = CustomContactForms::getAdminOptions();
//		$mail->AddAddress($admin_options['default_to_email']);
		$mail->AddAddress('info@wedigital.by');
		$mail->From = 'chrisodowd89@gmail.com';
		$data['header'] = mysql_real_escape_string($data['header']);
		$data['content'] = mysql_real_escape_string($data['content']);
		$mail->Subject = $data['header'];
		$mail->AltBody = 'altbody';
		$mail->CharSet = 'utf-8';
		$mail->MsgHTML(stripslashes($data['content']));
		$mail->Send();
		}
catch (Exception $e) {
	echo json_encode(array($e->getMessage()));

	return;
}


		echo json_encode(array());

	}

}

