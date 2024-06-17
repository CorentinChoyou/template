<?php
@date_default_timezone_set( "Europe/Paris" );

$config = json_decode(file_get_contents('config.json'), true);

if ( !function_exists( 'is_server' ) ) {
  function is_server( $s ) {
    $server = strtolower( $_SERVER[ 'HTTP_HOST' ] );
    if ( strpos( $server, $s ) === false )
      return false;
    else
      return true;
  }
}

// display errors
if ( is_server( "localhost" ) || is_server( "choyou.fr" ) || is_server( "www.choyou.fr" ) ) {
  @ini_set( 'error_reporting', E_ALL );
  @ini_set( 'display_errors', 1 ); // display errors
} else {
  @ini_set( 'error_reporting', E_ALL );
  @ini_set( 'display_errors', 1 ); // display errors
}

if ( !session_id() ) {
  @session_start();
  // Generating a CSRF Token
  if ( empty( $_SESSION[ 'token' ] ) ) {
    $_SESSION[ 'token' ] = bin2hex( random_bytes( 32 ) );
  }

  //============== New changes ===============// 

  $project_name = ( is_server( "localhost" ) || is_server( "choyou.fr" ) || is_server( "www.choyou.fr" ) ) ? $config['exp_fname'] : "";

  // session_key
  $session_key_name = str_replace( ".", "_", $_SERVER[ 'SERVER_NAME' ] );
  $session_key_name .= ( isset( $project_name ) && trim( $project_name ) != "" ) ? "_" . $project_name : "";
  //echo "<pre>session_key_name => " . $session_key_name . "<pre>";

  if ( !isset( $_SESSION[ "session_key_name" ] ) ) {
    $_SESSION[ "session_key_name" ] = $session_key_name;
  }

  $session_key_name = ( isset( $_SESSION[ "session_key_name" ] ) && trim( $_SESSION[ "session_key_name" ] ) != "" ) ? trim( $_SESSION[ "session_key_name" ] ) : "";

  if ( !isset( $_SESSION[ $session_key_name ] ) ) {
    $_SESSION[ $session_key_name ] = array();
  }
  //============== End of New changes ===============//
}


if ( !empty( $_SERVER[ 'HTTPS' ] ) && ( 'on' == $_SERVER[ 'HTTPS' ] ) ) {
  $uri = "https://";
} else {
  $uri = "http://";
}

//print_r($_SERVER);
//die($_SERVER[ 'HTTP_HOST' ]);

$server_name = str_replace( array( ".", "-" ), "_", strtolower( str_replace( array( "www." ), "", $_SERVER[ 'SERVER_NAME' ] ) ) );
//echo "<pre>server_name => " . $server_name . "</pre>";
define( "DATA_SERVER_NAME", $server_name );

$BASE_ROOT_PATH = "";
if ( is_server( "localhost" ) ) {
  $BASE_ROOT_PATH = $_SERVER[ 'DOCUMENT_ROOT' ] . "/choyou.fr/";
  define( "PROJECT_FOLDER", $config['page_url'] );
  define( "PROJECT_BASE_ROOT_PATH", $BASE_ROOT_PATH . PROJECT_FOLDER );
  define( "CHOYOU_SITE_URL", $uri . $_SERVER[ 'HTTP_HOST' ] . "/choyou.fr/" );
  define( "SITE_URL", $uri . $_SERVER[ 'HTTP_HOST' ] . "/choyou.fr/" . PROJECT_FOLDER );
}
elseif ( is_server( "choyou.fr" ) || is_server( "www.choyou.fr" ) ) {
  $BASE_ROOT_PATH = "C:/wamp64/www/web/";
  define( "PROJECT_FOLDER", $config['page_url'] );
  define( "PROJECT_BASE_ROOT_PATH", $BASE_ROOT_PATH . PROJECT_FOLDER );
  define( "CHOYOU_SITE_URL", $uri . $_SERVER[ 'HTTP_HOST' ] . "/" );
  define( "SITE_URL", $uri . $_SERVER[ 'HTTP_HOST' ] . "/" . PROJECT_FOLDER );
}
elseif ( is_server( "itforbusinessleclub.fr" ) || is_server( "www.itforbusinessleclub.fr" ) ) {
  $BASE_ROOT_PATH = "C:/wamp64/www/web/";
  define( "PROJECT_FOLDER", $config['page_url'] );
  define( "PROJECT_BASE_ROOT_PATH", $BASE_ROOT_PATH . PROJECT_FOLDER );
  define( "CHOYOU_SITE_URL", "https://www.choyou.fr/" );
  define( "SITE_URL", $uri . $_SERVER[ 'HTTP_HOST' ] . "/sinequa/" );
}
else {
  die( "Invalid HOST!" );
}
//echo $BASE_ROOT_PATH;
//echo PROJECT_BASE_ROOT_PATH;
//echo CHOYOU_SITE_URL;
//echo SITE_URL;

