<?php

	// Dane z pliku konfiguracyjnego
		$config_array = array_merge(
			parse_ini_file("./.ini/config.ini", true /* wczyta sekcjami */),
			parse_ini_file("./.ini/secure.ini", true));

	// Podgląd configu do testów
		//print("<pre>".print_r($config_array, true)."</pre>");
		
	// Startowanie sesji przeglądarki dla zmiany języka
		session_start();

	// Ustawianie języka
		if( isset($_GET['lang']) && !empty($_GET['lang']) ) {

			$wykryty_jezyk = strtolower($_GET['lang']);

			$_SESSION['lang'] = $wykryty_jezyk;

			if( isset($_SESSION['lang']) && $_SESSION['lang'] != $wykryty_jezyk ) {
				echo "<script type='text/javascript'> location.reload(); </script>";
			};
		};

	// Wczytaj plik z tłumaczeniem
		if( isset($_SESSION['lang']) ) {
			include "./.lang/lang_".$_SESSION['lang'].".php";
		} else {
			include "./.lang/lang_".strtolower($config_array['WYBOR_JEZYKA']['domyslnie_ladowany_jezyk']).".php";
		};

?>
<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
		<link rel="stylesheet" type="text/css" href="./.css/main.css">
		<link rel="shortcut icon" href="./.img/--pixabay.com-images-id-1083508-.png" type="image/x-icon" />
		<link rel="icon" href="./.img/--pixabay.com-images-id-1083508-.png" type="image/x-icon" />
		<script type="text/javascript" src="../../..jquery/.js/jquery-newest.min.js"></script>
		<script type="text/javascript" src="../../..ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="//www.google.com/recaptcha/api.js?render=<?php echo $config_array['CAPTCHA']['public_key'] ?>"></script>
		<title><?= _tytul_calej_aplikacji ?></title>
	</head>
	<script>
	grecaptcha.ready(function()
		{
			grecaptcha.execute('<?php echo $config_array['CAPTCHA']['public_key'] ?>', { action: 'contact' }).then(function (theToken)
				{
					var g_recaptcha_response = document.getElementById('g_recaptcha_response');
					g_recaptcha_response.value = theToken;
				});
		});
	</script>
<body>






<div id="kontener_formularzy">

	<div id="wybor_jezyka" style="display: <?php echo $config_array['WYBOR_JEZYKA']['czy_wyswietlic_wybor_jezyka'] == true ? "initial" : "none" ?>;">
		<p>
			<form method="get" action="" id="formularz_jezyka">
<!--
				<label for="przelacznik_jezyka" onclick="$(this).parent().find('input').val('1').parent().submit();"><img src="./img/flag-poland_1f1f5-1f1f1.png" /> Polski</label>

						<input type="range" id="przelacznik_jezyka" name="lang" min="1" max="2" value="<?php echo ( isset($_SESSION['lang']) && $_SESSION['lang'] == 'en' ) ? '2' : '1'; ?>" style="width: 3em;" onchange="$(this).parent().submit();" />

				<label for="przelacznik_jezyka" onclick="$(this).parent().find('input').val('2').parent().submit();"><img src="./img/flag-united-kingdom_1f1ec-1f1e7.png" /> English</label>
