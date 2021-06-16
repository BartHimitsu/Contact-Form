<?php

	// Dane z pliku konfiguracyjnego - true oznacza, że wczyta sekcjami
		$config_array = array_merge(
			parse_ini_file("../.ini/config.ini", true /* wczyta sekcjami */),
			parse_ini_file("../.ini/secure.ini", true));

	// Startowanie sesji przeglądarki dla zmiany języka
		session_start();

	// Podgląd configu do testów
		//print("<pre>".print_r($config_array, true)."</pre>");

	// Ustawienia PHP
		// ini_set('upload_max_filesize', '5M');
		// ini_set('post_max_size', '5M');

	// Pokazywanie błędow
		if ( $config_array['USTAWIENIA']['wlacz_tryb_debugowania'] == true )
		{
			error_reporting(-1);
			ini_set('display_errors', 1);
			//	set_error_handler("var_dump");
		};

	// Wczytaj plik z tłumaczeniem
		if( isset($_SESSION['lang']) ) {
			include "../.lang/lang_".$_SESSION['lang'].".php";
		} else {
			include "../.lang/lang_" . strtolower($config_array['WYBOR_JEZYKA']['domyslnie_ladowany_jezyk']).".php";
		};

	// Funkcja Błędu
		$bledy = [];
		function blad($error) {
			echo '<h2 style="color: red">'._bledy_naglowek.'</h2>';
			if ( !empty($error) )
			{
				is_array($error) ? $error : $error = explode(';', $error);
				echo '<p>'._bledy_opis.'</p>';
				echo '<ul><li>' . implode('<li>', $error) . '</ul>';
			};
			echo '<p style="color: red">'._bledy_stopka.'</p>';
			echo '<p><a href="javascript:history.go(-1)">'._kliknij_tutaj.'</a>'._bledy_stopka_aby_wrocic.'</p>';
			//echo '<p><a href="javascript:window.close()">'._kliknij_tutaj.'</a>'._bledy_stopka_aby_zamknac.'</p>';
			die();
		};

	// Funkcja gotowej wiadomości
		function gotowe($wiadomosc) {
			if ( !empty($wiadomosc) )
			{
				is_array($wiadomosc) ? $wiadomosc : $wiadomosc = explode(';', $wiadomosc);
				echo '<h3>'.implode('<br>', $wiadomosc).'</h3>';
			} else
				echo '<h1 style="color: green">'._gotowe_wiadomosc_wyslana.'</h1>';
		};

?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Formularz Kontaktowy</title>
		<style>
			body, html
			{
				margin: 0;
				padding: 0;
				height: 100%;
			}
		</style>
	</head>
	<body style="display: flex;">
		<div style="display: block; margin: auto;">



<?php

