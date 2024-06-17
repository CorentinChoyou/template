<?php
include( "inc/include.php" );
include( "inc/indexSettings.php" );
?>
<!DOCTYPE html>
<html lang="fr">

<?php include("section/head.php"); ?>
    <body>
        <?php include("section/header.php"); ?>
        <main>
            <!-------------------- theme ------------------>
            <?php include("section/theme.php"); ?>
            <!-------------------- AGENDA ------------------>
            <?php include("section/agenda.php"); ?>
            <!-------------------- PARTENAIRES ------------------>
            <?php include("section/partenaires.php"); ?>
            <!-------------------- INTERVENANT ------------------>
            <?php include("section/intervenants.php"); ?>
            <!-------------------- LIEU ------------------>
            <?php include("section/lieu.php"); ?>
            <!-------------------- ADMIN ------------------>
            <!--?php include("section/admin.php"); ?-->
        </main>
        <?php include("section/footer.php"); ?>
        <script src="<?php echo SITE_URL; ?>assets/js/custom.js?v=3"></script>
        <?php include_once("section/script.php"); ?>
        <button id="backToTop"><i class="fa-solid fa-chevron-up"></i></button>
    </body>
</html>