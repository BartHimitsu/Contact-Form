<?php

// Ogólne słówka
define("_kliknij_tutaj", "Click here");
define("_tytul_calej_aplikacji", "Contact Form");
define("_prawa_autorskie", "All rights reserved - <a href='https://www.bartinfinity.com' target='_blank' style='color: inherit;'>www.BartInfinity.com</a>");

// Front end of the contact form
define("_nadawca_pole_formularza", "Your name or nickname");
define("_nadawca_email_pole_formularza", "Your e-Mail address");
define("_nadawca_firma_pole_formularza", "Your company name");
define("_nadawca_telefon_pole_formularza", "Your phone number");
define("_reczny_temat_wiadomosci_pole_formularza", "Type topic of your message");
define("_temat_wiadomosci_pole_formularza", "Select topic of your message");
define("_tresc_wiadomosci_pole_formularza", "Type your message here...");
define("_zalaczniki_maksymalny_rozmiar_pole_formularza", "Maximum");
define("_falszywe_zalaczniki_pole_formularza", "Select files");
define("_tekst_do_falszywe_zalaczniki_pole_formularza", "No file selected");
define("_tekst_do_falszywe_zalaczniki_pole_formularza_wybrano", "Number of files: ");
define("_przycisk_wysylania", "Send message");

// Strona wysyłania formularza kontaktowego (silnik)
define("_gotowe_wiadomosc_wyslana", "Your message has been sent.");
define("_gotowe_wiadomosc2_wyslana", "You will soon receive confirmation of sending the form to your inbox. <br/> Please also check the spam/junk folder.");

// Sekcja weryfikacja błędów
define("_bledy_naglowek", "There was a problem processing your message!");
define("_bledy_opis", "The following errors have been detected:");
define("_bledy_stopka", "Your message has not been sent.");
define("_bledy_stopka_aby_wrocic", ", to go back and try again.");
define("_bledy_stopka_aby_zamknac", ", to close the window and try again.");
define("_bledy_recaptcha", "Google reCAPTCHA verification form has not been completed.");
define("_bledy_recaptcha_zla", "Google reCAPTCHA verification failed!<br />Your action has been registered as suspicious and the data sent to the site administrator for verification.");
define("_bledy_blad_ogolny", "There is a problem with the communication between the script and the form.");
define("_bledy_php_file_blad_1", "Value: 1; The uploaded file exceeds the upload_max_filesize directive in php.ini.");
define("_bledy_php_file_blad_2", "Value: 2; The uploaded file exceeds the MAX_FILE_SIZE directive specified in the HTML form.");
define("_bledy_php_file_blad_3", "Value: 3; The uploaded file has only been partially uploaded.");
define("_bledy_php_file_blad_4", "Value: 4; No file has been uploaded.");
define("_bledy_php_file_blad_6", "Value: 6; No temporary folder.");
define("_bledy_php_file_blad_7", "Value: 7; Failed to save file to disk.");
define("_bledy_php_file_blad_8", "Value: 8; The PHP extension has stopped transferring the file. PHP cannot determine which extension caused the file to stop; it can be helpful to check the list of loaded extensions using phpinfo ().");
define("_bledy_pliki_zle_rozszerzenie", "Attached file extension is not allowed.");
define("_bledy_pliki_zbyt_duzy_plik", "The attached file is too large.");
define("_bledy_adresat", "There was a problem with the recipient of the message.");
define("_bledy_nadawca", "The sender of the message cannot be empty (your name or nickname).");
define("_bledy_nadawca_zly", "Name or nickname contains unnatural characters.");
define("_bledy_nadawca_zbyt_dlugi", "The maximum number of characters in the sender's name has been exceeded.");
define("_bledy_nadawca_email_pusty", "The sender's e-mail address cannot be empty (your e-mail address).");
define("_bledy_nadawca_email_zly", "The e-mail address does not look authentic.");
define("_bledy_nadawca_email_zbyt_dlugi", "The maximum number of characters in the sender's e-mail address has been exceeded.");
define("_bledy_temat_wiadomosci", "The subject of the message cannot be empty.");
define("_bledy_temat_wiadomosci_zbyt_dlugi", "The maximum number of characters in the subject of the message has been exceeded.");
define("_bledy_tresc_wiadomosci", "The content of the message cannot be empty.");
define("_bledy_tresc_wiadomosci_zla", "The message is too short or too long.");
define("_bledy_wymagamy_akceptacji", "We require consent / acceptance of the required conditions.");
define("_bledy_zly_numer_telefonu", "The phone number should only contain numbers.");
define("_bledy_firma_zbyt_dluga", "The maximum number of characters in the company name has been exceeded.");
define("_bledy_nie_mozna_wyslac_maila", "The message could not be sent due to a server error.");

// Sekcja adresu e-Mail WIADOMOŚĆ #1
define("_wiadomosc1_naglowek", "Formularz Kontaktowy");

// Sekcja adresu e-Mail WIADOMOŚĆ #2
define("_wiadomosc2_naglowek", "Contact Form");
define("_wiadomosc2_tresc_potwierdzenie", "This message confirms that the contact form has been sent from the site");
define("_wiadomosc2_tresc_podglad", "Below is a preview of the content you provided through the above-mentioned form.");
define("_wiadomosc2_tresc_szczegoly_wiadomosci", "Message Details");
define("_wiadomosc2_tresc_imie", "Name/nickname:");
define("_wiadomosc2_tresc_adres_email", "e-Mail address:");
define("_wiadomosc2_tresc_adres_firma", "Company:");
define("_wiadomosc2_tresc_adres_telefon", "Phone:");
define("_wiadomosc2_tresc_temat", "Subject:");
define("_wiadomosc2_tresc_tresc_wiadomosci", "Message content:");
define("_wiadomosc2_tresc_notka_o_plikach", "Please note that for security and privacy reasons the files you attach are not included in this message.");
define("_wiadomosc2_stopka_automatyczna_wiadomosc", "This message was sent automatically via the contact form on the website");
define("_wiadomosc2_stopka_prosimy_nieodpowiadac", "Please do not reply to this message.");

?>