<?php
// Function to get the client ip address
if ( !function_exists( 'get_client_ip_server' ) ) {
	function get_client_ip_server() {
		$ipaddress = '';
		if ( array_key_exists( 'HTTP_CLIENT_IP', $_SERVER ) )
			$ipaddress = $_SERVER[ 'HTTP_CLIENT_IP' ];
		else if ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $_SERVER ) )
			$ipaddress = $_SERVER[ 'HTTP_X_FORWARDED_FOR' ];
		else if ( array_key_exists( 'HTTP_X_FORWARDED', $_SERVER ) )
			$ipaddress = $_SERVER[ 'HTTP_X_FORWARDED' ];
		else if ( array_key_exists( 'HTTP_FORWARDED_FOR', $_SERVER ) )
			$ipaddress = $_SERVER[ 'HTTP_FORWARDED_FOR' ];
		else if ( array_key_exists( 'HTTP_FORWARDED', $_SERVER ) )
			$ipaddress = $_SERVER[ 'HTTP_FORWARDED' ];
		else if ( array_key_exists( 'REMOTE_ADDR', $_SERVER ) )
			$ipaddress = $_SERVER[ 'REMOTE_ADDR' ];
		else
			$ipaddress = 'UNKNOWN';

		return $ipaddress;
	}
}

if ( !function_exists( 'is_base64' ) ) {
	function is_base64( $str ) {
		return ( base64_encode( base64_decode( $str, true ) ) === $str ) ? true : false;
	}
}

/**
 * Multi-array search
 *
 * @param array $array
 * @param array $search
 * @return array
 */
if ( !function_exists( 'multi_array_search' ) ) {
	function multi_array_search( $array, $search ) {

		// Create the result array
		$result = array();

		// Iterate over each array element
		foreach ( $array as $key => $value ) {
			// Iterate over each search condition
			foreach ( $search as $k => $v ) {
				// If the array element does not meet the search condition then continue to the next element
				if ( !isset( $value[ $k ] ) || $value[ $k ] != $v ) {
					continue 2;
				}
			}

			// Add the array element's key to the result array
			$result[] = $key;
		}

		// Return the result array
		return $result;

	}
}
// Output the result
/* print_r(multi_array_search($list_of_phones, array()));

 // Array ( [0] => 0 [1] => 1 )

 // Output the result
 print_r(multi_array_search($list_of_phones, array('Manufacturer' => 'Apple')));

 // Array ( [0] => 0 )

 // Output the result
 print_r(multi_array_search($list_of_phones, array('Manufacturer' => 'Apple', 'Model' => 'iPhone 6')));*/

if ( !function_exists( 'getRandomUserAgent' ) ) {
	function getRandomUserAgent() {
		$userAgents = array(
			"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6",
			"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
			"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)",
			"Opera/9.20 (Windows NT 6.0; U; en)",
			"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; en) Opera 8.50",
			"Mozilla/4.0 (compatible; MSIE 6.0; MSIE 5.5; Windows NT 5.1) Opera 7.02 [en]",
			"Mozilla/5.0 (Macintosh; U; PPC Mac OS X Mach-O; fr; rv:1.7) Gecko/20040624 Firefox/0.9",
			"Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/48 (like Gecko) Safari/48"
		);
		$random = rand( 0, count( $userAgents ) - 1 );

		return $userAgents[ $random ];
	}
}

if ( !function_exists( 'post_curl' ) ) {
	function post_curl( $url, $param = "" ) {
		//echo "<pre>url = ".$url."</pre>";
		//echo "<pre>param = ".$param."</pre>";

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		if ( $param != "" ) {
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $param );
		}
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
		$result = curl_exec( $ch );
		$err = curl_error( $ch );
		curl_close( $ch );

		if ( $err ) {
			echo "cURL Error #:" . $err;
		}

		//var_dump($result);
		return $result;
	}
}

if ( !function_exists( 'post_curl2' ) ) {
	function post_curl2( $url, $param = "" ) {
		//echo "<pre>url = ".$url."</pre>";
		//echo "<pre>param = ".$param."</pre>";

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		if ( $param != "" ) {
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $param );
		}
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
		curl_setopt( $ch, CURLOPT_POST, TRUE );
		curl_setopt( $ch, CURLOPT_USERAGENT, getRandomUserAgent() );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, FALSE );
		curl_setopt( $ch, CURLOPT_HEADER, FALSE ); // DO NOT RETURN HTTP HEADERS
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );

		$result = curl_exec( $ch );
		$err = curl_error( $ch );
		curl_close( $ch );

		if ( $err ) {
			echo "cURL Error #:" . $err;
		}

		//var_dump($result);
		return $result;
	}
}