// Ustawienia pobrane z formularza i ogólne zmienne
	if( isset($_POST) ) {

	// Odbiorca = Adresat
		$adresat				= $config_array['EMAIL']['adresat']; // Adres e-Mail na który ma zostać wysłany formularz

	// Aktualny adres
		$adres_strony  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
		$adres_strony .= $_SERVER['SERVER_NAME'];
		$adres_strony .= $_SERVER['REQUEST_URI'];
		$adres_strony_formularza = dirname(dirname($adres_strony));

	// Dane formularza
		$nadawca 				= $_POST['nadawca_pole_formularza'];
		$nadawca_email 			= $_POST['nadawca_email_pole_formularza'];

	// Telefon i Firma
		$nadawca_firma 			= isset($_POST['nadawca_firma_pole_formularza']) ? $_POST['nadawca_firma_pole_formularza'] : null;
		$nadawca_telefon 		= isset($_POST['nadawca_telefon_pole_formularza']) ? $_POST['nadawca_telefon_pole_formularza'] : null;

	// Przyciski akceptacji
		if ($config_array['AKCEPTACJA_WARUNKI']['czy_wyswietlic_ackeptacje'] == true)
		{
			$przyciski_akceptacji 				= [];
			$przyciski_akceptacji['id'] 		= [];
			$przyciski_akceptacji['wymagany'] 	= [];

			for ( $klucz = 0; $klucz < count($config_array['AKCEPTACJA_WARUNKI']['warunek']); $klucz++ )
			{
				
				array_push($przyciski_akceptacji['id'], isset($_POST['przycisk_akceptacji_pole_formularza_warunek_'.$klucz]) ? $_POST['przycisk_akceptacji_pole_formularza_warunek_'.$klucz] : null);
			};

			foreach(explode(',', $config_array['AKCEPTACJA_WARUNKI']['wymagane_warunki']) as $klucz => $wartosc) // Czyścimy spacje z pliku ini
				$przyciski_akceptacji['wymagany'][$klucz] = trim($wartosc);
		};

	// Reszta danych z formularza
//		$temat_wiadomosci 		= isset($_POST['temat_wiadomosci_pole_formularza']) ? $_POST['temat_wiadomosci_pole_formularza'] : null;
		$temat_wiadomosci 		= ($config_array['TEMATY']['czy_pozwolic_wpisac_temat'] == true ? $_POST['reczny_temat_wiadomosci_pole_formularza'] :
									(isset($_POST['temat_wiadomosci_pole_formularza']) ? $_POST['temat_wiadomosci_pole_formularza'] : null));
		$tresc_wiadomosci 		= $_POST['tresc_wiadomosci_pole_formularza'];
		$posrednik_nazwa 		= $config_array['POSREDNIK']['nazwa_posrednika'];
		$posrednik_email 		= $config_array['POSREDNIK']['email_posrednika'];

	// ReCaptcha NoCaptcha
		$g_recaptcha_response	= $_POST['g_recaptcha_response'];
		$g_recaptcha_secret 	= $config_array['CAPTCHA']['secret_key'];

	// ReCaptcha NoCaptcha
		if ( !$g_recaptcha_response ) {
			blad(_bledy_recaptcha);
			exit;
		}
	// ReCaptcha NoCaptcha Else
		else {
			$g_recaptcha_result=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$g_recaptcha_secret."&response=".$g_recaptcha_response."&remoteip=".$_SERVER['REMOTE_ADDR']), true); // json musi być https:// nie może być //
		}

	// Wytyczne do sprawdzenia danych
		$nadawca_email_exp = isset($config_array['USTAWIENIA']['kryteria_sprawdzania_email']) ? "/".($config_array['USTAWIENIA']['kryteria_sprawdzania_email'])."/" : null;
		$nadawca_exp = isset($config_array['USTAWIENIA']['kryteria_sprawdzania_nicku']) ? "/".($config_array['USTAWIENIA']['kryteria_sprawdzania_nicku'])."/" : null;
		$nadawca_telefon_exp = isset($config_array['USTAWIENIA']['kryteria_sprawdzania_numeru']) ? "/".($config_array['USTAWIENIA']['kryteria_sprawdzania_numeru'])."/" : null;

	}
// Else do ustawień
	else {
		blad(_bledy_blad_ogolny);
	}

