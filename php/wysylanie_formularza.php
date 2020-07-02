<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    	<title>Formularz Kontaktowy</title>
	</head>
	<body style="display: flex;">
    	<div style="display: block; margin: auto;">
<?php

	// Pokazywanie błędow
	error_reporting(-1);
	ini_set('display_errors', 1);
	set_error_handler("var_dump");

	// Dane z pliku konfiguracyjnego
	$config_array = parse_ini_file("../ini/config.ini", true /* wczyta sekcjami */);

	function blad($error)
	{
		echo '<h2 style="color: red" title="ENG: (There was a problem with the script.)">Wystąpił problem z działaniem skryptu!</h2>';
		echo '<p>Wykryto następujące błędy:</p>';
		echo '<ul>' . implode('<li>', $error) . '</ul>';
		echo '<p style="color: red">Twoja wiadomość nie została wysłana.</p>';
		echo '<p><a href="javascript:history.go(-1)">Kliknij tutaj</a>, aby wrócić i spróbować ponownie.</p>';
		//echo '<p><a href="javascript:window.close()">Kliknij tutaj</a>, aby zamknąć kartę i spróbuj ponownie..</p>';
		die();
	}

	function gotowe()
	{
	  echo '<h1 style="color: green" title="ENG: (Message was sent.)">Twoja wiadomość została wysłana.</h1>';
	}

	if ( isset($_POST) )
	{
		// Odbiorca
		$adresat				= $config_array['EMAIL']['adresat']; // Adres e-Mail na który ma zostać wysłany formularz

		// Dane formularza
		$nadawca				= $_POST['nadawca_pole_formularza'];
		$nadawca_email			= $_POST['nadawca_email_pole_formularza'];
	/*
		$nadawca_telefon		= $_POST['nadawca_telefon_pole_formularza'];
		$nadawca_firma			= $_POST['nadawca_firma_pole_formularza'];
	*/
		$temat_wiadomosci		= isset($_POST['temat_wiadomosci_pole_formularza']) ? $_POST['temat_wiadomosci_pole_formularza'] : null;
		$tresc_wiadomosci		= $_POST['tresc_wiadomosci_pole_formularza'];
		$posrednik				= "no-reply@bartinfinity.com";

		// ReCaptcha NoCaptcha
		$g_recaptcha_response	= $_POST['g_recaptcha_response'];
		$g_recaptcha_secret 	= $config_array['CAPTCHA']['secret'];

		// ReCaptcha NoCaptcha
		if (!$g_recaptcha_response)
		{
			blad('<li>Formularz weryfikacji Google reCAPTCHA nie został wypełniony.</li>');
			exit;
		}
		else
		{
			$g_recaptcha_result=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$g_recaptcha_secret."&response=".$g_recaptcha_response."&remoteip=".$_SERVER['REMOTE_ADDR']), true); // json musi być https:// nie może być //
		}

		// Wytyczne do sprawdzenia danych
		$nadawca_email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
		$nadawca_exp = "/^[A-Za-z ęóąśłżźćńĘÓĄŚŁŻŹĆŃ]+$/";
	/*
		$nadawca_telefon_exp = "/^[0-9 ]+$/";
	*/

		// Sprawdzanie formularza w poszukiwaniu błędów
		$bledy = array();

		if ( $adresat == null ) // Tutaj jest bloczek, który sprawdza czy dane pola są uzupełnione
			array_push($bledy, 'Wystąpił problem z adresatem wiadomości.');
    
		if ( $nadawca == null )
			array_push($bledy, 'Nadawca wiadomości nie może być pusty (twoje imię lub nick).');
    
		if ( $nadawca_email == null )
			array_push($bledy, 'Adres e-Mail nadawcy nie może być pusty (twój adres e-Mail).');
    
		if ( $temat_wiadomosci == null )
			array_push($bledy, 'Temat wiadomości nie może być pusty.');
    
		if ( $tresc_wiadomosci == null )
			array_push($bledy, 'Treść wiadomości nie może być pusta.');

		if ( $nadawca_email != null && !preg_match($nadawca_email_exp, $nadawca_email) ) // Tutaj sprawdza, czy e-Mail jest poprawnie uzupełniony
			array_push($bledy, 'Adres e-Mail nie wygląda na autentyczny.');

/*
		if ( $nadawca != null && !preg_match($nadawca_exp, $nadawca) ) // Tutaj sprawdza, czy Imię lub Nick nie zawiera jakichś dziwnych znaków
			array_push($bledy, 'Imię lub Nick zawiera nienaturalne znaki.');
*/

