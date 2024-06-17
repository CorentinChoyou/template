<nav id="navbar">
    <div class="nav_container">
        <a href="<?php echo SITE_URL; ?>" rel="home" class="logo">
            <img src="https://choyou.fr/logo/google.png" alt="logo" data-size="medium">
        </a>

        <button class="navbar_toggler">
            <span></span>
        </button>

        <ul id="nav_content">
            <li><a href="<?php echo SITE_URL; ?>#theme">Theme</a></li>
            <li><a href="<?php echo SITE_URL; ?>#agenda">Agenda</a></li>
            <li><a href="<?php echo SITE_URL; ?>#partners">Partenaires</a></li>
            <li><a href="<?php echo SITE_URL; ?>#intervenants">Intervenants</a></li>
            <li><a href="<?php echo SITE_URL; ?>#lieu">Lieu</a></li>

            <?php if ( $is_logged_in_status ) {?>
            <li>
                <a class="logout" id="nav_login"><?php echo $attendee_name; ?><i class="fas fa-sign-out-alt"></i></a>
            </li>
            <?php } else{ ?>
                <li><a href="registration.php" id="nav_login">Connexion</a></li>
            <?php } ?>
            <span class="background"></span>
        </ul>

    </div>
</nav>