if ( !function_exists( 'CheckEventAttendeeExistsAndUpdateAttendeeStatus' ) ) {
	function CheckEventAttendeeExistsAndUpdateAttendeeStatus( $array = array() ) {
		$array = ( is_array( $array ) && sizeof( $array ) > 0 ) ? $array : $_REQUEST;
		//print_r($array);

		//$html = "Please register to watch the broadcast & join live chat.";
		//$return = array( "status" => FALSE, "title" => "Encountered an error!", "type_class" => "red", "html" => $html ); 

		$html = "Veuillez vous inscrire pour regarder la diffusion et rejoindre le chat en direct.";
		$return = array( "status" => FALSE, "title" => "Vous avez rencontré une erreur!", "type_class" => "red", "html" => $html );

		$session_key_name = ( isset( $_SESSION[ "session_key_name" ] ) && trim( $_SESSION[ "session_key_name" ] ) != "" ) ? trim( $_SESSION[ "session_key_name" ] ) : "";

		if ( isset( $_SESSION[ $session_key_name ][ "nickname" ] ) && trim( $_SESSION[ $session_key_name ][ "nickname" ] ) != "" ) {
			$return = array( "status" => TRUE, "title" => "Message", "type_class" => "green", "html" => "You are already logged in.", "attendee_status_approved" => TRUE );
			return $return;
		}

		if ( is_array( $array ) && sizeof( $array ) > 0 ) {
			$fields = array();
			foreach ( $array as $key => $value ) {
				//echo "key: ".$key." => Value: ".$value."<br />";

				if ( in_array( strtolower( $key ), array( "ems_secret_code" ) ) ) {
					$fields[ "ems_secret_code" ] = trim( $value );
				}

				if ( in_array( strtolower( $key ), array( "email" ) ) ) {
					if ( trim( $value ) == "" ) {
						$return[ "html" ] = "Please provide an email address.";
						return $return;
					} elseif ( trim( $value ) != "" ) {
						if ( !filter_var( trim( $value ), FILTER_VALIDATE_EMAIL ) ) {
							$return[ "html" ] = "Invalid email format.";
							return $return;
						} else {
							$fields[ "email" ] = trim( $value );
						}
					}
				}
			}
			//print_r($fields); die();

			if ( is_array( $fields ) && sizeof( $fields ) > 0 ) {
				$data = array();
				$data = CheckEventAttendeeExistsAndUpdateAttendeeStatus_Curl( $fields );
				//print_r( $data ); die();

				if ( is_array( $data ) && sizeof( $data ) > 0 ) {
					//print_r( $data ); die();

					$status = ( array_key_exists( "status", $data ) ) ? $data[ "status" ] : FALSE;

					if ( $status ) {
						$attendee_details = ( array_key_exists( "attendee_details", $data ) ) ? $data[ "attendee_details" ] : array();
						//print_r( $attendee_details );die(); 

						// check status
						$status_id = ( array_key_exists( "status_id", $attendee_details ) ) ? $attendee_details[ "status_id" ] : "";
						$status_name = ( array_key_exists( "status_name", $attendee_details ) ) ? $attendee_details[ "status_name" ] : "";

						$attendee_id = ( array_key_exists( "id", $attendee_details ) ) ? strtolower( $attendee_details[ "id" ] ) : "0";
						$event_id = ( array_key_exists( "event_id", $attendee_details ) ) ? strtolower( $attendee_details[ "event_id" ] ) : "0";

						$first_name = ( array_key_exists( "first_name", $attendee_details ) ) ? strtolower( $attendee_details[ "first_name" ] ) : "";
						$email = ( array_key_exists( "email", $attendee_details ) ) ? strtolower( $attendee_details[ "email" ] ) : "";
						$attendee_name = ( array_key_exists( "attendee_name", $attendee_details ) ) ? ucwords( mb_strtolower( $attendee_details[ "attendee_name" ], "UTF-8" ) ) : "";
						$nickname = strtolower( str_replace( " ", "-", removeAccents( trim( $attendee_name ) ) ) );

						$return = array( "status" => TRUE, "title" => "Message", "attendee_status_approved" => FALSE );

						$html = "";

						if ( trim( $attendee_name ) != "" ) {
							$html .= "Bonjour " . $attendee_name . ",";
						}

						switch ( intval( $status_id ) ) {
							case 1:
								$type_class = "orange"; // awaiting approval
								//$html .= "<p>Your request to attend the event is currently awaiting approval.</p>";
								//$html .= "<p>Please keep an eye on your email - you will receive an update regarding your registration shortly.</p>";

								$html .= "<p>Votre demande pour assister à l'événement est actuellement en attente d'approbation.</p>";
								$html .= "<p>Veuillez garder un œil sur votre e-mail - vous recevrez sous peu une mise à jour concernant votre inscription.</p>";
								break;

							case 2:
								$return[ "attendee_status_approved" ] = TRUE;
								$type_class = "green"; // approved
								//$html .= "<p>Your request to attend the event is approved.</p>";
								//$html .= "<p>You have connected successfully.</p>";

								$html .= "<p>Vous vous êtes connecté avec succès.</p>";

								@session_regenerate_id( TRUE );

								//============ USER LOG DURING LOGIN ===============//    
								//$logfile = PROJECT_BASE_ROOT_PATH . "data/logs/user_log/user_log_" . date( "Ymd" ) . ".txt";

								$logfile = PROJECT_BASE_ROOT_PATH . "data/" . DATA_SERVER_NAME . "/logs/user_log/user_log_" . date( "Ymd" ) . ".txt";

								if ( !file_exists( $logfile ) ) {
									@mkdir( dirname( $logfile ), 0777, true );

									// Open the log file in "Append" mode
									$logline = "session_id | from_page_url | ipaddress | attendee_name | email | login_datetime | useragent | logout_datetime" . "\n";
									if ( !$handle = fopen( $logfile, "a+" ) ) {
										die( "Failed to open log file" );
									}

									// Write $logline to our logfile.
									if ( fwrite( $handle, $logline ) === FALSE ) {
										die( "Failed to write to log file" );
									}

									fclose( $handle );
								}

								$session_id = session_id();
								$from_page_url = ( isset( $_SERVER[ 'HTTP_REFERER' ] ) ) ? $_SERVER[ 'HTTP_REFERER' ] : "";
								$ipaddress = get_client_ip_server();
								$login_datetime = date( "Y-m-d H:i:s" );
								$useragent = ( isset( $_SERVER[ 'HTTP_USER_AGENT' ] ) ) ? $_SERVER[ 'HTTP_USER_AGENT' ] : "";

								$logline = $session_id . '|' . $from_page_url . '|' . $ipaddress . '|' . $attendee_name . '|' . $email . '|' . $login_datetime . '|' . $useragent . '|' . "\n";

								// Open the log file in "Append" mode
								if ( !$handle = fopen( $logfile, "a+" ) ) {
									die( "Failed to open log file" );
								}

								// Write $logline to our logfile.
								if ( fwrite( $handle, $logline ) === FALSE ) {
									die( "Failed to write to log file" );
								}

								fclose( $handle );

								//============ EO USER LOG DURING LOGIN ===============//    

								$arr = array();
								$arr[ "session_id" ] = $session_id;
								$arr[ "attendee_id" ] = $attendee_id;
								$arr[ "event_id" ] = $event_id;
								$arr[ "attendee_name" ] = $attendee_name;
								$arr[ "nickname" ] = $nickname;
								$arr[ "email" ] = $email;

								if ( isset( $_SESSION[ $session_key_name ] ) ) {
									$_SESSION[ $session_key_name ] = $arr;
									unset( $arr );
								}

								break;

							case 3:
								$type_class = "red"; // rejected
								//$html .= "<p>Sorry! your request to attend the event has been rejected.</p>";
								$html .= "<p>Désolé! votre demande d'assister à l'événement a été rejetée.</p>";
								break;

							default:
								$type_class = "blue";
								break;
						}

						//$html .= "<p>If you have any questions in the lead up to the event, please do not hesitate to contact us.</p>";

						$html .= "<p>Si vous avez des questions avant l’événement, n’hésitez pas à nous contacter.</p>";

						$return[ "type_class" ] = $type_class;
						$return[ "html" ] = $html;

						//print_r($return); 
						return $return;
					} else {
						return $return;
					}
				}
				return $return;
			}
			return $return;
		}
		return $return;
	}
}

