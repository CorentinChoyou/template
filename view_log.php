<?php
include( "inc/include.php" );
// record visitor
//record_visitor_log();

//include( PROJECT_BASE_ROOT_PATH . "inc/pagination/pagination.php" );

//$logFolder = PROJECT_BASE_ROOT_PATH . "data/logs/";
$logFolder = "data/" . DATA_SERVER_NAME . "/logs/";

$logFolderPath = PROJECT_BASE_ROOT_PATH . $logFolder;
$logFolderURL = SITE_URL . $logFolder;

if ( !defined( "logFolderPath" ) ) {
  define( "logFolderPath", $logFolderPath );
}

if ( !defined( "logFolderURL" ) ) {
  define( "logFolderURL", $logFolderURL );
}

// post data
$log_directory = ( isset( $_REQUEST[ 'log_directory' ] ) && trim( $_REQUEST[ 'log_directory' ] ) != NULL ) ? trim( $_REQUEST[ 'log_directory' ] ) : "";

$log_file = ( trim( $log_directory ) != "" ) ? ( ( isset( $_REQUEST[ 'log_file' ] ) && trim( $_REQUEST[ 'log_file' ] ) != NULL ) ? trim( $_REQUEST[ 'log_file' ] ) : "" ) : "";
//page
$page = ( isset( $_REQUEST[ 'page' ] ) && trim( $_REQUEST[ 'page' ] ) != NULL ) ? trim( $_REQUEST[ 'page' ] ) : "1";
$search = ( isset( $_POST[ 'search' ] ) && trim( $_POST[ 'search' ] ) != NULL ) ? trim( $_POST[ 'search' ] ) : "";


function getDirectories( $folder ) {
  $sub_directories = array();
  $sub_directories = array_map( 'basename', glob( $folder . '/*', GLOB_ONLYDIR ) );
  return $sub_directories;
}

function get_file_details_under_dir( $dir = "", $file_prefix = "" ) {
  $dir = ( trim( $dir ) != "" ) ? trim( $dir ) : "";
  $file_prefix = ( trim( $file_prefix ) != "" ) ? trim( $file_prefix ) : "";
  //$not_allowed_files_arr = array(".", "..", "index.php", "_notes" );

  $file_details_array = array();
  if ( file_exists( $dir ) && is_dir( $dir ) ) {
    //$files = scandir( $dir, 1 );
    $files = glob( $dir . "{$file_prefix}*.txt" );
    //print_r($files);  
    //echo "<p>==============================================================</p>";        
    //die();

    // && sizeof( array_diff( $not_allowed_files_arr, $files) ) > 0
    if ( is_array( $files ) && sizeof( $files ) > 0 ) {
      $file_count = 0;
      foreach ( $files as $file ) {
        $file_details_arr = array();
        $file_details_arr = pathinfo( $file );
        //print_r($file_details_arr); //die();

        // echo "<p>".($file_count+1)." filename => " . $file_details_arr['basename'] . "</p>"; 
        //          //// get file size in bytes
        //          echo "<p>full_path_filename is " . ($file )  . "</p>";                
        //          echo "<p>Size is " . filesize( $file ) . " bytes</p>";
        //          echo "<p>Size -> formatBytes is " . formatBytes( filesize( $file ) ) . "</p>";
        //          //// get file access/modification times
        //          echo "<p>Last accessed on: " . date( "Y-m-d H:i:s", fileatime( $file ) ) . "</p>";
        //          echo "<p>Last modified on: " . date( "Y-m-d H:i:s", filemtime( $file ) ) . "</p>";
        //          die();  

        $fp = array();
        $fp = file( $file, FILE_SKIP_EMPTY_LINES );

        //echo "<p>row_count: " . ( ( is_array( $fp ) && count( $fp ) > 0 ) ? count( $fp ) : 0) . "</p>";    

        // add to array 
        $file_details_array[ $file_count ][ "dirname" ] = $file_details_arr[ 'dirname' ];
        $file_details_array[ $file_count ][ "filename" ] = $file_details_arr[ 'basename' ];
        $file_details_array[ $file_count ][ "full_path_filename" ] = $file;
        $file_details_array[ $file_count ][ "row_count" ] = ( is_array( $fp ) && count( $fp ) > 0 ) ? ( count( $fp ) - 1 ) : 0;
        $file_details_array[ $file_count ][ "filesize" ] = formatBytes( filesize( $file ) );
        //$file_details_array[ $file_count ][ "file_last_accessed_on" ] = date( "Y-m-d H:i:s", fileatime( $file ) );
        //$file_details_array[ $file_count ][ "file_last_modified_on" ] = date( "Y-m-d H:i:s", filemtime( $file ) );

        $file_count++;
      }
      return $file_details_array;
    }
  } else {
    die( $dir . " directory do not exists." );
  }
}


