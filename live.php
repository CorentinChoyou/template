<?php
include( "inc/include.php" );
include( "inc/indexSettings.php" );

if (!$is_logged_in_status) {
    header("Location: " . SITE_URL . "registration.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<?php include("section/head.php"); ?>

    <header>
        <?php include("section/nav.php"); ?>
    </header>

    <body>
        
        <div id="videoBoard">
            <div id="mainVideo" class="main-video">
                <div>
                    <h2><?php echo ($curent_timestamp <= $event_starts_on_timestamp ) ? "Commence dans" : "Visionnez votre émission en replay ici"; ?>
                    </h2>
                    <?php if ( isset( $videoSession ) && $videoSession ) {?>
                    <iframe id="videoLive" src="<?php echo $video_link; ?>?rel=0&autoplay=1" frameborder="0"
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture; fullscreen"
                        allowfullscreen></iframe>
                    <?php } ?>
                    <?php include("section/countdown_timer.php"); ?>

                </div>
            </div>

            <!-- col8 -->
            <!-- <div class="container-chat">
                            <div id="chat">
                                </?php if ( $nickname == "" ) {?>
                                </?php include_once("section/form.php"); ?>
                                </?php include("section/thankyou.php"); ?>
                                </?php } else { ?>
                                </?php include("section/livechat.php"); ?>
                                </?php } ?>
                            </div>
                        </div> -->
        </div>
        <script src="<?php echo SITE_URL; ?>assets/js/custom.js?v=3"></script>
        <?php include_once("section/script.php"); ?>
        <button id="backToTop"><i class="fa-solid fa-chevron-up"></i></button>
    </body>

</html>