if ( !function_exists( 'logout' ) ) {
	function logout() {
		//============ USER LOG DURING LOGIN ===============//    
		//$logfile = PROJECT_BASE_ROOT_PATH . "data/logs/user_log/user_log_" . date( "Ymd" ) . ".txt";
		$logfile = PROJECT_BASE_ROOT_PATH . "data/" . DATA_SERVER_NAME . "/logs/user_log/user_log_" . date( "Ymd" ) . ".txt";

		if ( !file_exists( $logfile ) ) {
			@mkdir( dirname( $logfile ), 0777, true );

			// Open the log file in "Append" mode
			$logline = "session_id | from_page_url | ipaddress | attendee_name | email | login_datetime | useragent | logout_datetime" . "\n";
			if ( !$handle = fopen( $logfile, "a+" ) ) {
				die( "Failed to open log file" );
			}

			// Write $logline to our logfile.
			if ( fwrite( $handle, $logline ) === FALSE ) {
				die( "Failed to write to log file" );
			}

			fclose( $handle );
		}

		$session_key_name = ( isset( $_SESSION[ "session_key_name" ] ) && trim( $_SESSION[ "session_key_name" ] ) != "" ) ? trim( $_SESSION[ "session_key_name" ] ) : "";

		$email = ( isset( $_SESSION[ $session_key_name ][ "email" ] ) && trim( $_SESSION[ $session_key_name ][ "email" ] ) != "" ) ? trim( $_SESSION[ $session_key_name ][ "email" ] ) : "";

		//$session_id = session_id();
		$session_id = ( isset( $_SESSION[ $session_key_name ][ "session_id" ] ) && trim( $_SESSION[ $session_key_name ][ "session_id" ] ) != "" ) ? trim( $_SESSION[ $session_key_name ][ "session_id" ] ) : "";

		$from_page_url = ( isset( $_SERVER[ 'HTTP_REFERER' ] ) ) ? $_SERVER[ 'HTTP_REFERER' ] : SITE_URL;
		$ipaddress = get_client_ip_server();
		$useragent = ( isset( $_SERVER[ 'HTTP_USER_AGENT' ] ) ) ? $_SERVER[ 'HTTP_USER_AGENT' ] : "";

		//echo "email => ".$email.", ";
		//echo "ipaddress => ".$ipaddress.", ";
		//echo "session_id => ".$session_id.", ";

		if ( file_exists( $logfile ) ) {
			//$handle = fopen( $logfile, "r" );
			//$log = fread( $handle, filesize( $logfile ) );
			//fclose( $handle );

			$log_arr = array();
			$log_arr = file( $logfile, FILE_IGNORE_NEW_LINES );
			//print_r($log_arr);    
			$log_arr = array_filter( $log_arr );
			//print_r($log_arr);

			if ( is_array( $log_arr ) && sizeof( $log_arr ) > 0 ) {
				$update_save = false;

				for ( $i = 1; $i < sizeof( $log_arr ); $i++ ) {
					if ( isset( $log_arr[ $i ] ) ) {
						$log_arr[ $i ] = trim( $log_arr[ $i ] );

						$exp_arr = array();
						$exp_arr = explode( "|", $log_arr[ $i ] );

						if ( is_array( $exp_arr ) && sizeof( $exp_arr ) > 0 ) {
							//print_r( $exp_arr );
							$user_log_session_id = ( isset( $exp_arr[ 0 ] ) ) ? $exp_arr[ 0 ] : "";
							$user_log_from_page_url = ( isset( $exp_arr[ 1 ] ) ) ? $exp_arr[ 1 ] : "";
							$user_log_ipaddress = ( isset( $exp_arr[ 2 ] ) ) ? $exp_arr[ 2 ] : "";
							$user_log_email = ( isset( $exp_arr[ 4 ] ) ) ? $exp_arr[ 4 ] : "";

							//echo "user_log_session_id => ".$user_log_session_id.", ";
							//echo "user_log_from_page_url => ".$user_log_from_page_url.", ";    
							//echo "user_log_ipaddress => ".$user_log_ipaddress.", ";
							//echo "user_log_email => ".$user_log_email.", ";    

							if ( ( $session_id == $user_log_session_id ) && ( $from_page_url == $user_log_from_page_url ) && ( $ipaddress == $user_log_ipaddress ) && ( $email == $user_log_email ) ) {
								$logout_time = date( "Y-m-d H:i:s" );
								//$log_arr[ $i ] .= $logout_time;  

								$user_log_attendee_name = ( isset( $exp_arr[ 3 ] ) ) ? $exp_arr[ 3 ] : "";
								$user_log_login_datetime = ( isset( $exp_arr[ 5 ] ) ) ? $exp_arr[ 5 ] : "";
								$user_log_useragent = ( isset( $exp_arr[ 6 ] ) ) ? $exp_arr[ 6 ] : "";
								//echo "found <br />";

								$logline = $user_log_session_id . '|' . $user_log_from_page_url . '|' . $user_log_ipaddress . '|' . $user_log_attendee_name . '|' . $user_log_email . '|' . $user_log_login_datetime . '|' . $user_log_useragent . '|' . $logout_time;
								$log_arr[ $i ] = $logline;

								//echo $log_arr[ $i ];
								$update_save = true;
							}
						}
					}
				}


				if ( $update_save ) {
					$log_arr = array_filter( $log_arr );
					//print_r($log_arr); die();

					$log_str = "";
					if ( is_array( $log_arr ) && sizeof( $log_arr ) > 0 ) {
						foreach ( $log_arr as $log ) {
							$log_str .= $log . "\n";
						}
					}
					// echo $log_str;
					@file_put_contents( $logfile, $log_str );
				}
			}
		} else {
			die( "The log file doesn't exist!" );
		}
		//die();  
		//============ EO USER LOG DURING LOGIN ===============// 

		if ( isset( $_SESSION[ $session_key_name ] ) ) {
			$_SESSION[ $session_key_name ] = array();
			//unset( $_SESSION[ $session_key_name ] );
		}


		@session_destroy();

		return true;
	}
}