function formatBytes( $size, $precision = 2 ) {
  $base = log( $size, 1024 );
  $suffixes = array( 'B', 'KB', 'MB', 'GB', 'TB' );

  return round( pow( 1024, $base - floor( $base ) ), $precision ) . ' ' . $suffixes[ floor( $base ) ];
}

function export_txt_to_csv( $txtfile ) {
  $txtfile = trim( $txtfile );

  if ( $txtfile != "" && file_exists( $txtfile ) ) {

    if ( !$handle = fopen( $txtfile, "r" ) ) {
      die( "Failed to open log file" );
    }

    $lines = [];
    if ( ( $handle = fopen( $txtfile, "r" ) ) !== FALSE ) {
      while ( ( $data = fgetcsv( $handle, 1000, "\t" ) ) !== FALSE ) {
        if ( is_array( $data ) && sizeof( $data ) > 0 ) {
          foreach ( $data as $key => $value ) {
            //echo "<pre>{$value}</pre>";  
            $value = str_replace( array( " | " ), "|", trim( $value ) );
            //echo "<pre>{$value}</pre>";  
            $value = str_replace( array( "|" ), ",", trim( $value ) );
            //echo "<pre>{$value}</pre>";  
            $data[ $key ] = $value;
          }
        }

        $lines[] = $data;
      }
      fclose( $handle );
    }

    $dirname = dirname( $txtfile );
    $file_name = basename( $txtfile, ".txt" );

    $fp = fopen( $dirname . "/" . $file_name . ".csv", "w" );
    foreach ( $lines as $line ) {
      fputcsv( $fp, $line );
    }
    fclose( $fp );

    return $file_name . ".csv";

  } else {
    die( "The log file '{$txtfile}' doesn't exist!" );
  }
}