-->
				<select name="lang" id="przelacznik_jezyka" onchange="this.form.submit()">
					<option disabled <?php echo ( isset($_SESSION['lang']) ) ? '' : 'selected'; ?>><?= $config_array['WYBOR_JEZYKA']['lista_wybor_jezyka'] ?></option>
					<?php
						for ($i = 0; $i <= count($config_array['WYBOR_JEZYKA']['jezyk']); $i++)
						{
							if ( !empty($config_array['WYBOR_JEZYKA']['jezyk'][$i]) )
								echo "\t\t<option ".
								( isset($_SESSION['lang']) && $_SESSION['lang'] == strtolower( explode(':', $config_array['WYBOR_JEZYKA']['jezyk'][$i])[0] ) ? 'selected' : '' )
								." value=".
								( strtolower( explode(':', $config_array['WYBOR_JEZYKA']['jezyk'][$i])[0] ) )
								.">" . ucfirst( explode(':', $config_array['WYBOR_JEZYKA']['jezyk'][$i])[1] ) . "</option>\n";
						};
					?>
				</select>
			</form>
		</p>
	</div>



	<form id="formularz_kontaktowy" method="post" action="./.php/wysylanie_formularza.php" enctype="multipart/form-data">






	<div class="flex">

		<div class="kontener_pol_formularza">
			<div class="pole_formularza">
				<input name="nadawca_pole_formularza" id="nadawca_pole_formularza" class="element_formularza" placeholder="<?= _nadawca_pole_formularza ?>" limitznakow="<?php echo $config_array['USTAWIENIA']['max_dl_nadawcy']; ?>" />
				<label class="ikonka" for="nadawca_pole_formularza">
					<i class="fa fa-user fa-fw" aria-hidden="true"></i>
				</label>
			</div>
		</div>

		<div class="kontener_pol_formularza">
			<div class="pole_formularza">
				<input name="nadawca_email_pole_formularza" id="nadawca_email_pole_formularza" class="element_formularza" placeholder="<?= _nadawca_email_pole_formularza ?>" limitznakow="<?php echo $config_array['USTAWIENIA']['max_dl_email_nadawcy']; ?>">
				<label class="ikonka" for="nadawca_email_pole_formularza">
					<i class="fa fa-envelope fa-fw" aria-hidden="true"></i>
				</label>
			</div>
		</div>

	</div>



	<div class="flex">

		<div class="kontener_pol_formularza" style="display: <?php echo $config_array['USTAWIENIA']['czy_wyswietlic_firme'] == true ? "initial" : "none" ?>;">
			<div class="pole_formularza">
				<input name="nadawca_firma_pole_formularza" id="nadawca_firma_pole_formularza" class="element_formularza" placeholder="<?= _nadawca_firma_pole_formularza ?>" limitznakow="<?php echo $config_array['USTAWIENIA']['max_dl_firmy']; ?>">
				<label class="ikonka" for="nadawca_firma_pole_formularza">
					<i class="fa fa-briefcase fa-fw" aria-hidden="true"></i>
				</label>
			</div>
		</div>

		<div class="kontener_pol_formularza" style="display: <?php echo $config_array['USTAWIENIA']['czy_wyswietlic_numer'] == true ? "initial" : "none" ?>;">
			<div class="pole_formularza">
				<input name="nadawca_telefon_pole_formularza" id="nadawca_telefon_pole_formularza" class="element_formularza" placeholder="<?= _nadawca_telefon_pole_formularza ?>" pattern="<?php echo $config_array['USTAWIENIA']['kryteria_sprawdzania_numeru'] ?>">
				<label class="ikonka" for="nadawca_telefon_pole_formularza">
					<i class="fa fa-phone fa-fw" aria-hidden="true"></i>
				</label>
			</div>
		</div>

	</div>






	<div class="flex">
		<div class="kontener_pol_formularza" style="display: <?php echo $config_array['TEMATY']['czy_pozwolic_wpisac_temat'] == true ? "initial" : "none" ?>;">
			<div class="pole_formularza">
				<input name="reczny_temat_wiadomosci_pole_formularza" id="reczny_temat_wiadomosci_pole_formularza" class="element_formularza" placeholder="<?= _reczny_temat_wiadomosci_pole_formularza ?>" limitznakow="<?php echo $config_array['TEMATY']['max_dl_tematu']; ?>">
				<label class="ikonka" for="reczny_temat_wiadomosci_pole_formularza">
					<i class="fa fa-star fa-fw" aria-hidden="true"></i>
				</label>
			</div>
		</div>
	</div>



	<div class="flex">
		<div class="kontener_pol_formularza" style="display: <?php echo $config_array['TEMATY']['czy_pozwolic_wpisac_temat'] == true ? "none" : "initial" ?>;">
			<div class="pole_formularza">

				<select name="temat_wiadomosci_pole_formularza" id="temat_wiadomosci_pole_formularza" class="element_formularza">
				<option disabled selected><?= _temat_wiadomosci_pole_formularza ?></option>
		<?php
			for ($i = 0; $i <= count($config_array['TEMATY']['temat']); $i++)
			{
				if ( !empty($config_array['TEMATY']['temat'][$i]) )
					echo "\t\t<option>" . $config_array['TEMATY']['temat'][$i] . "</option>\n";
			};

		?>
				</select>
				<label class="ikonka" for="temat_wiadomosci_pole_formularza" style="cursor: default;">
					<i class="fa fa-star fa-fw" aria-hidden="true"></i>
				</label>

			</div>
		</div>
	</div>

	

	<div class="flex">
		<div class="kontener_pol_formularza">
			<div class="pole_formularza">

				<textarea name="tresc_wiadomosci_pole_formularza" id="tresc_wiadomosci_pole_formularza" class="element_formularza" placeholder="<?= _tresc_wiadomosci_pole_formularza ?>" rows="5" maxlength="1000" spellcheck="true" limitznakow="<?php echo $config_array['USTAWIENIA']['max_dl_wiadomosci']; ?>"></textarea>

				<label class="ikonka" for="tresc_wiadomosci_pole_formularza">
					<i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i>
				</label>

			</div>
		</div>
	</div>










	<div class="flex">
		<div class="kontener_pol_formularza" style="display: <?php echo $config_array['USTAWIENIA']['czy_wyswietlic_wybor_plikow'] == true ? "initial" : "none" ?>">
			<div class="pole_formularza">

				<span class="limit"><?= _zalaczniki_maksymalny_rozmiar_pole_formularza ?>: <?php echo $config_array['USTAWIENIA']['max_rozmiar_pliku']; ?> KB</span>

				<div class="przycisk_formularza">
					<input type="button" id="falszywe_zalaczniki_pole_formularza" class="element_formularza" value="<?= _falszywe_zalaczniki_pole_formularza ?>" onclick="document.getElementById('zalaczniki_pole_formularza').click();" />
					<label class="ikonka" for="zalaczniki_pole_formularza" style="cursor: default;">
						<i class="fas fa-paperclip fa-fw" aria-hidden="true"></i>
					</label>
				</div>

				<span id="tekst_do_falszywe_zalaczniki_pole_formularza"><?= _tekst_do_falszywe_zalaczniki_pole_formularza ?></span>

				<input type="file" multiple name="zalaczniki_pole_formularza[]" id="zalaczniki_pole_formularza" style="display: none;" onchange="document.getElementById('tekst_do_falszywe_zalaczniki_pole_formularza').innerHTML = this.files.length > 1 ? '<?= _tekst_do_falszywe_zalaczniki_pole_formularza_wybrano ?>' + this.files.length : this.value.substring(this.value.lastIndexOf('\\') + 1)" />
			
			</div>
		</div>
	</div>




	<div class="flex">

		<div class="kontener_pol_formularza sekcja_akceptacja" style="display: <?php echo $config_array['AKCEPTACJA_WARUNKI']['czy_wyswietlic_ackeptacje'] == true ? "initial" : "none" ?>;">