//================== CURL POST -- EMS EVENT ================//

if ( !function_exists( 'SaveEventAttendeeDetails_Curl' ) ) {
	function SaveEventAttendeeDetails_Curl( $array = array() ) {
		$array = ( is_array( $array ) && sizeof( $array ) > 0 ) ? $array : $_REQUEST;
		//print_r($array);

		if ( is_array( $array ) && sizeof( $array ) > 0 ) {
			$fields = array();
			foreach ( $array as $key => $value ) {
				//echo "key: ".$key." => Value: ".$value."<br />";

				if ( in_array( strtolower( $key ), array( "ems_secret_code" ) ) ) {
					$fields[ "ems_secret_code" ] = trim( $value );
				}
				if ( in_array( strtolower( $key ), array( "first_name", "prénom", "prenom" ) ) ) {
					$fields[ "first_name" ] = trim( $value );
				}
				if ( in_array( strtolower( $key ), array( "last_name", "nom" ) ) ) {
					$fields[ "last_name" ] = $value;
				}
				if ( in_array( strtolower( $key ), array( "email" ) ) ) {
					$fields[ "email" ] = $value;
				}

				if ( in_array( strtolower( $key ), array( "phone", "telephone", "téléphone", "full_phone" ) ) ) {
					$fields[ "phone" ] = trim( $value );
				}
				if ( in_array( strtolower( $key ), array( "organization", "societe", "société", "company" ) ) ) {
					$fields[ "organization" ] = trim( $value );
				}
				if ( in_array( strtolower( $key ), array( "designation", "fonction", "job_title" ) ) ) {
					$fields[ "designation" ] = trim( $value );
				}
				if ( in_array( strtolower( $key ), array( "country" ) ) ) {
					$fields[ "country" ] = trim( $value );
				}
				if ( in_array( strtolower( $key ), array( "employees", "no_of_employees" ) ) ) {
					$fields[ "no_of_employees" ] = trim( $value );
				}

				if ( in_array( strtolower( $key ), array( "attendance_type" ) ) ) {
					$fields[ "attendance_type" ] = strtolower( trim( $value ) );
				}
				if ( in_array( strtolower( $key ), array( "postal_address" ) ) ) {
					$fields[ "postal_address" ] = trim( $value );
				}

				if ( in_array( strtolower( trim( $key ) ), array( "comment" ) ) ) {
					$fields[ "comment" ] = trim( $value );
				}

				if ( in_array( strtolower( trim( $key ) ), array( "status_id" ) ) ) {
					$fields[ "status_id" ] = trim( $value );
				}

				if ( in_array( strtolower( trim( $key ) ), array( "send_confirmation_mail_ems_yn" ) ) ) {
					$fields[ "send_confirmation_mail_ems_yn" ] = trim( $value );
				}

				if ( in_array( strtolower( $key ), array( "display_response" ) ) ) {
					$display_response = trim( $value );
				}
			}
			//print_r($fields); die();

			if ( is_array( $fields ) && sizeof( $fields ) > 0 ) {
				foreach ( $fields as $key => $value ) {
					$fields[ $key ] = urlencode( trim( $value ) );
				}
				//$fields[ "curl_post" ] = "1";  

				//url-ify the data for the POST
				$fields_string = "";
				foreach ( $fields as $key => $value ) {
					$fields_string .= $key . '=' . $value . '&';
				}
				rtrim( $fields_string, '&' );

				$url = CHOYOU_SITE_URL . "ems/event_api/add_attendee/";

				$url .= "?nocache=" . time();

				$response = post_curl2( $url, $fields_string );

				// do anything you want with your response
				//var_dump($response); die();

				//return $response;
				//return json_decode( $response, true );


				if ( $display_response ) {
					//print_r($response);     
					return json_decode( $response, true );
				}
			}
		}
	}
}

if ( !function_exists( 'CheckEventAttendeeExistsAndUpdateAttendeeStatus_Curl' ) ) {
	function CheckEventAttendeeExistsAndUpdateAttendeeStatus_Curl( $array = array() ) {
		$array = ( is_array( $array ) && sizeof( $array ) > 0 ) ? $array : $_REQUEST;
		//print_r($array);

		if ( is_array( $array ) && sizeof( $array ) > 0 ) {
			$fields = array();
			foreach ( $array as $key => $value ) {
				//echo "key: ".$key." => Value: ".$value."<br />";

				if ( in_array( strtolower( $key ), array( "ems_secret_code" ) ) ) {
					$fields[ "ems_secret_code" ] = trim( $value );
				}
				if ( in_array( strtolower( $key ), array( "email" ) ) ) {
					$fields[ "email" ] = $value;
				}
			}
			//print_r($fields); die();

			if ( is_array( $fields ) && sizeof( $fields ) > 0 ) {
				foreach ( $fields as $key => $value ) {
					$fields[ $key ] = urlencode( trim( $value ) );
				}

				//url-ify the data for the POST
				$fields_string = "";
				foreach ( $fields as $key => $value ) {
					$fields_string .= $key . '=' . $value . '&';
				}
				rtrim( $fields_string, '&' );

				$url = CHOYOU_SITE_URL . "ems/event_api/check_attendee_exists_and_update_event_attendee_attendee_status/";

				$url .= "?nocache=" . time();

				$response = post_curl2( $url, $fields_string );

				// do anything you want with your response
				//echo $response; die();  
				//var_dump($response); die(); 
				return json_decode( $response, true );
			}
		}
	}
}

//================== EO CURL POST -- EMS EVENT ================//

//================== LINKEDIN ================//

