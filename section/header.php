<!-------------------- HEADER ------------------>
<header>



    <?php include("section/nav.php"); ?>


    <div id="header_container">
        <div class="header_content">
            <h1><?php echo $config['event_title'] ?></h1>
            <h3><?php echo ( isset( $event_date_str_in_fr ) && !empty( $event_date_str_in_fr ) ) ? trim( $event_date_str_in_fr ) : ""; ?>,
                en ligne à partir de <?php echo $config['event_hour_start']; ?></h3>
            <?php include("section/countdown_timer.php"); ?>

            <?php echo ($curent_timestamp > $event_ends_on_timestamp ) ? "<h4>Connectez-vous pour accéder au replay (inscription préalable obligatoire) !</h4>" : "" ; ?>
            <h4><a href="live.php"><svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34"
                        fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M17 1C25.8352 1 33 8.1632 33 17C33 25.8368 25.8352 33 17 33C8.1632 33 1 25.8368 1 17C1 8.1632 8.1632 1 17 1Z"
                            stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M22.0529 16.9918C22.0529 15.6257 15.0508 11.2553 14.2565 12.0412C13.4622 12.827 13.3859 21.0826 14.2565 21.9425C15.1272 22.8054 22.0529 18.3579 22.0529 16.9918Z"
                            stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg> Suivez votre émission en ligne</a></h4>
        </div>
    </div>
</header>
<!-------------------- END OF HEADER ------------------>