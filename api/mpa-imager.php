<?php
// set our own page header for json...
//header('Content-Type: image/png' );

// hardcode the URL endpoint
//$endpt = 'http://localhost';
$endpt = 'http://mpa-dev.ninthlink.agency';

// create an empty array for holding our results
$results = array();

// look for url to process
$url = '';
if ( !isset( $_REQUEST['url'] ) ) {
  echo json_encode( array('error' => 'no url = no checking...' ) );
  die;
} else {
  $url = $_REQUEST['url'];
  // #todo SANITIZE?!
}

if ( !function_exists( 'curl_init' ) ) {
  echo json_encode( array('error' => 'curl must be enabled to make this work' ) );
  die;
} // else...

// init curl...
$ch = curl_init();

// point to our endpoint url
curl_setopt( $ch, CURLOPT_URL, $endpt );

// set PORT number?
//curl_setopt( $ch, CURLOPT_PORT, 8080 );

// set a couple more CURLOPTs
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

// set POST
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, 'url='. $url );

//echo 'curling...' ."\n\n";

//$report = curl_getinfo( $ch );
//print_r( $report );

$result = curl_exec( $ch );
curl_close( $ch );

//print_r( $result );

// now $result should be an array of json arrays of results by scoreTypes, so
//echo json_encode( $result );
echo $result;
// and then?
//$results = explode( "\n", $result);
//echo $results[1];
?>