<?php 
			foreach(explode(',', $config_array['AKCEPTACJA_WARUNKI']['wymagane_warunki']) as $klucz => $wartosc)
				$czy_wymagany[$klucz] = trim($wartosc);

			for ( $klucz = 0; $klucz < count($config_array['AKCEPTACJA_WARUNKI']['warunek']); $klucz++ )
			{
				echo '<input id="przycisk_akceptacji_pole_formularza_warunek_'.$klucz.'" name="przycisk_akceptacji_pole_formularza_warunek_'.$klucz.'" type="checkbox" />
				<label for="przycisk_akceptacji_pole_formularza_warunek_'.$klucz.'">';
				echo $config_array['AKCEPTACJA_WARUNKI']['warunek'][$klucz];
				echo $czy_wymagany[$klucz] == 'true' ? '<span style="color: red;">*</span>' : null;
				echo '</label><br/>';
			};
?>
		</div>

		<div class="kontener_pol_formularza">

				<div class="przycisk_formularza" style="float: right;">
					<input id="przycisk_wysylania" class="element_formularza" type="submit" value="<?= _przycisk_wysylania ?>" />
					<label class="ikonka" for="przycisk_wysylania" style="cursor: pointer;">
						<i class="fas fa-paper-plane fa-fw" aria-hidden="true"></i>
					</label>
				</div>
			
			<input type="hidden" name="g_recaptcha_response" id="g_recaptcha_response" />

		</div>

	</div>



	</form>





	<div id="kontener_praw_autorskich">
		<p>
			<?= _prawa_autorskie ?> &copy; <script>document.write(new Date().getFullYear())</script><noscript>2020</noscript>
		</p>
	</div>


</div>





</body>
	<script type="text/javascript" >
		var wyciagnietyJezyk = "<?php echo isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en' ; ?>";
	</script>
	<script type="text/javascript" src="./.js/main.js"></script>
</html>