if ( !function_exists( 'SaveLinkedInUserToEMS' ) ) {
	function SaveLinkedInUserToEMS( $code = "" ) {
		$code = ( isset( $_REQUEST[ "code" ] ) ) ? trim( $_REQUEST[ "code" ] ) : $code;
		//echo "<pre>code =>".$code."</pre>"; die();

		$return = array( "status" => FALSE );
		if ( trim( $code ) != "" ) {
			$url = "https://www.linkedin.com/oauth/v2/accessToken";
			$param = "grant_type=authorization_code&client_id=" . CLIENT_ID . "&client_secret=" . CLIENT_SECRET . "&redirect_uri=" . REDIRECT_URI . "&code=" . $code;

			//echo "url => ".$url;
			//echo "param => ".$param;    

			$accessToken_response = array();
			$accessToken_response = ( json_decode( post_curl( $url, $param ), true ) ); // Request for access token
			//var_dump( $accessToken_response );

			if ( isset( $accessToken_response[ 'error' ] ) && $accessToken_response[ 'error' ] != "" ) // if invalid output error
			{
				$error = 'Some error occured: ' . $accessToken_response[ 'error' ] . ': ' . $accessToken_response[ 'error_description' ] . '. Please Try again.';
				$return[ "error" ] = $error;
				return $return;
			} else {
				// token received successfully  
				//echo "<p>Expires in :" . date( "i:s", $return[ 'expires_in' ] ) . "</p>";

				$url = "";
				// get user basic details
				$url = "https://api.linkedin.com/v2/me?projection=(id,firstName,lastName,localizedFirstName,localizedLastName,profilePicture(displayImage~:playableStreams))";
				$url .= "&oauth2_access_token=" . $accessToken_response[ 'access_token' ];

				//echo "<pre>url => " . $url . "</pre>";
				$user = json_decode( post_curl( $url ) ); // Request user information on received token

				// get email details
				//$url = "https://api.linkedin.com/v2/clientAwareMemberHandles?q=members&projection=(elements*(primary,type,handle~))";
				$url = "https://api.linkedin.com/v2/emailAddress?q=members&projection=(elements*(handle~))";
				$url .= "&oauth2_access_token=" . $accessToken_response[ 'access_token' ];
				$user_email = json_decode( post_curl( $url ) ); // Request user information on received token

				//var_dump( $user_email );
				//        echo "<p>============================================</p>";
				//        print_r( $user_email );
				//        echo "<p>============================================</p>";

				$email = $user_email->elements[ 0 ]->{"handle~"}->emailAddress;

				if ( $email != "" ) {
					//$userid = ( property_exists( $user, "id" ) ) ? $user->id : "";
					$first_name = ( property_exists( $user, "localizedFirstName" ) ) ? $user->localizedFirstName : "";
					$last_name = ( property_exists( $user, "localizedLastName" ) ) ? $user->localizedLastName : "";

					$url = CHOYOU_SITE_URL . CHOYOU_SAVE_POST_FILENAME;

					$url .= "?nocache=" . time();
					$param = "exp_fname=" . exp_fname . "&ems_secret_code=" . ems_secret_code . "&first_name=" . $first_name . "&last_name=" . $last_name . "&email=" . $email . "&register_via=LinkedIn";
					$param .= "&curl_post=1";
					$param .= "&status_id=" . ems_status_id;
					//$param .= "&display_response=true";

					$response = post_curl2( $url, $param );

					// do anything you want with your response
					//var_dump($response);
					//print_r($response);    

					//echo json_decode( $response, true );  
					//die(); 
					//return json_decode( $response, true );    

					$return = array( "status" => TRUE, "response" => json_encode( $response ) );
					return $return;
				}
				return $return;
			}
		}
		return $return;
	}
}

if ( !function_exists( 'JoinLinkedInGroup' ) ) {
	function JoinLinkedInGroup( $code = "" ) {
		$code = ( isset( $_REQUEST[ "code" ] ) ) ? trim( $_REQUEST[ "code" ] ) : $code;
		//echo "<pre>code =>".$code."</pre>"; die();

		$return = array( "status" => FALSE );
		if ( trim( $code ) != "" ) {
			$url = "https://www.linkedin.com/oauth/v2/accessToken";
			$param = "grant_type=authorization_code&client_id=" . CLIENT_ID . "&client_secret=" . CLIENT_SECRET . "&redirect_uri=" . REDIRECT_URI . "&code=" . $code;

			$accessToken_response = array();
			$accessToken_response = ( json_decode( post_curl( $url, $param ), true ) ); // Request for access token
			//var_dump( $response );

			if ( isset( $accessToken_response[ 'error' ] ) && $accessToken_response[ 'error' ] != "" ) // if invalid output error
			{
				$error = 'Some error occured: ' . $accessToken_response[ 'error' ] . ': ' . $accessToken_response[ 'error_description' ] . '. Please Try again.';
				$return[ "error" ] = $error;
				return $return;
			} else {
				// token received successfully  
				//echo "<p>Expires in :" . date( "i:s", $return[ 'expires_in' ] ) . "</p>";

				$url = "";
				// get user basic details
				$url = "https://api.linkedin.com/v2/me?projection=(id,firstName,lastName,localizedFirstName,localizedLastName,profilePicture(displayImage~:playableStreams))";
				$url .= "&oauth2_access_token=" . $accessToken_response[ 'access_token' ];

				//echo "<pre>url => " . $url . "</pre>";
				$user = json_decode( post_curl( $url ) ); // Request user information on received token
				//print_r($user);  

				// get email details
				//$url = "https://api.linkedin.com/v2/clientAwareMemberHandles?q=members&projection=(elements*(primary,type,handle~))";
				$url = "https://api.linkedin.com/v2/emailAddress?q=members&projection=(elements*(handle~))";
				$url .= "&oauth2_access_token=" . $accessToken_response[ 'access_token' ];
				$user_email = json_decode( post_curl( $url ) ); // Request user information on received token

				// var_dump( $user_email );
				//        echo "<p>============================================</p>";
				//        print_r( $user_email );
				//        echo "<p>============================================</p>";

				$emailAddress = $user_email->elements[ 0 ]->{"handle~"}->emailAddress;
				if ( trim( $emailAddress ) != "" ) {
					$userid = ( property_exists( $user, "id" ) ) ? $user->id : "";
					$firstName = ( property_exists( $user, "localizedFirstName" ) ) ? $user->localizedFirstName : "";
					$lastName = ( property_exists( $user, "localizedLastName" ) ) ? $user->localizedLastName : "";
					$profilePictureUrl = ( property_exists( $user, "profilePicture" ) ) ? $user->profilePicture->{"displayImage~"}->elements[ 0 ]->identifiers[ 0 ]->identifier : "no_image.jpg";
					//$publicProfileUrl = ( property_exists( $user, "publicProfileUrl" ) ) ? $user->publicProfileUrl : ""; 

					//echo "<pre>{$profilePictureUrl}</pre>";    

					//die();    

					$protocol = ( ( !empty( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] != 'off' ) || $_SERVER[ 'SERVER_PORT' ] == 443 ) ? "https://" : "http://";

					$from_page = ( isset( $_SERVER[ 'HTTP_REFERER' ] ) ) ? strtok( $_SERVER[ "HTTP_REFERER" ], '?' ) : $protocol . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];
					//echo $url; // Outputs: Full URL

					$url = CHOYOU_SITE_URL . "file/add_update_linkedin_user.php";
					$url .= "?nocache=" . time();

					//$param = "action=join_linkedin_group&userid=" . $userid . "&firstName=" . $firstName . "&lastName=" . $lastName . "&emailAddress=" . $emailAddress . "&pictureUrls=" . $profilePictureUrl . "&from_page=" . $from_page . "&linked_group=" . LINKEDIN_GROUP;    

					$param_arr = array();
					$param_arr[ "action" ] = "join_linkedin_group";
					$param_arr[ "userid" ] = $userid;
					$param_arr[ "firstName" ] = $firstName;
					$param_arr[ "lastName" ] = $lastName;
					$param_arr[ "emailAddress" ] = $emailAddress;
					$param_arr[ "pictureUrls" ] = $profilePictureUrl;
					$param_arr[ "from_page" ] = $from_page;

					$param = "";
					if ( is_array( $param_arr ) && sizeof( $param_arr ) > 0 ) {
						foreach ( $param_arr as $key => $value ) {
							$param .= $key . '=' . base64_encode( trim( $value ) ) . '&';
						}
						rtrim( $param, '&' );
					}

					//die($param); 
					//echo $param;    

					$response = post_curl2( $url, $param );

					// do anything you want with your response
					//var_dump($response);
					//print_r( $response ); die();

					$return = array( "status" => $response );
					if ( $response ) {
						$return[ "linked_group" ] = LINKEDIN_GROUP;
					}

					return $return;
				}
				return $return;
			}
		}
		return $return;
	}
}
//================== EO LINKEDIN ================//

