<?php

// Ogólne słówka
define("_kliknij_tutaj", "Kliknij tutaj");
define("_tytul_calej_aplikacji", "Formularz Kontaktowy");
define("_prawa_autorskie", "Wszystkie prawa zastrzeżone - <a href='https://www.BartHimitsu.com' target='_blank' style='color: inherit;'>www.BartHimitsu.com</a>");

// Frontowa strona formularza kontaktowego
define("_nadawca_pole_formularza", "Twoje imię lub pseudonim");
define("_nadawca_email_pole_formularza", "Twój adres poczty e-Mail");
define("_nadawca_firma_pole_formularza", "Nazwa Twojej firmy");
define("_nadawca_telefon_pole_formularza", "Numer Twojego telefonu");
define("_reczny_temat_wiadomosci_pole_formularza", "Wpisz temat Twojej wiadomości");
define("_temat_wiadomosci_pole_formularza", "Wybierz temat Twojej wiadomości");
define("_tresc_wiadomosci_pole_formularza", "Tutaj wpisz treść Twojej wiadomości...");
define("_zalaczniki_maksymalny_rozmiar_pole_formularza", "Maksymalnie");
define("_falszywe_zalaczniki_pole_formularza", "Wybierz pliki");
define("_tekst_do_falszywe_zalaczniki_pole_formularza", "Nie wybrano żadnego pliku");
define("_tekst_do_falszywe_zalaczniki_pole_formularza_wybrano", "Liczba plików: ");
define("_przycisk_wysylania", "Wyślij wiadomość");

// Strona wysyłania formularza kontaktowego (silnik)
define("_gotowe_wiadomosc_wyslana", "Twoja wiadomość została wysłana.");
define("_gotowe_wiadomosc2_wyslana", "Wkrótce otrzymasz potwierdzenie wysłania formularza na swoją skrzynkę odbiorczą. <br/> Prosimy sprawdzić również folder spam/śmieci.");

// Sekcja weryfikacja błędów
define("_bledy_naglowek", "Wystąpił problem z przetworzeniem twojej wiadomości!");
define("_bledy_opis", "Wykryto następujące błędy:");
define("_bledy_stopka", "Twoja wiadomość nie została wysłana.");
define("_bledy_stopka_aby_wrocic", ", aby wrócić i spróbować ponownie.");
define("_bledy_stopka_aby_zamknac", ", aby zamknąć kartę i spróbuj ponownie.");
define("_bledy_recaptcha", "Formularz weryfikacji Google reCAPTCHA nie został wypełniony.");
define("_bledy_recaptcha_zla", "Weryfikacja Google reCAPTCHA nie przeszła poprawnie!<br />Twoje działanie zostało zarejestrowane jako podejrzane, a dane przesłane do administratora serwisu w celu weryfikacji.");
define("_bledy_blad_ogolny", "Wystąpił problem z komunikacją między skryptem a formularzem.");
define("_bledy_php_file_blad_1", "Wartość: 1; Przesłany plik przekracza dyrektywę upload_max_filesize w php.ini.");
define("_bledy_php_file_blad_2", "Wartość: 2; Przesłany plik przekracza dyrektywę MAX_FILE_SIZE określoną w formularzu HTML.");
define("_bledy_php_file_blad_3", "Wartość: 3; Przesłany plik został przesłany tylko częściowo.");
define("_bledy_php_file_blad_4", "Wartość: 4; Żaden plik nie został przesłany.");
define("_bledy_php_file_blad_6", "Wartość: 6; Brak folderu tymczasowego.");
define("_bledy_php_file_blad_7", "Wartość: 7; Nie udało się zapisać pliku na dysk.");
define("_bledy_php_file_blad_8", "Wartość: 8; Rozszerzenie PHP zatrzymało przesyłanie pliku. PHP nie pozwala ustalić, które rozszerzenie spowodowało zatrzymanie przesyłania pliku; pomocne może być sprawdzenie listy załadowanych rozszerzeń za pomocą phpinfo ().");
define("_bledy_pliki_zle_rozszerzenie", "Rozszerzenie załączonego pliku jest niedozwolone.");
define("_bledy_pliki_zbyt_duzy_plik", "Załączone plik/i są zbyt wielkie.");
define("_bledy_adresat", "Wystąpił problem z adresatem wiadomości.");
define("_bledy_nadawca", "Nadawca wiadomości nie może być pusty (twoje imię lub nick).");
define("_bledy_nadawca_zly", "Imię lub pseudonim zawiera nienaturalne znaki.");
define("_bledy_nadawca_zbyt_dlugi", "Przekroczono maksymalną ilość znaków w nazwie nadawcy.");
define("_bledy_nadawca_email_pusty", "Adres e-Mail nadawcy nie może być pusty (twój adres e-Mail).");
define("_bledy_nadawca_email_zly", "Adres e-Mail nie wygląda na autentyczny.");
define("_bledy_nadawca_email_zbyt_dlugi", "Przekroczono maksymalną ilość znaków w adresie email nadawcy.");
define("_bledy_temat_wiadomosci", "Temat wiadomości nie może być pusty.");
define("_bledy_temat_wiadomosci_zbyt_dlugi", "Przekroczono maksymalną ilość znaków w temacie wiadomości.");
define("_bledy_tresc_wiadomosci", "Treść wiadomości nie może być pusta.");
define("_bledy_tresc_wiadomosci_zla", "Wiadomość jest zbyt krótka lub zbyt długa.");
define("_bledy_wymagamy_akceptacji", "Wymagamy zgody/akceptacji wymaganych warunków.");
define("_bledy_zly_numer_telefonu", "Numer telefonu powinien zawierać wyłącznie cyfry.");
define("_bledy_firma_zbyt_dluga", "Przekroczono maksymalną ilość znaków w nazwie firmy.");
define("_bledy_nie_mozna_wyslac_maila", "Wiadomość nie mogła zostać wysłana z powodu błędu serwera.");

// Sekcja adresu e-Mail WIADOMOŚĆ #1
define("_wiadomosc1_naglowek", "Formularz Kontaktowy");

// Sekcja adresu e-Mail WIADOMOŚĆ #2
define("_wiadomosc2_naglowek", "Formularz Kontaktowy");
define("_wiadomosc2_tresc_potwierdzenie", "Ta wiadomość jest potwierdzeniem wysłania formularza kontaktowego na stronie");
define("_wiadomosc2_tresc_podglad", "Poniżej jest podgląd treści, które przekazałeś przez wyżej wymieniony formularz.");
define("_wiadomosc2_tresc_szczegoly_wiadomosci", "Szczegóły Wiadomości");
define("_wiadomosc2_tresc_imie", "Imię/pseudonim:");
define("_wiadomosc2_tresc_adres_email", "Adres e-Mail:");
define("_wiadomosc2_tresc_adres_firma", "Firma:");
define("_wiadomosc2_tresc_adres_telefon", "Telefon:");
define("_wiadomosc2_tresc_temat", "Temat:");
define("_wiadomosc2_tresc_tresc_wiadomosci", "Treść wiadomości:");
define("_wiadomosc2_tresc_notka_o_plikach", "Należy pamiętać, że ze względu na bezpieczeństwo i prywatność załączone przez ciebie pliki nie są uwzględnione w tej wiadomości.");
define("_wiadomosc2_stopka_automatyczna_wiadomosc", "Ta wiadomość została wysłana automatycznie przez formularz kontaktowy na stronie");
define("_wiadomosc2_stopka_prosimy_nieodpowiadac", "Prosimy nie odpowiadać na tę wiadomość.");

?>