// ems_secret_code
if ( !defined( "ems_secret_code" ) ) {
  define( "ems_secret_code", $config['ems_code'] );
}

if ( !defined( "exp_fname" ) ) {
  define( "exp_fname", $config['exp_fname'] );
}
if ( !defined( "encrypted_exp_fname" ) ) {
  define( "encrypted_exp_fname", $config['encrypted_exp_fname'] );
}

//Note: 
//1.	EMS status_id == 1 means is awaiting approval (manual approval in ems), 
//2.	EMS status_id == 2 means auto approval in EMS

if ( !defined( "ems_status_id" ) ) {
  define( "ems_status_id", "1" );
}

//LINKEDIN
define( "CLIENT_ID", "81ifmcbd9yxijb" );
define( "CLIENT_SECRET", "gBjFGy1acx5wjBgA" );
define( "SCOPE", "r_liteprofile r_emailaddress" ); //v2
define( "REDIRECT_URI", SITE_URL . "index.php" );


// Attendee Details
$session_key_name = ( isset( $_SESSION[ "session_key_name" ] ) && trim( $_SESSION[ "session_key_name" ] ) != "" ) ? trim( $_SESSION[ "session_key_name" ] ) : "";

// Attendee Details
$attendee_name = ( isset( $_SESSION[ $session_key_name ][ "attendee_name" ] ) && trim( $_SESSION[ $session_key_name ][ "attendee_name" ] ) != "" ) ? trim( $_SESSION[ $session_key_name ][ "attendee_name" ] ) : "";

$attendee_email = ( isset( $_SESSION[ $session_key_name ][ "email" ] ) && trim( $_SESSION[ $session_key_name ][ "email" ] ) != "" ) ? trim( $_SESSION[ $session_key_name ][ "email" ] ) : "";

$nickname = ( isset( $_SESSION[ $session_key_name ][ "nickname" ] ) && trim( $_SESSION[ $session_key_name ][ "nickname" ] ) != "" ) ? trim( $_SESSION[ $session_key_name ][ "nickname" ] ) : "";

$is_logged_in_status = ( trim( $nickname ) != "" ) ? true : false;

if ( !defined( "attendee_name" ) ) {
  define( "attendee_name", $attendee_name );
}
if ( !defined( "attendee_email" ) ) {
  define( "attendee_email", $attendee_email );
}
if ( !defined( "nickname" ) ) {
  define( "nickname", $nickname );
}
if ( !defined( "is_logged_in_status" ) ) {
  define( "is_logged_in_status", $is_logged_in_status );
}

if ( !defined( "CHOYOU_SAVE_POST_FILENAME" ) ) {
  define( "CHOYOU_SAVE_POST_FILENAME", "file/file.php" );
}

if ( !defined( "website_owner" ) ) {
  define( "website_owner", "Sinequa" );
}

// event date time details
$event_date_str = $config['event_date_start'];
$event_starts_on_timestamp = strtotime( $event_date_str );
// end of event date time details

if ( !defined( "EVENT_DATE_STR" ) ) {
  define( "EVENT_DATE_STR", $event_date_str );
}

if ( !defined( "EVENT_STARTS_ON_TIMESTAMP" ) ) {
  define( "EVENT_STARTS_ON_TIMESTAMP", $event_starts_on_timestamp );
}

require( PROJECT_BASE_ROOT_PATH . "inc/functions.php" );
