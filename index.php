<html>
  <head>
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
  	<link rel="stylesheet" type="text/css" href="./css/main.css">
    <script type="text/javascript" src="//code.jquery.com/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="//www.google.com/recaptcha/api.js?render=6LfYq9kUAAAAAJ-Ygxg8TnLRir_LiD-ycIPww0b4"></script>
  	<title>Formularz Kontaktowy</title>
  </head>
<style>
	
</style>
<script>
grecaptcha.ready(function()
    {
        grecaptcha.execute('6LfYq9kUAAAAAJ-Ygxg8TnLRir_LiD-ycIPww0b4', { action: 'contact' }).then(function (theToken)
            {
                var g_recaptcha_response = document.getElementById('g_recaptcha_response');
                g_recaptcha_response.value = theToken;
            });
    });
</script>
<body>









<form id="formularz_kontaktowy" method="post" action="./php/wysylanie_formularza.php">
  <div class="flex">
    <div class="pole_formularza">
      <input name="nadawca_pole_formularza" id="nadawca_pole_formularza" placeholder="Twoje imię lub nick" title="ENG: (Your fullname or nickname)">
      <label class="ikonka" for="nadawca_pole_formularza">
        <i class="fa fa-user fa-fw" aria-hidden="true"></i>
      </label>
    </div>
    <div class="pole_formularza">
      <input name="nadawca_email_pole_formularza" id="nadawca_email_pole_formularza" placeholder="Twój adres e-Mail" title="ENG: (Your e-Mail address)">
      <label class="ikonka" for="nadawca_email_pole_formularza">
        <i class="fa fa-envelope fa-fw" aria-hidden="true"></i>
      </label>
    </div>
  </div>
  <div class="flex">
<!--
    <div class="pole_formularza">
      <input name="nadawca_telefon_pole_formularza" id="nadawca_telefon_pole_formularza" placeholder="Twój numer telefonu">
      <label class="ikonka" for="nadawca_telefon_pole_formularza">
        <i class="fa fa-phone fa-fw" aria-hidden="true"></i>
      </label>
    </div>
-->
<!--
    <div class="pole_formularza">
      <input name="nadawca_firma_pole_formularza" id="nadawca_firma_pole_formularza" placeholder="Firma">
      <label class="ikonka" for="nadawca_firma_pole_formularza">
        <i class="fa fa-briefcase fa-fw" aria-hidden="true"></i>
      </label>
    </div>
-->
  </div>
<!--
  <div class="flex">
    <div class="pole_formularza">
      <input name="temat_wiadomosci_pole_formularza" id="temat_wiadomosci_pole_formularza" placeholder="Temat" value="This is hard setup value." readonly>
      <label class="ikonka" for="temat_wiadomosci_pole_formularza">
        <i class="fa fa-star fa-fw" aria-hidden="true"></i>
      </label>
    </div>
  </div>
-->
  <div class="flex">
    <div class="pole_formularza">
      <select name="temat_wiadomosci_pole_formularza" id="temat_wiadomosci_pole_formularza" placeholder="Wybierz temat twojej wiadomości" title="ENG: (Select topic of your message)">
        <option disabled selected>Wybierz temat twojej wiadomości</option>
        <option>Kontakt w sprawie serwera głosowego TeamSpeak</option>
        <option>Kontakt w sprawie serwera głosowego Discord</option>
        <option>Dostałem bana i chciałbym się odwołać</option>
        <option>Kontakt w sprawie serwera stron internetwych</option>
      	<option>Kontakt z właścicielem</option>
        <option>Kontakt w innej sprawie niż wymienione</option>
      </select>
      <label class="ikonka" for="temat_wiadomosci_pole_formularza" style="cursor: default;">
        <i class="fa fa-star fa-fw" aria-hidden="true"></i>
      </label>
    </div>
  </div>
  <div class="flex">
    <div class="pole_formularza">
    <textarea name="tresc_wiadomosci_pole_formularza" id="tresc_wiadomosci_pole_formularza" placeholder="Treść twojej wiadomości..." title="ENG: (Your message...)" rows="7" maxlength="1000" spellcheck="true"></textarea>
      <label class="ikonka" for="tresc_wiadomosci_pole_formularza">
        <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
      </label>
    </div>
  </div>
  <div class="flex">
    <div class="pole_formularza">
      <!-- Google reCAPTCHA v2 -->
      <!--<div class="g-recaptcha" data-sitekey=""></div>-->
      <!-- Google reCAPTCHA v3 -->
      <input type="hidden" name="g_recaptcha_response" id="g_recaptcha_response">
    </div>
    <div class="pole_formularza" style="text-align: right;"><div style="display: inline-block; position: relative;">
    <input id="przycisk_wysylania" type="submit" value="OK">
      <label class="ikonka" for="przycisk_wysylania" style="cursor: pointer;">
        <i class="fa fa-paper-plane fa-fw" aria-hidden="true"></i>
      </label>
    </div></div>
  </div>
</form>



</body>
</html>