function generate_log_datatable( $log_dir, $log_file ) {
  $str = "";
  $th_str = "";
  $tbody_str = "";

  $log_dir = trim( $log_dir );
  $log_file = trim( $log_file );

  if ( $log_dir != "" && $log_file != "" ) {
    $total_log_dir = logFolderPath . $log_dir . "/";
    if ( file_exists( $total_log_dir ) && is_dir( $total_log_dir ) ) {

      //=========== log files data ========// 
      $tbody_str = "";
      if ( strtolower( $log_file ) == "all" ) {

      } else {
        $txtfile = $total_log_dir . $log_file;

        $log = array();
        $log = file( $txtfile, FILE_IGNORE_NEW_LINES );
        $log = array_filter( $log );
        //print_r( $log );

        if ( is_array( $log ) && sizeof( $log ) > 0 ) {

          $log_explode_size = 0;
          $lines = array();

          // Seperate each part in each logline 
          $k = 0;
          for ( $i = 1; $i < sizeof( $log ); $i++ ) {
            if ( isset( $log[ $i ] ) ) {
              $log[ $i ] = trim( $log[ $i ] );
              $lines[ $k ] = explode( "|", $log[ $i ] );
              $log_explode_size = sizeof( $lines[ $k ] );
              $k++;
            }
          }

          //echo $log_explode_size;
          if ( is_array( $lines ) && sizeof( $lines ) > 0 ) {
            // print_r($lines); 
            $cnt = 1;
            foreach ( $lines as $logline ) {
              //print_r($logline);
              $tbody_str .= "<tr>";
              if ( $log_explode_size > 0 ) {
                $tbody_str .= "<td>" . $cnt . "</td>";
                for ( $j = 0; $j < $log_explode_size; $j++ ) {
                  $tbody_str .= "<td>" . ( isset( $logline[ $j ] ) ? $logline[ $j ] : "" ) . "</td>";
                }
              }
              $tbody_str .= "</tr>";
              $cnt++;
            }
          }
        }
      }
      //=========== log files data ========// 

      //echo ($tbody_str);    

      $th_arr = array();
      switch ( $log_dir ) {
        case "download_log":
          //$th_arr = array( "ipaddress", "email", "datetime", "download_link" );
          $th_arr = array( "from_page_url", "ipaddress", "useragent", "remotehost", "datetime", "download_link", "attendee_name", "email" );      
          break;

        case "user_log":
          $th_arr = array( "session_id", "ipaddress", "attendee_name", "email", "login_datetime", "useragent", "logout_datetime" );
          break;

        case "visitor_log":
          $th_arr = array( "ipaddress", "referrer", "datetime", "useragent", "remotehost", "page", "attendee_name", "email" );      
          break;

        case "utm_log":
          $th_arr = array( "page_url", "utm_source", "utm_medium", "utm_campaign", "referrer", "ipaddress", "datetime", "useragent", "remotehost" );      
          break;
      };

      $colspan = ( is_array( $th_arr ) && sizeof( $th_arr ) > 0 ) ? ( sizeof( $th_arr ) + 1 ) : 0;

      if ( is_array( $th_arr ) && sizeof( $th_arr ) > 0 ) {
        $th_str = "<tr>";
        $th_str .= "<th>#</th>";
        foreach ( $th_arr as $th ) {
          $th = ucwords( str_replace( array( "_" ), " ", strtolower( trim( $th ) ) ) );
          $th_str .= "<th>{$th}</th>";
        }
        $th_str .= "</tr>";
      }

      //============== txt to csv download ========//    
      $csv_file = export_txt_to_csv( $txtfile );
      $csv_file_str = "";
      if ( $csv_file != "" ) {
        $total_csv_file = $total_log_dir . $log_file;
        if ( file_exists( $total_csv_file ) ) {
          $csv_file_url = logFolderURL . $log_dir . "/" . $csv_file;
          $csv_file_str = "<a href='" . $csv_file_url . "' target='_blank' class='m-3'><button type='button' class='btn btn-success btn-sm'><i class='fas fa-file-excel'></i> Download</button></a>";
        }
      }
      //============== txt to csv download ========//

      //============== txt download ========//
      $txt_file_str = "";
      if ( file_exists( $txtfile ) ) {
        $txt_file_url = logFolderURL . $log_dir . "/" . $log_file;
        $txt_file_str = "<a href='" . $txt_file_url . "' target='_blank' class=''><button type='button' class='btn btn-info btn-sm'><i class='fas fa-file-alt'></i> Download</button></a>";
      }
      //============== txt download ========//

      $download_file_str = "";
      $download_file_str .= "<p class='ml-auto'>";
      $download_file_str .= $txt_file_str;
      $download_file_str .= $csv_file_str;
      $download_file_str .= "</p>";

      $str .= $download_file_str;
      $str .= '<div class="table-responsive">';
      $str .= '<table class="table table-striped table-bordered table-hover table-condensed" width="99%">';
      $str .= "<thead>";
      $str .= $th_str;
      $str .= "</thead>";

      $str .= "<tbody>";
      $str .= $tbody_str;
      $str .= "</tbody>";

      $str .= "<tfoot>";
      $str .= $th_str;
      $str .= "</tfoot>";

      $str .= "</table>";
      $str .= "</div>"; //table-responsive
      $str .= $download_file_str;
    }
  }
  //die( $str );
  return $str;
}

