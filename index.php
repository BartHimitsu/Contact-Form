<html>
  <head>
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
    <script type="text/javascript" src="//code.jquery.com/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="//www.google.com/recaptcha/api.js"></script>
  </head>
<body>



<style>
body, html {margin:0;padding:0;}
body {display:flex;}
#contact_form {
  width: 500px;
  padding: 50px;
  margin: auto;
  background: white;
  background: url('./bg.jpg');
  background-size: cover;
  box-shadow: 0px 0px 30px -5px rgba(0,0,0,0.5);
} #contact_form div.flex {
  display: flex;
  width: 100%;
} #contact_form div.field {
  position: relative;
  width: 100%;
  margin: 5px;
} #contact_form div.field input, #contact_form div.field select, #contact_form div.field textarea {
  width: 100%;
  box-sizing: border-box;
  padding: 10px;
  padding-left: 30px;
  outline: none;
  border: 1px solid rgba(0,0,0,0.2);
  border-radius: 4px;
  background: white;
  font-family: Arial;
  color: black;
} #contact_form div.field input:hover, #contact_form div.field select:hover, #contact_form div.field input:focus,
#contact_form div.field textarea:hover, #contact_form div.field select:hover, #contact_form div.field textarea:focus {
  border: 1px solid rgba(0,0,0,0.4);
} #contact_form div.field #submit_button {
  width: auto;
} #contact_form div.field #submit_button:hover {
  cursor: pointer;
} #contact_form div.field .icon {
  position: absolute;
  top: 9px;
  left: 7px;
  color: rgba(0,0,0,0.5);
  cursor: text;
} #contact_form div.field input:hover + .icon, #contact_form div.field input:focus + .icon,
#contact_form div.field select:hover + .icon, #contact_form div.field select:focus + .icon,
#contact_form div.field textarea:hover + .icon, #contact_form div.field textarea:focus + .icon {
  color: rgba(0,0,0,0.7);
}
</style>

<form id="contact_form" method="post" action="submit.php">
  <div class="flex">
    <div class="field">
      <input name="name_field" id="name_field" placeholder="Twój nick lub imię">
      <label class="icon" for="name_field">
        <i class="fa fa-user fa-fw" aria-hidden="true"></i>
      </label>
    </div>
    <div class="field">
      <input name="address_field" id="address_field" placeholder="Twój adres e-Mail">
      <label class="icon" for="address_field">
        <i class="fa fa-envelope fa-fw" aria-hidden="true"></i>
      </label>
    </div>
  </div>
  <div class="flex">
<!--
    <div class="field">
      <input name="phone_field" id="phone_field" placeholder="Twój numer telefonu">
      <label class="icon" for="phone_field">
        <i class="fa fa-phone fa-fw" aria-hidden="true"></i>
      </label>
    </div>
-->
<!--
    <div class="field">
      <input name="company_field" id="company_field" placeholder="Firma">
      <label class="icon" for="company_field">
        <i class="fa fa-briefcase fa-fw" aria-hidden="true"></i>
      </label>
    </div>
-->
  </div>
<!--
  <div class="flex">
    <div class="field">
      <input name="subject_field" id="subject_field" placeholder="Temat" value="This is hard setup value." readonly>
      <label class="icon" for="subject_field">
        <i class="fa fa-star fa-fw" aria-hidden="true"></i>
      </label>
    </div>
  </div>
-->
  <div class="flex">
    <div class="field">
      <select name="subject_field" id="subject_field" placeholder="Temat">
        <option value="" disabled selected>Temat</option>
        <option value="Kontakt w sprawie serwera TeamSpeak">Kontakt w sprawie serwera TeamSpeak</option>
        <option value="Rekrutacja na administratora">Rekrutacja na administratora</option>
        <option value="Rekrutacja na administratora">Podanie do grupy Stayły Bywalec</option>
      </select>
      <label class="icon" for="subject_field" style="cursor: default;">
        <i class="fa fa-star fa-fw" aria-hidden="true"></i>
      </label>
    </div>
  </div>
  <div class="flex">
    <div class="field">
    <textarea name="message_field" id="message_field" placeholder="Tutaj wpisz treść swojej wiadomości..." rows="7" maxlength="1000" spellcheck="true"></textarea>
      <label class="icon" for="message_field">
        <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
      </label>
    </div>
  </div>
  <div class="flex">
    <div class="field">
      <div class="g-recaptcha" data-sitekey="6LfnGigTAAAAAGsECHWJRKpajpJI0SYt24XFy8S-"></div>
    </div>
    <div class="field" style="text-align: right;"><div style="display: inline-block; position: relative;">
    <input id="submit_button" type="submit" value="Wyślij">
      <label class="icon" for="submit_button" style="cursor: pointer;">
        <i class="fa fa-paper-plane fa-fw" aria-hidden="true"></i>
      </label>
    </div></div>
  </div>
</form>



</body>
</html>
