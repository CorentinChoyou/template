<?php
include( "inc/include.php" );
include( "inc/indexSettings.php" );
if ($is_logged_in_status) {
    header("Location: " . SITE_URL . "live.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<?php include("section/head.php"); ?>

    <body id="registration">
        <?php include( "section/nav.php" ); ?>
        <div style="height:40px"></div>
       

        <section id="registration_section">
            <div id="ModalLoginForm" class="connect">
                    
                <h2>Connexion</h2>
                    
                <form name="frm_login" id="frm_login" role="form" method="POST" action="">
                    <input type="hidden" name="ems_secret_code" value="<?php echo ems_secret_code;?>" />
                    <input type="hidden" name="redirection" id="redirection" value="https://choyou.fr/_/cloudflare/2023/madrid/thank-you.html">
                    <div class="form-group">
                        <div>
                            <label for="email">Accédez au <?php echo ($curent_timestamp > $event_ends_on_timestamp ) ? "replay" : "live" ; ?> en indiquant l’e-mail utilisé lors de votre inscription !</label>
                            <input type="email" placeholder="Email professionnel*" name="email" value="" required />
                        </div>
                    </div>
                    <div>
                        <div>
                            <button type="submit">Connexion</button>
                        </div>
                    </div>
                </form>
            </div>
            <hr>
            <div class="register">
                <h2>S'inscrire</h2>

                <?php include( "section/form.php" ); ?>
            </div>
        </section>

        <?php include("section/footer.php"); ?>
        <script src="<?php echo SITE_URL; ?>assets/js/custom.js?v=3"></script>
        <?php include_once("section/script.php"); ?>
        <button id="backToTop"><i class="fa-solid fa-chevron-up"></i></button>
    </body>

</html>