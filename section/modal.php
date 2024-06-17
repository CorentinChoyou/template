<?php if( isset( $is_logged_in_status ) && !$is_logged_in_status ){ ?>
<!-- Modal HTML Markup -->
<div id="ModalLoginForm" class="modal fade" data-easein="fadeIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-focus-on="input:first">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-xs-center" style="font-size: 1.25rem;"><?php echo ($curent_timestamp > $event_ends_on_timestamp ) ? "Accédez au replay en indiquant l'email utilisé lors de votre inscription !" : "Rejoignez le live en indiquant l'email utilisé lors de votre inscription !"; ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form name="frm_login" id="frm_login" role="form" method="POST" action="">
                    <input type="hidden" name="ems_secret_code" value="<?php echo ems_secret_code;?>" />
                    <div class="form-group">
                        <label style="font-size:1.2rem;" class="control-label">Vous êtes déjà enregistré :</label>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Veuillez entrer votre adresse email
                            <div class="small notes">&nbsp;(L'adresse email doit être la même que celle de votre inscription)</div>
                        </label>
                        <div>
                            <input type="email" name="email" value="" class="form-control input-lg" placeholder="Votre email*" required />
                        </div>
                        <p class="small notes"><span style="color:#ff0000; font-weight:bold;">*</span> Champ obligatoire.</p>
                    </div>
                    <div class="form-group">
                        <div>
                            <button type="submit" class="btn btn-info btn-block">Connexion <span class="fas fa-sign-in-alt"></span></button>
                        </div>
                    </div>
                </form>
                <!---->
                <hr />
                <!---->
                <div class="formulaire">
                    <form id="form_registration_modal" name="form_registration_modal" action="" method="POST" novalidate class="needs-validation" accept-charset="UTF-8">
                        <input type="hidden" name="exp_fname" value="<?php echo exp_fname; ?>" />
                        <input type="hidden" name="ems_secret_code" value="<?php echo ems_secret_code;?>" />
                        <input type="hidden" name="register_via" value="registration_modal_form" />
                        <input type="hidden" name="status_id" value="<?php echo ems_status_id; ?>" />
                        <input type="hidden" name="curl_post" value="1" />
                        <!-- send_confirmation_email -->
                        <input type="hidden" name="send_confirmation_email" value="1" />
                        <input type="hidden" name="email_from" value="noreply@it4b.fr" />
                        <input type="hidden" name="email_from_name" value="Emission Veeam et Pure Storage" />
                        <input type="hidden" name="email_subject" value="Merci pour votre inscription à l'évènement de Veeam" />
                        <input type="hidden" name="email_content_link" value="<?php echo SITE_URL ; ?>emailing/approved.html" />
                        <!-- EO send_confirmation_email -->
                        <div class="registration-content">
                            <div class="form-group">
                                <label style="font-size:1.2rem;" class="control-label">Vous n'êtes pas enregistré ?</label>
                            </div>
                            <div class="form-group">
                                <input name="first_name" class="form-control form-control-sm" type="text" placeholder="Pr&#233;nom*" required pattern=".*\S+.*" />
                            </div>
                            <div class="form-group">
                                <input name="last_name" class="form-control form-control-sm" type="text" placeholder="Nom*" required pattern=".*\S+.*" />
                            </div>
                            <div class="form-group">
                                <input name="email" class="form-control form-control-sm" type="email" placeholder="Email*" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <input type="tel" name="phone" id="phone" title="Contact No.*" value="" class="form-control form-control-sm intl_tel_input" placeholder="" autocomplete="nope" pattern=".*\S+.*" required />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <input class="form-control form-control-sm" type="text" placeholder="Poste*" name="designation" required pattern=".*\S+.*" />
                                    <div class="valid-feedback"></div>
                                </div>
                                <div class="col">
                                    <input class="form-control form-control-sm" type="text" placeholder="Entreprise*" name="organization" required pattern=".*\S+.*" />
                                    <div class="valid-feedback"></div>
                                    <!-- <div class="invalid-feedback"> Champ obligatoire </div>   -->
                                </div>
                            </div>
                            <div class="form-group" id="connexion">
                                <button type="submit" class="btn btn-info btn-block" title="En compl&#233;tant ce formulaire, vous acceptez que vos coordonn&#233;es soient transmises &#224; <?php echo website_owner; ?>, et vous autorisez un repr&#233;sentant de <?php echo website_owner; ?> &#224; vous contacter (par t&#233;l&#233;phone or email) par rapport &#224; cet &#233;v&#233;nement. En participant &#224; cet &#233;v&#233;nement, vous autorisez <?php echo website_owner; ?> à fixer, reproduire et communiquer leurs m&#233;dias, leurs photographies ou vid&#233;os prises dans le cadre de cet &#233;v&#233;nement.">S&#39;inscrire <span class="fas fa-chevron-right"></span></button>
                            </div>
                            <p class="note-form small mt-4"><a href="https://www.itforbusiness.fr/politique-de-confidentialite" target="_blank">Déclaration de confidentialité d'IT for Business</a></p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer text-xs-center"></div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php } ?>
