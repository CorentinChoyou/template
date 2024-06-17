<?php

// record visitor
record_visitor_log();

$login_required = false;
$curent_timestamp = time();

//================= EVENT DETAILS INITIALIZATION =================//

$event_date_str = $config['event_date_start'];
$event_title = $config['event_title'];
$event_description = "";
$video_link = "______";

//================= END OF EVENT DETAILS INITIALIZATION =================//

$event_starts_on_date = date( "Y-m-d", strtotime( $event_date_str ) );
$event_starts_on_timestamp = strtotime( $event_date_str );
$event_starts_on = date( "Y-m-d H:i:s", $event_starts_on_timestamp );

//================= EVENT ENDS ON DETAILS =================//
$event_end_date_str = $config['event_date_end'];
$event_ends_on_date = date( "Y-m-d", strtotime( $event_end_date_str ) );
$event_ends_on_timestamp = strtotime( $event_end_date_str );
$event_ends_on = date( "Y-m-d H:i:s", $event_starts_on_timestamp );
//================= END OF EVENT ENDS ON DETAILS =================//

//================= EVENT DATE DETAILS IN ENGLISH =================//
$event_date_str_in_en = date( "l, j F Y", $event_starts_on_timestamp );
$event_time_str_in_en = date( "h:i A", $event_starts_on_timestamp );
//================= END OF EVENT DATE DETAILS IN ENGLISH =================//

//================= EVENT DATE DETAILS IN FRENCH =================//
$event_date_str_in_fr = ucfirst( dateToFrench( $event_date_str, "l j F Y" ) );
$event_time_str_in_fr = ( date( "i", strtotime( $event_date_str ) ) > 0 ) ? date( "G\hi", strtotime( $event_date_str ) ) : date( "G\h", strtotime( $event_date_str ) );

//================= END OF EVENT DATE DETAILS IN FRENCH =================//
$videoSession = ( ( isset( $is_logged_in_status ) && $is_logged_in_status ) && ( isset( $video_link ) && !empty( $video_link ) ) && ( $curent_timestamp >= $event_starts_on_timestamp ) ) ? true : false; // LIVE

?>