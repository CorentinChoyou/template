<?php
include( "inc/include.php" );
//print_r($_REQUEST);
//print_r($_SESSION);

$session_key_name = ( isset( $_SESSION[ "session_key_name" ] ) && trim( $_SESSION[ "session_key_name" ] ) != "" ) ? trim( $_SESSION[ "session_key_name" ] ) : "";
//echo "session_key_name => ".$session_key_name.",";

$function = ( isset( $_REQUEST[ 'function' ] ) && trim( $_REQUEST[ 'function' ] ) != "" ) ? htmlentities( strip_tags( $_REQUEST[ 'function' ] ), ENT_QUOTES, "UTF-8" ) : "";

$file = ( isset( $_REQUEST[ 'file' ] ) && trim( $_REQUEST[ 'file' ] ) != "" ) ? htmlentities( strip_tags( $_REQUEST[ 'file' ] ), ENT_QUOTES, "UTF-8" ) : "chat.txt";

//$file = PROJECT_BASE_ROOT_PATH . "data/chat/" . $file;
$file = PROJECT_BASE_ROOT_PATH . "data/" . DATA_SERVER_NAME . "/chat/" . $file;

$state = ( isset( $_REQUEST[ 'state' ] ) && trim( $_REQUEST[ 'state' ] ) != "" ) ? htmlentities( strip_tags( $_REQUEST[ 'state' ] ), ENT_QUOTES, "UTF-8" ) : "";

$link = ( isset( $_REQUEST[ 'link' ] ) && trim( $_REQUEST[ 'link' ] ) != "" ) ? trim( $_REQUEST[ 'link' ] ) : "";

$lines = array();
$log = array();

switch ( $function ) {
  case ( "check_is_user_connected" ):
    //$nickname = ( isset( $_SESSION[ "nickname" ] ) && trim( $_SESSION[ "nickname" ] ) != "" ) ? trim( $_SESSION[ "nickname" ] ) : "";
    $nickname = ( isset( $_SESSION[ $session_key_name ][ "nickname" ] ) && trim( $_SESSION[ $session_key_name ][ "nickname" ] ) != "" ) ? trim( $_SESSION[ $session_key_name ][ "nickname" ] ) : "";

    $log[ 'status' ] = ( trim( $nickname ) != "" ) ? TRUE : FALSE;
    break;

  case ( "connectUser" ):
    //$log = array();    
    //$log = CheckEventAttendeeExists($_REQUEST);
    $log = CheckEventAttendeeExistsAndUpdateAttendeeStatus( $_REQUEST );
    break;

  case ( "signup_linkedin" ):
    $log = SaveLinkedInUserToEMS();
    break;

  case ( "join_linkedin_group" ):
    $log = JoinLinkedInGroup();
    break;

  case ( "logout" ):
    $log[ 'status' ] = logout();
    break;

  case ( "downloads" ):
    $log = downloadManagement( $link );
    break;

  case ( "record_utm_log" ):
    $log = record_utm_log();
    break;

  case ( 'getState' ):
    if ( !file_exists( $file ) ) {
      @mkdir( dirname( $file ), 0777, true );
      $handle = fopen( $file, 'w' )or die( 'Cannot open file:  ' . $file ); //implicitly creates file   
    } else {
      $lines = file( $file );
      //print_r($lines);
    }

    $log[ 'state' ] = count( $lines );
    break;

  case ( 'update' ):
    //$state = $_REQUEST[ 'state' ];
    if ( !file_exists( $file ) ) {
      @mkdir( dirname( $file ), 0777, true );
      $handle = fopen( $file, 'w' )or die( 'Cannot open file:  ' . $file ); //implicitly creates file   
    } else {
      $lines = file( $file );
      //print_r($lines);
    }

    $count = count( $lines );
    if ( $state == $count ) {
      $log[ 'state' ] = $state;
      $log[ 'text' ] = false;
    } else {
      $text = array();
      $log[ 'state' ] = $state + count( $lines ) - $state;
      foreach ( $lines as $line_num => $line ) {
        if ( $line_num >= $state ) {
          $text[] = $line = str_replace( "\n", "", $line );
        }
      }
      $log[ 'text' ] = $text;
    }
    break;

  case ( 'firstTimeLoadChat' ):
    if ( !file_exists( $file ) ) {
      @mkdir( dirname( $file ), 0777, true );
      $handle = fopen( $file, 'w' )or die( 'Cannot open file:  ' . $file ); //implicitly creates file   
    } else {
      $lines = file( $file );
      //print_r($lines);
    }

    $log[ 'state' ] = $state;
    $log[ 'text' ] = false;

    $count = count( $lines );
    if ( $count > 0 ) {
      $text = array();
      foreach ( $lines as $line_num => $line ) {
        $text[] = $line = str_replace( "\n", "", $line );
      }
      $log[ 'text' ] = $text;
    }

    break;

  case ( 'send' ):
    $nickname = htmlentities( strip_tags( $_REQUEST[ 'nickname' ] ), ENT_QUOTES, "UTF-8" );

    $patterns = array( "/:\)/", "/:D/", "/:p/", "/:P/", "/:\(/" );
    $replacements = array( "<img src='" . SITE_URL . "assets/images/smiles/smile.gif'/>", "<img src='" . SITE_URL . "assets/images/smiles/bigsmile.png'/>", "<img src='" . SITE_URL . "assets/images/smiles/tongue.png'/>", "<img src='" . SITE_URL . "assets/images/smiles/tongue.png'/>", "<img src='" . SITE_URL . "assets/images/smiles/sad.png'/>" );
    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
    $blankexp = "/^\n/";

    $message = htmlentities( strip_tags( $_REQUEST[ 'message' ] ), ENT_QUOTES, "UTF-8" );

    if ( !preg_match( $blankexp, $message ) ) {

      if ( preg_match( $reg_exUrl, $message, $url ) ) {
        $message = preg_replace( $reg_exUrl, '<a href="' . $url[ 0 ] . '" target="_blank">' . $url[ 0 ] . '</a>', $message );
      }
      $message = preg_replace( $patterns, $replacements, $message );
      $message = str_replace( "\n", " ", $message );

      $str = "";

      //$str .= '<p class="username-message">' . $nickname . '</p>';
      //$str .= '<p class="text-message">' . $message . '</p>';

      $str .= '<div class="username-message clearfix">';
      $str .= '<span class="direct-chat-name float-left">' . $nickname . '</span>';
      $str .= '<span class="direct-chat-timestamp float-right">' . date( "d/m/Y, h:i A" ) . '</span></div>';
      $str .= '<div class="text-message">' . $message . '</div>';

      if ( !file_exists( $file ) ) {
        mkdir( dirname( $file ), 0777, true );
        $handle = fopen( $file, 'w' )or die( 'Cannot open file:  ' . $file ); //implicitly creates file 
      }

      fwrite( fopen( $file, 'a' ), $str . "\n" );
    }
    break;

  default:
    break;
}

echo json_encode( $log );

?>