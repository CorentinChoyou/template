<form id="form_registration" name="form_registration" action="" method="POST" novalidate class="needs-validation" accept-charset="UTF-8">
    <input type="hidden" name="exp_fname" value="<?php echo exp_fname; ?>" />
    <input type="hidden" name="ems_secret_code" value="<?php echo ems_secret_code;?>" />
    <input type="hidden" name="register_via" value="registration_form" />
    <input type="hidden" name="status_id" value="<?php echo ems_status_id; ?>" />
    <input type="hidden" name="curl_post" value="1" />
    <!-- send_confirmation_email -->
    <input type="hidden" name="send_confirmation_email" value="1" />
    <input type="hidden" name="email_from" value="noreply@it4b.fr" />
    <input type="hidden" name="email_from_name" value="Sinequa" />
    <input type="hidden" name="email_subject" value="Merci pour votre inscription à l'évènement Sinequa" />
    <input type="hidden" name="email_content_link" value="<?php echo SITE_URL ; ?>emailing/confirmation.html" />
    <!-- EO send_confirmation_email -->
    <div class="registration-content">

        <div class="double">
            <input name="first_name" type="text" placeholder="Prénom*" required pattern=".*\S+.*" />
            <div class="valid-feedback"></div>
        
            <input name="last_name" type="text" placeholder="Nom*" required pattern=".*\S+.*" />
            <div class="valid-feedback"></div>
        </div>
        
        <input name="email" id="email" type="email" placeholder="Email professionnel" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required autocomplete="email" />

        <div class="invalid-feedback"></div>
    
        <input name="phone" type="tel" id="phone" title="Contact No.*" value="" class="intl_tel_input" placeholder="" pattern=".*\S+.*" required />
        <div class="invalid-feedback"></div>

        <div class="double">
            <input type="text" placeholder="Poste*" name="designation" required pattern=".*\S+.*" />
            <div class="valid-feedback"></div>
            
            <input type="text" placeholder="Entreprise*" name="organization" required pattern=".*\S+.*" />
            <div class="valid-feedback"></div>
        </div>

        <!-- <select name="comment">
            <option value="" selected="selected">Comment souhaitez vous participer ?*</option>
            <option value="sur place">Sur place</option>
            <option value="en ligne">En ligne</option>
        </select> -->

        <a href="https://www.itforbusiness.fr/politique-de-confidentialite" target="_blank">Déclaration de confidentialité</a>

        <div id="connexion">
            <button type="submit" title="En complétant ce formulaire, vous acceptez que vos coordonnées soient transmises &#224; <?php echo website_owner; ?>, et vous autorisez un représentant de <?php echo website_owner; ?> &#224; vous contacter (par téléphone or email) par rapport &#224; cet événement. En participant &#224; cet événement, vous autorisez <?php echo website_owner; ?> à fixer, reproduire et communiquer leurs médias, leurs photographies ou vidéos prises dans le cadre de cet événement.">S'inscrire</button>
        </div>
    </div>
</form>