// Załączone pliki
    if ( isset($_FILES['zalaczniki_pole_formularza']) )
    {
		$zalaczone_pliki = $_FILES['zalaczniki_pole_formularza'];
		if ( !empty($zalaczone_pliki) )
		{

            // Tutaj wycina rozszerzenie dla kazdego pliku i wrzuca do zbioru
			foreach($zalaczone_pliki['name'] as $plik )
				$zalaczone_pliki['extension'][] = substr($plik, strrpos($plik, '.') + 1);
    
            // Tutaj oblicza rozmiar dla kazdego pliku i wrzuca do zbioru
			foreach($zalaczone_pliki['size'] as $plik )
				$zalaczone_pliki['sizekb'][] = $plik/1024; // Rozmiar w KB

            // Tutaj wrzuca do zbioru jakie sa dozwolone rozszerzenia z pliku konfiguracyjnego
			foreach(explode(',', $config_array['USTAWIENIA']['dozwolone_pliki']) as $klucz => $wartosc) // Czyścimy spacje z pliku ini
				$zalaczone_pliki['allowed_extension'][$klucz] = trim($wartosc);

            // Tutaj sa sprawdzane bledy z PHP'a odnosnie plikow
            if ( empty($bledy) )
            {

				$brak_plikow = false;

				for ( $klucz = 0; $klucz < count($zalaczone_pliki['name']); $klucz++ )
					if ( $zalaczone_pliki['error'][$klucz] != 0 )
                        switch ($zalaczone_pliki['error'][$klucz])
                        {

                            // Wartość: 1; Przesłany plik przekracza dyrektywę upload_max_filesize w php.ini.
							case 1:
								array_push($bledy, _bledy_php_file_blad_1 . ' ("'.$zalaczone_pliki['name'][$klucz].'")' );
                            break;

                            // Wartość: 2; Przesłany plik przekracza dyrektywę MAX_FILE_SIZE określoną w formularzu HTML.
							case 2:
								array_push($bledy, _bledy_php_file_blad_2 . ' ("'.$zalaczone_pliki['name'][$klucz].'")' );
                            break;

                            // Wartość: 3; Przesłany plik został przesłany tylko częściowo.
							case 3:
								array_push($bledy, _bledy_php_file_blad_3 . ' ("'.$zalaczone_pliki['name'][$klucz].'")' );
                            break;

                            // Wartość: 4; Żaden plik nie został przesłany.
							case 4:
								if ( $config_array['USTAWIENIA']['czy_pliki_sa_wymagane'] == true )
									array_push($bledy, _bledy_php_file_blad_4);
								else
									$brak_plikow = true;
									continue;
                            break;

                            // Wartość: 6; Brak folderu tymczasowego.
							case 6:
								array_push($bledy, _bledy_php_file_blad_6);
                            break;

                            // Wartość: 7; Nie udało się zapisać pliku na dysk.
							case 7:
								array_push($bledy, _bledy_php_file_blad_7 . ' ("'.$zalaczone_pliki['name'][$klucz].'")');
                            break;

                            // Wartość: 8; Rozszerzenie PHP zatrzymało przesyłanie pliku. PHP nie pozwala ustalić, które rozszerzenie spowodowało zatrzymanie przesyłania pliku; pomocne może być sprawdzenie listy załadowanych rozszerzeń za pomocą phpinfo ().
							case 8:
								array_push($bledy, _bledy_php_file_blad_8);
                            break;

						};

				for ( $klucz = 0; $klucz < count($zalaczone_pliki['name']); $klucz++ )
					if ( $zalaczone_pliki['extension'][$klucz] != null && !in_array($zalaczone_pliki['extension'][$klucz], $zalaczone_pliki['allowed_extension'] ) )
						array_push($bledy, _bledy_pliki_zle_rozszerzenie . ' ("'.$zalaczone_pliki['name'][$klucz].'")' );

				for ( $klucz = 0; $klucz < count($zalaczone_pliki['name']); $klucz++ )
					if ( $zalaczone_pliki['sizekb'][$klucz] > $config_array['USTAWIENIA']['max_rozmiar_pliku'])
						array_push($bledy, _bledy_pliki_zbyt_duzy_plik . ' ("'.$zalaczone_pliki['name'][$klucz].'")');

			} else {
				blad($bledy);
            };

            // Tutaj liczy ogolnie ile jest plikow i wrzuca je do glownego zbioru z plikami
            $zalaczone_pliki['total_count'] = count(array_filter($zalaczone_pliki['name']));

            // Tutaj jest kodowana zawartosc zalaczonych plikow w base64
			$zalaczone_pliki['content'] = [];
			for ( $klucz = 0; $klucz < count($zalaczone_pliki['name']); $klucz++ )
			{
				array_push($zalaczone_pliki['content'],
					$zalaczone_pliki['tmp_name'][$klucz] ? chunk_split(base64_encode(file_get_contents($zalaczone_pliki['tmp_name'][$klucz]))) : null);
			};

		};



	};