//================== DOWNLOAD MANAGEMENT ================//
if ( !function_exists( 'downloadManagement' ) ) {
	function downloadManagement( $link = "" ) {
		$link = trim( $link );
		$not_link_arr = array( "#", "javascript: void(0);" );
		if ( $link != "" && !in_array( $link, $not_link_arr ) ) {

			//============ USER FILE DOWNLOAD LOG  ===============//
			$logfile = PROJECT_BASE_ROOT_PATH . "data/" . DATA_SERVER_NAME . "/logs/download_log/download_log_" . date( "Ymd" ) . ".txt";

			if ( !file_exists( $logfile ) ) {
				@mkdir( dirname( $logfile ), 0777, true );

				// Open the log file in "Append" mode
				//$logline = "ipaddress | email | datetime | download_link" . "\n";
                $logline = "page | ipaddress | useragent | remotehost | datetime | download_link | attendee_name | email" . "\n";
                
				if ( !$handle = fopen( $logfile, "a+" ) ) {
					die( "Failed to open log file" );
				}

				// Write $logline to our logfile.
				if ( fwrite( $handle, $logline ) === FALSE ) {
					die( "Failed to write to log file" );
				}

				fclose( $handle );
			}
			
            $ipaddress = get_client_ip_server();
            $useragent = ( isset( $_SERVER[ 'HTTP_USER_AGENT' ] ) ) ? $_SERVER[ 'HTTP_USER_AGENT' ] : "";
            $remotehost = @getHostByAddr( $ipaddress );
            $datetime = date( "Y-m-d H:i:s" );
            
            $page_url = ( isset( $_REQUEST[ 'page_url' ] ) ) ? $_REQUEST[ 'page_url' ] : "";
            //echo "<pre>page_url => ".$page_url."</pre>";
            
            $session_key_name = ( isset( $_SESSION[ "session_key_name" ] ) && trim( $_SESSION[ "session_key_name" ] ) != "" ) ? trim( $_SESSION[ "session_key_name" ] ) : "";

            $attendee_name = ( isset( $_SESSION[ $session_key_name ][ "attendee_name" ] ) && trim( $_SESSION[ $session_key_name ][ "attendee_name" ] ) != "" ) ? trim( $_SESSION[ $session_key_name ][ "attendee_name" ] ) : "";

            $attendee_email = ( isset( $_SESSION[ $session_key_name ][ "email" ] ) && trim( $_SESSION[ $session_key_name ][ "email" ] ) != "" ) ? trim( $_SESSION[ $session_key_name ][ "email" ] ) : "";

			//$logline = $ipaddress . '|' . $email . '|' . $datetime . '|' . $link . "\n";
            
            $logline = $page_url . '|' . $ipaddress . '|' . $useragent . '|' . $remotehost . '|' . $datetime . '|' . $link . '|' . $attendee_name . '|' . $attendee_email . "\n";
            
			// Open the log file in "Append" mode
			if ( !$handle = fopen( $logfile, "a+" ) ) {
				die( "Failed to $link . '|' .open log file" );
			}

			// Write $logline to our logfile.
			if ( fwrite( $handle, $logline ) === FALSE ) {
				die( "Failed to write to log file" );
			}

			fclose( $handle );
			//============ EO USER FILE DOWNLOAD LOG ===============// 

			return true;
		}
		return false;
	}
}
//================== EO DOWNLOAD MANAGEMENT ================//

