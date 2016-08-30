<?php

function died($error) {
    echo '<p><h2>Wystąpił problem z działaniem skryptu.</h2></p>';
    echo '<p>Wykryto następujące błędy:<ul>'.$error.'</ul></p>';
    echo '<p>Wiadomośc nie została wysłana.</p>';
    echo '<p><a href="javascript:history.go(-1)">Kliknij tutaj</a>, aby wrócić i spróbować ponownie.</p>';
    //echo '<p><a href="javascript:window.close()">Kliknij tutaj</a>, aby zamknąć kartę i spróbuj ponownie..</p>';
    die();
};

function done() {
  echo '<p><h1>Wiadomość została wysłana.</h1></p>';
}

if ( isset($_POST) ) {

  // Adresat
  $do         = 'email@domain.com'; // Adres e-Mail na który ma zostać wysłany formularz

  // Dane formularza
  $imie       = $_POST['name_field'];
  $email      = $_POST['address_field'];
  $telefon    = $_POST['phone_field'];
  $firma      = $_POST['company_field'];
  $temat      = /* 'Kontakt w sprawie serwera TeamSpeak'; */ $_POST['subject_field'];
  $wiadomosc  = $_POST['message_field'];

  $captcha    = $_POST['g-recaptcha-response'];

  // Nagłówek wiadomości e-Mail
  $headers = array('From: "'.$imie.'" <'.$email.'>',
                   'Reply-To: '.$email,
                   'X-Mailer: PHP/' . PHP_VERSION);
  $headers = implode("\r\n", $headers);

  // ReCaptcha NoCaptcha
  $secret = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
  if (!$captcha) {
    died('<li>Proszę wypełnić formularz reCAPTCHA.</li>');
    exit;
  }
  $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);

  // Wytyczne do sprawdzenia danych
  $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  $imie_exp = "/^[A-Za-z ęóąśłżźćńĘÓĄŚŁŻŹĆŃ]+$/";
  $telefon_exp = "/^[0-9 ]+$/";
  
  // Sprawdzanie formularza w poszukiwaniu błędów
  if ($response['success'] == false) { // Tutaj sprawdza, czy reCAPtCHa zwraca success
    died('<li>Walidacja reCAPTCHA nie przeszła poprawnie!<br />Twoje działanie zostało zarejestrowane, a dane przesłane do administratora.</li>');
    exit;
  } else if (  $imie == NULL ||
               $email == NULL ||
               $temat == NULL ||
               $wiadomosc == NULL ) { // Tutaj jest bloczek, który sprawdza czy dane pola są uzupełnione
    died('<li>Nie wszystkie wymagane pola zostały wypełnione.</li>');       
  } else if ( !preg_match($email_exp,$email) ) { // Tutaj sprawdza, czy e-Mail jest poprawnie uzupełniony
    died('<li>Adres e-Mail nie wygląda na autentyczny.</li>');
  } else if ( !preg_match($imie_exp,$imie) ) { // Tutaj sprawdza, czy Imię lub Nick nie zawiera jakichś dziwnych znaków
    died('<li>Imię lub Nick zawiera nienaturalne znaki.</li>');
  } else if ( !preg_match($telefon_exp,$telefon) && !$telefon == null ) { // Tutaj sprawdza, czy telefon zawiera cyfry tylko wtedy, gdy jest coś wpisane [inaczej widzi pole ktore jest ukryte i trkatuje je jako blad]
    died('<li>Numer telefonu powinien zawierać wyłącznie cyfry.');
  } else if ( strlen($wiadomosc) < 10 || strlen($wiadomosc)>1000 ) { // Tutaj sprawdza długość wiadomości
    died('<li>Wiadomość jest zbyt krótka lub zbyt długa.');
  } else if ( strlen($imie)>50    ||
              strlen($email)>50   ||
              strlen($telefon)>50 ||
              strlen($firma)>50   ||
              strlen($temat)>100 ) { // Tutaj jest bloczek, który sprawdza długość poszczególnych pól
    died('<li>Przekroczono maksymalną ilość znaków w niektórych polach.</li>');
  } else { done(); mail($do, $temat, $wiadomosc, $headers); };

} else { 
  died('<li>Nastąpiło nieoczekiwane zatrzymanie skryptu!</li>');
};

?>