{	// Sprawdzanie formularza w poszukiwaniu błędów
	if ( $adresat == null ) // Tutaj jest bloczek, który sprawdza czy dane pola są uzupełnione
		array_push($bledy, _bledy_adresat);

	if ( $nadawca == null )
		array_push($bledy, _bledy_nadawca);

	if ( $nadawca != null &&
			!preg_match($nadawca_exp, $nadawca) &&
			$config_array['USTAWIENIA']['czy_sprawdzac_nick'] == true ) // Tutaj sprawdza, czy Imię lub Nick nie zawiera jakichś dziwnych znaków
		array_push($bledy, _bledy_nadawca_zly);

	if ( strlen($nadawca) > $config_array['USTAWIENIA']['max_dl_nadawcy'] )
	array_push($bledy, _bledy_nadawca_zbyt_dlugi);

	if ( $nadawca_email == null )
		array_push($bledy, _bledy_nadawca_email_pusty);

	if ( $nadawca_email != null &&
			!preg_match($nadawca_email_exp, $nadawca_email) &&
			$config_array['USTAWIENIA']['czy_sprawdzac_email'] == true ) // Tutaj sprawdza, czy e-Mail jest poprawnie uzupełniony
		array_push($bledy, _bledy_nadawca_email_zly);

	if ( strlen($nadawca_email) > $config_array['USTAWIENIA']['max_dl_email_nadawcy'] )
	array_push($bledy, _bledy_nadawca_email_zbyt_dlugi);

	if ( $temat_wiadomosci == null )
		array_push($bledy, _bledy_temat_wiadomosci);

	if ( $temat_wiadomosci != null &&
	strlen($temat_wiadomosci) > $config_array['TEMATY']['max_dl_tematu'] &&
	$config_array['TEMATY']['czy_pozwolic_wpisac_temat'] == true )
		array_push($bledy, _bledy_temat_wiadomosci_zbyt_dlugi);

	if ( $tresc_wiadomosci == null )
		array_push($bledy, _bledy_tresc_wiadomosci);

	if ( $tresc_wiadomosci != null &&
			strlen($tresc_wiadomosci) < $config_array['USTAWIENIA']['min_dl_wiadomosci'] ||
			strlen($tresc_wiadomosci) > $config_array['USTAWIENIA']['max_dl_wiadomosci'] ) // Tutaj sprawdza długość wiadomości
		array_push($bledy, _bledy_tresc_wiadomosci_zla);

	if ( !empty($przyciski_akceptacji) )
		for ( $klucz = 0; $klucz < count($config_array['AKCEPTACJA_WARUNKI']['warunek']); $klucz++ )
		{
			if ( $przyciski_akceptacji['id'][$klucz] == null &&
				 $przyciski_akceptacji['wymagany'][$klucz] == 'true' ) // Tutaj sprawdza, czy Imię lub Nick nie zawiera jakichś dziwnych znaków
				array_push($bledy, _bledy_wymagamy_akceptacji);
		};

	if ( $nadawca_telefon != null && !preg_match($nadawca_telefon_exp, $nadawca_telefon) ) // Tutaj sprawdza, czy telefon zawiera cyfry tylko wtedy, gdy jest coś wpisane [inaczej widzi pole które jest ukryte i traktuje je jako błąd]
		array_push($bledy, _bledy_zly_numer_telefonu);

	if ( strlen($nadawca_firma) > $config_array['USTAWIENIA']['max_dl_firmy'] )
		array_push($bledy, _bledy_firma_zbyt_dluga);

	if ($g_recaptcha_result['success'] == false) // Tutaj sprawdza, czy reCAPtCHa zwraca success
	{
		array_push($bledy, _bledy_recaptcha_zla);
	}

};