if ( !function_exists( 'get_the_browser' ) ) {
	function get_the_browser() {
		if ( strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'MSIE' ) !== false )
			return 'Internet explorer';
		elseif ( strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Trident' ) !== false )
			return 'Internet explorer';
		elseif ( strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Firefox' ) !== false )
			return 'Mozilla Firefox';
		elseif ( strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Chrome' ) !== false )
			return 'Google Chrome';
		elseif ( strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Opera Mini' ) !== false )
			return "Opera Mini";
		elseif ( strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Opera' ) !== false )
			return "Opera";
		elseif ( strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Safari' ) !== false )
			return "Safari";
		else
			return 'Other';
	}
}

//================== VISITOR MANAGEMENT ================//
if ( !function_exists( 'record_visitor_log' ) ) {
	function record_visitor_log() {

		// Write to log file:
		// folder -> visitor_log -> file -> ymd
		$logfile = PROJECT_BASE_ROOT_PATH . "data/" . DATA_SERVER_NAME . "/logs/visitor_log/visitor_log_" . date( "Ymd" ) . ".txt";

		if ( !file_exists( $logfile ) ) {
			@mkdir( dirname( $logfile ), 0777, true );

			// Open the log file in "Append" mode
			if ( !$handle = fopen( $logfile, "a+" ) ) {
				die( "Failed to open log file" );
			}

			$logline = "ipaddress | referrer | datetime | useragent | remotehost | page | attendee_name | email" . "\n";

			// Write $logline to our logfile.
			if ( fwrite( $handle, $logline ) === FALSE ) {
				die( "Failed to write to log file" );
			}

			fclose( $handle );
		}

		// Getting the information
		//$ipaddress = $_SERVER[ 'REMOTE_ADDR' ];
		$ipaddress = get_client_ip_server();
		$uri = ( !empty( $_SERVER[ 'HTTPS' ] ) && ( 'on' == $_SERVER[ 'HTTPS' ] ) ) ? "https://" : "http://";
		$page = $uri . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'PHP_SELF' ];
		$page .= ( !empty( $_SERVER[ 'QUERY_STRING' ] ) ? "?" . $_SERVER[ 'QUERY_STRING' ] : "" );
		$referrer = ( isset( $_SERVER[ 'HTTP_REFERER' ] ) ) ? $_SERVER[ 'HTTP_REFERER' ] : "";
		$datetime = date( "Y-m-d H:i:s" );
		$useragent = ( isset( $_SERVER[ 'HTTP_USER_AGENT' ] ) ) ? $_SERVER[ 'HTTP_USER_AGENT' ] : "";
		$remotehost = @getHostByAddr( $ipaddress );

		//$logline = $ipaddress . '|' . $referrer . '|' . $datetime . '|' . $useragent . '|' . $remotehost . '|' . $page . "\n";

		$session_key_name = ( isset( $_SESSION[ "session_key_name" ] ) && trim( $_SESSION[ "session_key_name" ] ) != "" ) ? trim( $_SESSION[ "session_key_name" ] ) : "";

		$attendee_name = ( isset( $_SESSION[ $session_key_name ][ "attendee_name" ] ) && trim( $_SESSION[ $session_key_name ][ "attendee_name" ] ) != "" ) ? trim( $_SESSION[ $session_key_name ][ "attendee_name" ] ) : "";

		$attendee_email = ( isset( $_SESSION[ $session_key_name ][ "email" ] ) && trim( $_SESSION[ $session_key_name ][ "email" ] ) != "" ) ? trim( $_SESSION[ $session_key_name ][ "email" ] ) : "";

		$logline = $ipaddress . '|' . $referrer . '|' . $datetime . '|' . $useragent . '|' . $remotehost . '|' . $page . '|' . $attendee_name . '|' . $attendee_email . "\n";

		// Open the log file in "Append" mode
		if ( !$handle = fopen( $logfile, "a+" ) ) {
			die( "Failed to open log file" );
		}

		// Write $logline to our logfile.
		if ( fwrite( $handle, $logline ) === FALSE ) {
			die( "Failed to write to log file" );
		}

		fclose( $handle );

	}
}
//================== VISITOR MANAGEMENT ================//

// Convert a date or timestamp into French.
if ( !function_exists( 'dateToFrench' ) ) {
	function dateToFrench( $date, $format ) {
		$english_days = array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' );
		$french_days = array( 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche' );
		$english_months = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
		$french_months = array( 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre' );
		return str_replace( $english_months, $french_months, str_replace( $english_days, $french_days, date( $format, strtotime( $date ) ) ) );
	}
}

if ( !function_exists( 'init_events' ) ) {
	function init_events( $events_arr ) {
		if ( is_array( $events_arr ) && sizeof( $events_arr ) > 0 ) {
			$i = 0;
			foreach ( $events_arr as $events ) {
				if ( array_key_exists( "event_date_str", $events ) && trim( $events[ "event_date_str" ] ) != "" ) {
					$event_date_str = $events[ "event_date_str" ];

					// event_starts_on_timestamp  
					if ( !array_key_exists( "event_date_str", $events ) ) {
						$events[ "event_date_str" ] = $event_date_str;
					}

					// event_starts_on_timestamp  
					if ( !array_key_exists( "event_starts_on_timestamp", $events ) ) {
						$events[ "event_starts_on_timestamp" ] = strtotime( $event_date_str );
					}
					// event_starts_on  
					if ( !array_key_exists( "event_starts_on_datetime", $events ) ) {
						$events[ "event_starts_on_datetime" ] = date( "Y-m-d H:i:s", strtotime( $event_date_str ) );
					}

					if ( !array_key_exists( "event_starts_on_date", $events ) ) {
						$events[ "event_starts_on_date" ] = date( "Y-m-d", strtotime( $event_date_str ) );
					}

					if ( !array_key_exists( "event_starts_on_time", $events ) ) {
						$events[ "event_starts_on_time" ] = date( "H:i", strtotime( $event_date_str ) );
					}

					$event_date_in_fr = dateToFrench( $event_date_str, "d-F-Y" );
					//echo "<pre>event_date_in_fr =>" . event_date_in_fr . "</pre>";
					if ( !array_key_exists( "event_date_in_fr", $events ) ) {
						$events[ "event_date_in_fr" ] = $event_date_in_fr;
					}

					$event_date_str_in_fr = dateToFrench( $event_date_str, "l, j F Y" );
					//echo "<pre>event_date_str_in_fr =>" . $event_date_str_in_fr . "</pre>";
					if ( !array_key_exists( "event_date_str_in_fr", $events ) ) {
						$events[ "event_date_str_in_fr" ] = $event_date_str_in_fr;
					}

					if ( !array_key_exists( "event_time_str_in_fr", $events ) ) {
						//$minutes = date( "i", strtotime( $event_date_str ) );  
						$events[ "event_time_str_in_fr" ] = ( date( "i", strtotime( $event_date_str ) ) > 0 ) ? date( "G\h i\m", strtotime( $event_date_str ) ) : date( "G\h", strtotime( $event_date_str ) );
					}

					//check if folder exists, if not create folder
					$folder = PROJECT_BASE_ROOT_PATH . "section/content/" . $event_date_in_fr;

					if ( !array_key_exists( "content_folder_path", $events ) ) {
						$events[ "content_folder" ] = $folder;
					}

					if ( !file_exists( $folder ) ) {
						@mkdir( dirname( $logfile ), 0777, true );
					}

					//check if files exists
					$files_arr = array( "theme", "intervenants", "agenda", "partners" );
					if ( is_array( $files_arr ) && sizeof( $files_arr ) > 0 ) {
						sort( $files_arr );

						foreach ( $files_arr as $files ) {
							$content_file = $folder . "/" . $files . ".php";

							if ( !file_exists( $content_file ) ) {
								@mkdir( dirname( $content_file ), 0777, true );

								// Open the log file in "Append" mode
								if ( !$handle = fopen( $content_file, "a+" ) ) {
									die( "Failed to open log file" );
								}
								fclose( $handle );
							}

							if ( !array_key_exists( $files, $events ) ) {
								$events[ $files ] = $content_file;
							}
						}
					}

					$events_arr[ $i ] = $events;

				}
				$i++;
			}
			//print_r( $events_arr );
			return $events_arr;
		}
	}
}

if ( !function_exists( 'removeAccents' ) ) {
	function removeAccents( $str ) {
		$a = array( 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή' );
		$b = array( 'A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η' );
		return str_replace( $a, $b, $str );
	}
}

//================== UTM MANAGEMENT ================//
if ( !function_exists( 'record_utm_log' ) ) {
	function record_utm_log() {

		// Write to log file:
		//$server_name = strtolower( str_replace( ".", "_", $_SERVER[ 'SERVER_NAME' ] ) );
		$logfile = PROJECT_BASE_ROOT_PATH . "data/" . DATA_SERVER_NAME . "/logs/utm_log/utm_log_" . date( "Ymd" ) . ".txt";

		if ( !file_exists( $logfile ) ) {
			@mkdir( dirname( $logfile ), 0777, true );

			// Open the log file in "Append" mode
			if ( !$handle = fopen( $logfile, "a+" ) ) {
				die( "Failed to open log file" );
			}

			//$logline = "ipaddress | referrer | datetime | useragent | remotehost" . "\n";
			$logline = "page_url | utm_source | utm_medium | utm_campaign | referrer | ipaddress | datetime | useragent | remotehost" . "\n";

			// Write $logline to our logfile.
			if ( fwrite( $handle, $logline ) === FALSE ) {
				die( "Failed to write to log file" );
			}

			fclose( $handle );
		}

		// Getting the information
		$ipaddress = get_client_ip_server();
		$page_url = ( isset( $_REQUEST[ 'page_url' ] ) ) ? $_REQUEST[ 'page_url' ] : "";
		$utm_source = ( isset( $_REQUEST[ 'utm_source' ] ) ) ? $_REQUEST[ 'utm_source' ] : "";
		$utm_medium = ( isset( $_REQUEST[ 'utm_medium' ] ) ) ? $_REQUEST[ 'utm_medium' ] : "";
		$utm_campaign = ( isset( $_REQUEST[ 'utm_campaign' ] ) ) ? $_REQUEST[ 'utm_campaign' ] : "";
		$referrer = ( isset( $_REQUEST[ 'referrer' ] ) ) ? $_REQUEST[ 'referrer' ] : "";
		$datetime = date( "Y-m-d H:i:s" );
		$useragent = ( isset( $_SERVER[ 'HTTP_USER_AGENT' ] ) ) ? $_SERVER[ 'HTTP_USER_AGENT' ] : "";
		$remotehost = @getHostByAddr( $ipaddress );

		//$logline = $ipaddress . '|' . $referrer . '|' . $datetime . '|' . $useragent . '|' . $remotehost . "\n";

		$logline = $page_url . '|' . $utm_source . '|' . $utm_medium . '|' . $utm_campaign . '|' . $referrer . '|' . $ipaddress . '|' . $datetime . '|' . $useragent . '|' . $remotehost . "\n";

		// Open the log file in "Append" mode
		if ( !$handle = fopen( $logfile, "a+" ) ) {
			die( "Failed to open log file" );
		}

		// Write $logline to our logfile.
		if ( fwrite( $handle, $logline ) === FALSE ) {
			die( "Failed to write to log file" );
		}

		fclose( $handle );

		return true;
	}
}
//================== UTM MANAGEMENT ================//

//================== BREAKOUT ================//
if ( !function_exists( 'get_webinar_details' ) ) {
	function get_webinar_details() {
		//print_r( $_REQUEST[ "session" ] ); die();
		$req_session = ( isset( $_REQUEST[ "session" ] ) ) ? is_array( $_REQUEST[ "session" ] ) ? implode( ";", $_REQUEST[ "session" ] ) : mb_strtolower( trim( $_REQUEST[ "session" ] ), "UTF-8" ) : "";

		$session_arr = array();
		$session_arr = explode( ";", $req_session );

		$event_domaine = "";

		if ( is_array( $session_arr ) && sizeof( $session_arr ) > 0 ) {
			foreach ( $session_arr as $session ) {

				$session = mb_strtolower( trim( $session ), "UTF-8" );

				// return title, date
				switch ( $session ) {
					case "workplace":
						$event_domaine = "Workplace";
						break;

					case "workplace-sap":
						$event_domaine = "Workplace SAP";
						break;

					case "composable-vcf":
						$event_domaine = "Composable + VCF";
						break;

					case "private-cloud":
						$event_domaine = "Private Cloud";
						break;

					case "containerisation":
						$event_domaine = "Containerisation";
						break;

					case "Identification":
						$event_domaine = "Identification";
						break;

					default:
						break;
				}

				return array( "event_domaine" => $event_domaine );
			}
		}

		return array( "event_domaine" => $event_domaine );
	}
}
//================== BREAKOUT ================//