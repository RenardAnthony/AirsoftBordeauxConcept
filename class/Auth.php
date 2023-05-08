<?php
class Auth{

	private $options = [

		'restriction_msg' => "Tu ne peut pas aller sur cette page tu n'est pas connecter !"

	];

	private $session;

	public function __construct($session, $options = []){

		$this->options = array_merge($this->options, $options);

		$this->session = $session;
	}


	public function hashPassword($password){

			return password_hash($password, PASSWORD_BCRYPT);
	}

	public function RegisterCheck(){
		
	}


	public function register($db, $username, $password, $email2){

		$password = $this->hashPassword($password);

		$token = Str::random(60);

		$db->query("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?",[$username, $password, $email2, $token]);

		$user_id = $db->lastInsertId();

		$header="MIME-Version: 1.0\r\n";
		$header.='From:"Furry-id.com"<contact@furry-id.com>'."\n";
		$header.='Content-Type:text/html; charset="uft-8"'."\n";
		$header.='Content-Transfer-Encoding: 8bit';

		$message_inscription = "
		
		<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
   		\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns:v=\"urn:schemas-microsoft-com:vml\">
			<head>
		
				<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">
				<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0; maximum-scale=1.0;\">
		
			</head>
			<body leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\" style=\"font-family:\'Trebuchet MS\', Arial, Helvetica, sans-serif;\">
				<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
					<tbody style=\"text-align: center;\">
						<tr>
							<td bgcolor=\"#315358\" valign=\"top\">
								<div>
									<table align=\"center\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"color:#ffffff;\">
										<tbody>
											<tr><td height=\"30\" style=\"font-size:30px; line-height: 30px;\"></td></tr>
											<tr>
												<td stlye=\"text-align: center;\">
													<a href=\"http://www.furry-id.com\" style=\"text-decoration: none; color:#ffffff;\">
														<img alt=\"logo foxflight\" src=\"http://furry-id.com/img/theme/Logo_site_nb.png\" width=\"100px\" border=\"0\">
													<h1>FURRY-ID.COM</h1></a>
												</td>
											</tr>
											<tr><td height=\"30\" style=\"font-size:30px; line-height: 30px;\"></td></tr>
										</tbody>
									</table>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
		
				<table bgcolor=\"#163236\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
					<tbody style=\"text-align: center;\">
						<tr>
							<td bgcolor=\"#163236\" valign=\"top\">
								<div>
									<table align=\"center\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"color:#ffffff;\">
										<tbody>
											<tr><td height=\"30\" style=\"font-size:30px; line-height: 30px;\"></td></tr>
											<tr>
												<td stlye=\"text-align: center;\">
													<a href=\"http://foxfliy.cluster030.hosting.ovh.net\"></a>
													<p><img src=\"http://www.furry-id.com/img/flags/fr.svg\" alt=\"French version :\" style=\"height: 20px; margin: 0 1em;\">Bienvenue ! Tu à crée t'on compte sur Furry-id.com ! <br> Pour validé t'on inscription il te sufit de cliquer sur le boutton juste en dessous.</p>
													<p><br><br></p>
													<p><img src=\"http://www.furry-id.com/img/flags/gb.svg\" alt=\"English version :\" style=\"height: 20px; margin: 0 1em;\">Welcome ! You created your account on Furry-id.com ! <br> To validate your registration, you just have to click on the button just below.</p>
												</td>
											</tr>
											<tr><td height=\"30\" style=\"font-size:30px; line-height: 30px;\"></td></tr>
										</tbody>
									</table>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
		
				<table bgcolor=\"#163236\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
					<tr>
					<td align=\"center\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin:0px auto;\" align=\"center\" role=\"presentation\">
						<tr><td height=\"30\" style=\"font-size:30px; line-height: 30px;\"></td></tr>
						<tr>
							<td bgcolor=\"#202021\" style=\"
								border-radius:5px;
								-moz-border-radius:5px;
								-webkit-border-radius:5px; padding:15px 40px;
								background-color:#202021; background:#202021;\">
								<a href=\"http://www.furry-id.com/confirm.php?id=$user_id&token=$token\" target=\"_blank\" style=\"
										color:#FFFFFF;
										text-decoration:none
										\">Confirmed
								<p style=\"
									padding:0px;
									margin:0px;
									font-family:\'Trebuchet MS\', Arial, Helvetica, sans-serif;
									font-size:12px;
									text-align:center;
									color:#FFFFFF;
									mso-line-height-rule:exactly;
									line-height:16px;\">
								</p></a>
							</td>
						</tr>
						</table></td>
					</tr>
					<tr><td height=\"30\" style=\"font-size:30px; line-height: 30px;\"></td></tr>
				</table>
				<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
					<tbody style=\"text-align: center;\">
						<tr>
							<td bgcolor=\"#315358\" valign=\"top\">
								<div>
									<table align=\"center\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"color:#ffffff;\">
										<tbody>
											<tr><td height=\"30\" style=\"font-size:30px; line-height: 30px;\"></td></tr>
											<tr>
												<td stlye=\"text-align: center;\">
													<p>If you are not the recipient of this mail. Please don't answer it.</p>
													<p>Si vous êtes pas le destinataire de ce mail. Merci de ne pas y répondre.</p>
												</td>
											</tr>
											<tr><td height=\"30\" style=\"font-size:30px; line-height: 30px;\"></td></tr>
										</tbody>
									</table>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</body>
		</html>";

		$potofeu = "contact@furry-id.com";

		mail($email2,'Confirmation de votre compte Furry-id.com', $message_inscription, $header);

		mail($email2,'Confirmation de votre compte Furry-id.com', "http://www.furry-id.com/confirm.php?id=$user_id&token=$token", $header);

		mail($potofeu,'Nouvelle inscrit sur furry-id.com !', "Nom : $username, id : $user_id, Mail : $email2",$header);

		//mail('contact@furry-id.com','Nouvelle inscrit sur furry-id.com !', "Nom : $username, id : $user_id, Mail : $email2",$header);
	}