// KONIEC WALIDACJI - WYSYŁAMY EMAIL
    if ( empty($bledy) )
    {






{	// WIADOMOŚĆ #1

	// W przypadku wiadomości email dzielonych na kilka typów - musi być wyznaczona taka granica (TO JEST BARDZO WAŻNE)
		$wiadomosc1_boundary = md5('random');

	// Tutaj sprawdza czy nazwa pośrednik to nazwa nadawcy
		$wiadomosc1_naglowek_posrednik = $config_array['POSREDNIK']['nazwa_posrednika_to_nadawca'] == true ? "$nadawca <$posrednik_email>" : "$posrednik_nazwa <$posrednik_email>";

	// Budowanie tematu WIADOMOŚĆ #1
		$wiadomosc1_temat = "[".$_SERVER['SERVER_NAME']."] "._wiadomosc1_naglowek." ".
			($config_array['USTAWIENIA']['pokazywac_nadawce_w_temacie_maila'] == true ? " - \"$nadawca\"" : '').
			($config_array['USTAWIENIA']['pokazywac_temat_w_temacie_maila'] == true ? " - $temat_wiadomosci" : '');

	// Budowanie nagłówka dla treści WIADOMOŚĆ #1
		$wiadomosc1_tresc_html = array(
			"--$wiadomosc1_boundary",
			"Content-Type: text/html; charset=UTF-8;",
			"Content-Transfer-Encoding: base64;",
			"\r\n"
			);
		$wiadomosc1_tresc_html = implode("\r\n", $wiadomosc1_tresc_html);

	// Treść WIADOMOŚĆ #1 (HTML)
{		$wiadomosc1_tresc_html = $wiadomosc1_tresc_html . chunk_split('<html>
	<head></head>
	<body>
	
	<h1 style="background: #3333dd; color: white; padding: 1em; margin: auto; border-radius: 8px;">[<a href="#" style="color: inherit; text-decoration: none;">'.$_SERVER['SERVER_NAME'].'</a>] Formularz Kontaktowy</h1>
	
	<table style="border: 3px solid black; margin: 10px; padding: 1em; font-size: 16px; font-family: sans-serif;">
		<tr>
			<td colspan="2" style="padding: 10px;">
				<strong>Szczegóły Wiadomości:</strong>
			</td>
		</tr>
		<tr>
			<td style="padding: 10px; width: 150px; text-align: right;"><strong>Imię/Nick:</strong></td>
			<td style="padding: 10px;">'.$nadawca.'</td>
		</tr>
		<tr>
			<td style="padding: 10px; width: 150px; text-align: right;"><strong>Adres e-Mail:</strong></td>
			<td style="padding: 10px;"><a href="mailto:'.$nadawca_email.'">'.$nadawca_email.'</a></td>
		</tr>
		<tr style="display: '.($nadawca_firma == null ? 'none' : 'inset').' ">
			<td style="padding: 10px; width: 150px; text-align: right;"><strong>Firma:</strong></td>
			<td style="padding: 10px;">'.$nadawca_firma.'</td>
		</tr>
		<tr style="display: '.($nadawca_telefon == null ? 'none' : 'inset').' ">
			<td style="padding: 10px; width: 150px; text-align: right;"><strong>Telefon:</strong></td>
			<td style="padding: 10px;"><a href="tel:'.$nadawca_telefon.'">'.$nadawca_telefon.'</a></td>
        </tr>
		<tr style="display: '.($zalaczone_pliki['total_count'] == null ? 'none' : 'inset').' ">
			<td style="padding: 10px; width: 150px; text-align: right;"><strong>Załączniki:</strong></td>
			<td style="padding: 10px;">'.$zalaczone_pliki['total_count'].'</td>
		</tr>
		<tr>
			<td style="padding: 10px; width: 150px; text-align: right;"><strong>Temat:</strong></td>
			<td style="padding: 10px;">'.$temat_wiadomosci.'</td>
		</tr>
			<tr>
			<td colspan="2" style="padding: 10px;"><strong>Treść wiadomości:</strong></td>
		</tr>
		<tr>
			<td colspan="2" style="padding: 10px;">
				<div style="min-width: 500px; max-width: 800px; min-height: 75px; border: 1px dotted black; padding: 1em; resize: both;">'.$tresc_wiadomosci.'</div>
			</td>
		</tr>
	</table>
	
	<p>--</p>
	<p>Ta wiadomość została wysłana przez formularz kontaktowy na stronie <a href="'.$adres_strony_formularza.'" target="_blank">'.$adres_strony_formularza.'</a>.</p>
	
	</body>
	</html>');
};

	// Załączniki WIADOMOŚĆ #1 (HTML)
		$wiadomosc1_tresc_zalaczniki = [];
		for( $klucz = 0 ; $klucz < count($zalaczone_pliki['name']) ; $klucz++ )
		{
			$zakodowany_zalacznik = $zalaczone_pliki['content'][$klucz];
			array_push($wiadomosc1_tresc_zalaczniki,
				"--$wiadomosc1_boundary",
				"Content-Type: ".$zalaczone_pliki['type'][$klucz]."; name=".$zalaczone_pliki['name'][$klucz].";",
				"Content-Disposition: attachment; filename=".$zalaczone_pliki['name'][$klucz].";",
				"Content-Transfer-Encoding: base64;",
				"X-Attachment-Id: ".rand(1000, 99999).";",
				"\r\n",
				$zakodowany_zalacznik."\r\n"
			);
		};
		$wiadomosc1_tresc_zalaczniki = implode("\r\n", $wiadomosc1_tresc_zalaczniki);

	// Główny nagłówek dla WIADOMOŚĆ #1 (HTML)
	//"From: $adresat <$adresat_email>",// Używamy domeny z której wychodzi eMail, a nie adresu adresata - lepsza polityka
		$wiadomosc1_naglowek = array(
										"From: $wiadomosc1_naglowek_posrednik;",
										"Reply-To: $nadawca <$nadawca_email>;",
										"X-Mailer: PHP/".PHP_VERSION.";",
										"MIME-Version: 1.0;",
										"Content-Type: multipart/mixed; boundary=$wiadomosc1_boundary;",
										"\r\n"
									 );
		$wiadomosc1_naglowek = implode("\r\n", $wiadomosc1_naglowek); // Bo wszystkie entery w funkcji mail() muszą być windowsowe

	// Zlepianie w całość WIADOMOŚĆ #1 (HTML)
		if ( $config_array['USTAWIENIA']['czy_wyswietlic_wybor_plikow'] == true && $brak_plikow != true )
			$wiadomosc1 = $wiadomosc1_tresc_html . "\r\n\r\n" . $wiadomosc1_tresc_zalaczniki;
		else 
			$wiadomosc1 = $wiadomosc1_tresc_html;

	// Wysyłanie WIADOMOŚĆ #1
		if ( $config_array['USTAWIENIA']['nie_wysylaj_lecz_zdekoduj_maile'] != true )
			if ( mail(
					$adresat,
					$wiadomosc1_temat,
					$wiadomosc1,
					$wiadomosc1_naglowek ) )
				gotowe("");
			else
				blad(_bledy_nie_mozna_wyslac_maila);

	// Podgląd dla WIADOMOŚĆ #1
		echo $config_array['USTAWIENIA']['nie_wysylaj_lecz_zdekoduj_maile'] == true ? $wiadomosc1 : null;

};






	if ($config_array['USTAWIENIA']['czy_wysylac_email_potwierdzajacy'] == true) {	// WIADOMOŚĆ #2

	// W przypadku wiadomości email dzielonych na kilka typów - musi być wyznaczona taka granica (TO JEST BARDZO WAŻNE)
		$wiadomosc2_boundary = md5('random');

	// Tutaj sprawdza czy nazwa pośrednik to nazwa nadawcy
		$wiadomosc2_naglowek_posrednik = "$posrednik_nazwa <$posrednik_email>";

	// Budowanie tematu WIADOMOŚĆ #2
		$wiadomosc2_temat = "[".$_SERVER['SERVER_NAME']."] "._wiadomosc2_naglowek." ".
			($config_array['USTAWIENIA']['pokazywac_nadawce_w_temacie_maila'] == true ? " - \"$nadawca\"" : '').
			($config_array['USTAWIENIA']['pokazywac_temat_w_temacie_maila'] == true ? " - $temat_wiadomosci" : '');

	// Budowanie nagłówka dla treści WIADOMOŚĆ #2
		$wiadomosc2_tresc_html = array(
			"--$wiadomosc2_boundary",
			"Content-Type: text/html; charset=UTF-8;",
			"Content-Transfer-Encoding: base64;",
			"\r\n"
			);
		$wiadomosc2_tresc_html = implode("\r\n", $wiadomosc2_tresc_html);

	// Treść WIADOMOŚĆ #2 (HTML)
{		$wiadomosc2_tresc_html = $wiadomosc2_tresc_html . chunk_split('<html>
	<head></head>
	<body>
	
	<h1 style="background: #3333dd; color: white; padding: 1em; margin: auto; border-radius: 8px;">[<a href="#" style="color: inherit; text-decoration: none;">'.$_SERVER['SERVER_NAME'].'</a>] '._wiadomosc2_naglowek.'</h1>
	
	<p>'._wiadomosc2_tresc_potwierdzenie.' <a href="'.$adres_strony_formularza.'" target="_blank">'.$adres_strony_formularza.'</a>.</p>
	
	<p>'._wiadomosc2_tresc_podglad.'</p>
	
	<table style="border: 3px solid black; margin: 10px; padding: 1em; font-size: 16px; font-family: sans-serif;">
		<tr>
			<td colspan="2" style="padding: 10px;">
				<strong>'._wiadomosc2_tresc_szczegoly_wiadomosci.'</strong>
			</td>
		</tr>
		<tr>
			<td style="padding: 10px; width: 150px; text-align: right;"><strong>'._wiadomosc2_tresc_imie.'</strong></td>
			<td style="padding: 10px;">'.$nadawca.'</td>
		</tr>
		<tr>
			<td style="padding: 10px; width: 150px; text-align: right;"><strong>'._wiadomosc2_tresc_adres_email.'</strong></td>
			<td style="padding: 10px;"><a href="mailto:'.$nadawca_email.'">'.$nadawca_email.'</a></td>
		</tr>
		<tr style="display: '.($nadawca_firma == null ? 'none' : 'inset').' ">
			<td style="padding: 10px; width: 150px; text-align: right;"><strong>'._wiadomosc2_tresc_adres_firma.'</strong></td>
			<td style="padding: 10px;">'.$nadawca_firma.'</td>
		</tr>
		<tr style="display: '.($nadawca_telefon == null ? 'none' : 'inset').' ">
			<td style="padding: 10px; width: 150px; text-align: right;"><strong>'._wiadomosc2_tresc_adres_telefon.'</strong></td>
			<td style="padding: 10px;"><a href="tel:'.$nadawca_telefon.'">'.$nadawca_telefon.'</a></td>
        </tr>
		<tr style="display: '.($zalaczone_pliki['total_count'] == null ? 'none' : 'inset').' ">
			<td style="padding: 10px; width: 150px; text-align: right;"><strong>Załączniki:</strong></td>
			<td style="padding: 10px;">'.$zalaczone_pliki['total_count'].'</td>
		</tr>
		<tr>
			<td style="padding: 10px; width: 150px; text-align: right;"><strong>'._wiadomosc2_tresc_temat.'</strong></td>
			<td style="padding: 10px;">'.$temat_wiadomosci.'</td>
		</tr>
			<tr>
			<td colspan="2" style="padding: 10px;"><strong>'._wiadomosc2_tresc_tresc_wiadomosci.'</strong></td>
		</tr>
		<tr>
			<td colspan="2" style="padding: 10px;">
				<div style="min-width: 500px; max-width: 800px; min-height: 75px; border: 1px dotted black; padding: 1em; resize: both;">'.$tresc_wiadomosci.'</div>
			</td>
		</tr>
    </table>
    
    <p style="display: '.($zalaczone_pliki['total_count'] == null ? 'none' : 'inset').'">'._wiadomosc2_tresc_notka_o_plikach.'</p>
	
	<p>--</p>
	<p>'._wiadomosc2_stopka_automatyczna_wiadomosc.' <a href="'.$adres_strony_formularza.'" target="_blank">'.$adres_strony_formularza.'</a>. <br />
	'._wiadomosc2_stopka_prosimy_nieodpowiadac.'</p>
	
	</body>
	</html>'));
};

	// Główny nagłówek dla WIADOMOŚĆ #2 (HTML)
	//"From: $adresat <$adresat_email>",// Używamy domeny z której wychodzi eMail, a nie adresu adresata - lepsza polityka
		$wiadomosc2_naglowek = array(
										"From: $wiadomosc2_naglowek_posrednik;",
										"Reply-To: $nadawca <$nadawca_email>;",
										"X-Mailer: PHP/".PHP_VERSION.";",
										"MIME-Version: 1.0;",
										"Content-Type: multipart/mixed; boundary=$wiadomosc2_boundary;",
										"\r\n"
									 );
		$wiadomosc2_naglowek = implode("\r\n", $wiadomosc2_naglowek); // Bo wszystkie entery w funkcji mail() muszą być windowsowe

	// Zlepianie w całość WIADOMOŚĆ #2 (HTML)
		$wiadomosc2 = $wiadomosc2_tresc_html;

	// Wysyłanie WIADOMOŚĆ #2
		if ( $config_array['USTAWIENIA']['nie_wysylaj_lecz_zdekoduj_maile'] != true )
			if ( mail(
					$nadawca_email,
					$wiadomosc2_temat,
					$wiadomosc2,
					$wiadomosc2_naglowek ) )
				gotowe(_gotowe_wiadomosc2_wyslana);
			else
				blad(_bledy_nie_mozna_wyslac_maila);

	// Podgląd dla WIADOMOŚĆ #2
		echo $config_array['USTAWIENIA']['nie_wysylaj_lecz_zdekoduj_maile'] == true ? $wiadomosc2 : null;

	};






	} else { // Else do sprawdzania błędów
		blad($bledy);
	};



?>



		</div>
	</body>
</html>