$sub_directories = array();
$sub_directories = getDirectories( logFolderPath );
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- CSS -->
<link rel="stylesheet" href="https://use.typekit.net/xnp8mpa.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha256-UzFD2WYH2U1dQpKDjjZK72VtPeWP50NoJjd26rnAdUI=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> 
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
<title>View Log</title>
<style type="text/css">
.form-control {
    width: 100% !important;
}
table th, table td {
    overflow: hidden;
    white-space: inherit;
    word-wrap: break-word;
    max-width: 150px;
    font-size: 12px;
}
</style>
</head>

<body>
<!--<header id="header">
  <div class="container-fluid">
    <div class="container"> </div>
  </div>
  <div class="container-fluid">
    <div class="container"> <a class="navbar-brand" href="javascript: void(0);"> <img src="assets/images/logo-forescout.svg" width="250" class="d-inline-block align-top" alt=""> </a> </div>
  </div>
</header>-->
<main>
  <div class="container">
    <div class="row">
      <h1> View Logs </h1>
    </div>
    <div class="row">
      <div id="filter-panel" class="filter-panel">
        <div class="panel panel-default">
          <div class="panel-body">
            <form id="form-search" class="form-inline" role="search" method="GET" action="">
              <?php if ( is_array($sub_directories) && sizeof( $sub_directories ) > 0 ) { ?>
              <div class="form-group">
                <label for="log_directory">Filter by Log Sub-directory</label>
                <select name="log_directory" id="log_directory" class="form-control">
                  <option value="">Select</option>
                  <?php
                  foreach ( $sub_directories as $sub_directory ) {
                    $selected = ( $sub_directory == $log_directory ) ? "selected='selected'" : "";
                    ?>
                  <option value="<?php echo strtolower( $sub_directory); ?>" <?php echo $selected;?>><?php echo ucfirst( str_replace("_log", "", strtolower( $sub_directory ) ) ) ; ?></option>
                  <?php } ?>
                </select>
              </div>
              <?php } ?>
              <?php
              if ( trim( $log_directory ) != "" ) {
                $sub_dir_files_arr = array();
                $dir = logFolderPath . $log_directory . "/";
                $file_prefix = $log_directory . "_";
                $sub_dir_files_arr = get_file_details_under_dir( $dir, $file_prefix );
                //print_r( $sub_dir_files_arr );

                if ( is_array( $sub_dir_files_arr ) && sizeof( $sub_dir_files_arr ) > 0 ) {
                  ?>
              <div class="form-group" id="div_log_file">
                <label for="log_file">Filter by Log Files</label>
                <select name="log_file" id="log_file" class="form-control">
                  <option value="">Select</option>
                  <!--<option value="all">ALL</option>-->
                  <?php
                  for ( $i = 0; $i < sizeof( $sub_dir_files_arr ); $i++ ) {
                    $row = $sub_dir_files_arr[ $i ];
                    $filename = ucfirst( str_replace( array( "{$file_prefix}", ".txt" ), "", strtolower( $row[ "filename" ] ) ) );
                    $filename = date( "jS M Y", strtotime( $filename ) );
                    $selected = ( trim( $row[ 'filename' ] ) == $log_file ) ? "selected='selected'" : "";
                    ?>
                  <option value="<?php echo trim( $row['filename'] ); ?>" <?php echo $selected;?>><?php echo $filename ; ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <?php
              }
              }
              ?>
              
              <!--<div class="form-group">
                <label for="search_string">Search</label>
                <input type="search" name="search" id="search" value="<?php //echo $search; ?>" placeholder="Search" class="form-control" />
              </div>--> 
              <!--<div class="form-group">
                <label for="per_page">Per page</label>
                <select name="per_page" id="per_page" class="form-control">
                  <?php
                  /*$options = array( '1' => '1', '10' => '10', '25' => '25', '50' => '50', '100' => '100', '150' => '150', '200' => '200', '-1' => 'All' );
                  foreach ( $options as $key => $val ) {
                    $selected = ( $key == $per_page ) ? "selected" : "";
                    ?>
                  <option value="<?php echo strtolower($key); ?>" <?php echo $selected; ?>> <?php echo $val; ?> </option>
                  <?php }*/ ?>
                </select>
              </div>--> 
              <!--<input type="hidden" name="page" value="1" />-->
              <input class="btn btn-primary btn-sm m-3" type="submit" value="Go" name="mysubmit"/>
              <input class="btn btn-info btn-sm" type="button" value="Reset" name="reset" id="btn_reset" />
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <p>&nbsp;</p>
      <?php echo generate_log_datatable( $log_directory, $log_file ); ?> </div>
  </div>
</main>
<!--<div class="container_contact">
  <div class="container">
    <div class="row">
      <div class="col-md-3 logo_contact"> <img src="assets/images/logo-forescout.svg" alt="Forescout"> </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <p> <strong>Headquarters</strong> <br />
          190 W Tasman Dr.<br />
          San Jose, CA, USA 95134 </p>
        <div class="picto_contact"> <a target="_blank" href="https://www.facebook.com/ForescoutTechnologies/?ref=br_rs"><img src="assets/images/contact_facebook.svg" alt="Facebook"/></a> <a target="_blank" href="https://twitter.com/Forescout"><img src="assets/images/contact_twitter.svg" alt="Twitter"/></a> <a target="_blank" href="https://www.linkedin.com/company/forescout-technologies/"><img src="assets/images/contact_linkedin.svg" alt="Linkedin"/></a> <a target="_blank" href="https://www.youtube.com/user/forescout1"><img src="assets/images/contact_youtube.svg" alt="Youtube"/></a> 
           <a target="_blank" href=""><img src="assets/images/contact_bulle.svg" alt="Message"/></a> 
        </div>
      </div>
      <div class="col-md-8">
        <p> <strong>Contact Us</strong><br />
          Toll-Free (US): 1-866-377-8771<br />
          Tel (Intl): +1-408-213-3191<br />
          Support: +1-708-237-6591<br />
          <br />
          <span class="contact_droit">© <?php echo date("Y"); ?> Forescout Technologies Inc. All rights reserved. Terms of Use and Privacy Policy</span> </p>
      </div>
    </div>
  </div>
</div>--> 
<script type="text/javascript">
  $(document).ready(function () {
      
      if( $("#btn_reset").length){
          //console.log("btn_reset exists");
           $("#btn_reset").on("click", function () {
               //console.log("btn_reset click");
               window.location.href = "view_log.php";
           });
      }
      
      if( $("#log_directory").length){
        var $log_directory = $.trim( $("#log_directory option:selected").val() );
        //console.log("$log_directory", $log_directory);
          
        if( $.trim( $log_directory ) != ""){
           if( $("#div_log_file").length){
              $("#div_log_file").show(); 
           }  
        } else {
            if( $("#div_log_file").length){
                $("#div_log_file").hide(); 
            } 
        }
          
        $("#log_directory").change(function (e) {
           //console.log($(this).val());
            if( $("#log_file").length){
              //console.log("log_file exists");  
              $("#log_file").prop( "disabled", true ); 
            }            
            $("#form-search").submit();
        });  
          
      }
      
      if( $("#log_file").length){
        $("#log_file").change(function (e) {
           //console.log($(this).val());
            $("#form-search").submit();
        });  
          
      }
      
      
});
</script>
</body>
</html>