	public function confirm($db, $user_id, $token){

		$user = $db->query('SELECT * FROM users WHERE id = ?', [$user_id])->fetch();

		if($user && $user->confirmation_token == $token){

			$db->query('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?', [$user_id]);

			$this->session->write('auth', $user);

			return true;

		} else {

			return false;

		}
	}


	public function restrict(){

		if(!$this->session->read('auth')){

			$this->session->setFlash('alert', $this->options['restriction_msg']);

			header('Location: login.php');

			exit();
		}
	}


	public function user(){

		if(!$this->session->read('auth')){

			return false;

		}

		return !$this->session->read('auth');
	}


	public function connect($user){

		$this->session->write('auth', $user);
	}


	public function connectFromCookie($db){

		if(isset($_COOKIE['remember']) && !$this->user()){

			$remember_token = $_COOKIE['remember'];

			$parts = explode('==', $remember_token);

			$user_id = $parts[0];

			$user = $db->query('SELECT * FROM users WHERE id = ?', [$user_id])->fetch();

			if($user){

				$expected = $user_id . '==' . $user->remember_token . sha1($user_id . 'lesrenardsctropgenial');

				if($expected == $remember_token){

					$this->connect($user);

					setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);

				} else {

					setcookie('remember', NULL, -1);

				}

			}else{

				setcookie('remember', NULL, -1);

			}

		}
	}


	public function login($db, $username, $password, $remember = false){

		$user = $db->query('SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL', ['username' => $username])->fetch();

		if($user){
		
			if(password_verify($password, $user->password)){

				$this->connect($user);

				if($remember){

					$this->remember($db, $user->id);

				}

				return $user;

			}else{

				return false;

			}
		}
	}

	public function remember($db, $user_id){

		$remember_token = Str::random(250);

		$db->query('UPDATE users SET remember_token = ? WHERE id = ?', [$remember_token, $user_id]);

		setcookie('remember',$user_id . '==' .$remember_token . sha1($user_id . 'lesrenardsctropgenial'), time() + 60 * 60 * 24 * 7);
	}


	public function logout(){

		setcookie('remember', NULL, -1);

		$this->session->delete('auth');
	}


	public function resetPassword($db, $email2){

		$user = $db->query('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL', [$email2])->fetch();

		if($user){

			$reset_token = Str::random(60);

			$db->query('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?', [$reset_token,$user->id]);

			mail($email2, 'Réinitialisation de votre mots de passe', "Afin de valider votre réinitialisation de mots de passe, merci de cliquer sur ce lien\n\nhttp://furry-id.com/reset.php?id={$user->id}&token=$reset_token");

			return $user;
		}

		return false;
	}


	public function checkResetToken($db, $user_id, $token){

		return $db->query('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(),INTERVAL 30 MINUTE)', [$user_id, $token])->fetch();
	}

	public function online(){

		if(!$this->session->read('auth')){

			return false;

		} else {

			return true;

		}
	}

}