/*
		if ( $nadawca_telefon != null && !preg_match($nadawca_telefon_exp,$adresat_telefon) ) // Tutaj sprawdza, czy telefon zawiera cyfry tylko wtedy, gdy jest coś wpisane [inaczej widzi pole które jest ukryte i traktuje je jako błąd]
			array_push($bledy, 'Numer telefonu powinien zawierać wyłącznie cyfry.');
*/
		if ( $tresc_wiadomosci != null && strlen($tresc_wiadomosci) < 10 || strlen($tresc_wiadomosci) > 1000 ) // Tutaj sprawdza długość wiadomości
			array_push($bledy, 'Wiadomość jest zbyt krótka lub zbyt długa.');

		if ( strlen($nadawca) > 50			||
			 strlen($nadawca_email) > 50	||
			 strlen($temat_wiadomosci) > 100 ) // Tutaj jest bloczek, który sprawdza długość poszczególnych pól
			array_push($bledy, 'Przekroczono maksymalną ilość znaków w niektórych polach.');

		if ($g_recaptcha_result['success'] == false) // Tutaj sprawdza, czy reCAPtCHa zwraca success
		{
			array_push($bledy, 'Weryfikacja Google reCAPTCHA nie przeszła poprawnie!<br />
								Twoje działanie zostało zarejestrowane jako podejrzane, a dane przesłane do administratora serwisu w celu weryfikacji.');
		}

		if ( empty($bledy) )  // KONIEC WALIDACJI - WYSYŁAMY EMAIL
		{

			$gotowa_wiadomosc = '<html>

		<h1 style="background: #3333dd; color: white; padding: 1em; margin: auto; border-radius: 8px;">Formularz Kontaktowy</h1>

		<table style="border: 3px solid black; margin: 10px; font-size: 16px; font-family: sans-serif;">
			<tr>
				<td colspan="2" style="padding: 10px;">
					<strong>Szczegóły Wiadomości</strong>
				</td>
			</tr>
			<tr>
				<td style="padding: 10px; width: 150px;"><strong>Imię/Nick:</strong></td>
				<td style="padding: 10px;">'.$nadawca.'</td>
			</tr>
			<tr>
				<td style="padding: 10px;"><strong>Adres e-Mail:</strong></td>
				<td style="padding: 10px;"><a href="mailto:'.$nadawca_email.'">'.$nadawca_email.'</a></td>
			</tr>
			<tr>
				<td style="padding: 10px; width: 150px;"><strong>Temat:</strong></td>
				<td style="padding: 10px;">'.$temat_wiadomosci.'</td>
			</tr>
				<tr>
				<td colspan="2" style="padding: 10px;"><strong>Treść wiadomości:</strong></td>
			</tr>
			<tr>
				<td colspan="2" style="padding: 10px;"><div style="min-width: 400px; max-width: 400px; min-height: 75px; border: 1px solid black; padding: 5px;">'.$tresc_wiadomosci.'</div></td>
			</tr>
		</table>

		<p>--</p>
		<p>Ta wiadomość została wysłana przez formularz kontaktowy na stronie <a href="https://www.BartInfinity.com/contact">www.BartInfinity.com/contact</a>.</p>

		</html>';

			// Nagłówek wiadomości e-Mail
			$naglowek_rozszerzony = array(	//"From: $adresat <$adresat_email>",// Uzywamy domeny z ktorej wychodzi eMail, a nie adresu adresata - lepsza polityka
											"From: BartInfinity.com <$posrednik>",
											"Reply-To: $nadawca <$nadawca_email>",
											"X-Mailer: PHP/".PHP_VERSION,
											"MIME-Version: 1.0",
											"Content-Type: text/html; charset=UTF-8"
										 );
			$naglowek_rozszerzony = implode("\r\n", $naglowek_rozszerzony); // Bo wszystkie enetery w funkcji mail() musza byc windowsowe

			if ( mail(
				  $adresat,
				  "[BartInfinity.com] Formularz Kontaktowy - \"$nadawca\" - $temat_wiadomosci ",
				  $gotowa_wiadomosc,
				  $naglowek_rozszerzony )
			   )
				gotowe();
			else
				blad('Wiadomość nie mogła zostać wysłana z powodu błędu serwera.');

		}

		else
		{
			blad($bledy);
		}

	}

	else // Gdyby coś poszło nie tak
	{
		blad('Nastąpiło nieoczekiwane zatrzymanie skryptu.');
	}

?>
    	</div>
	</body>
</html>
