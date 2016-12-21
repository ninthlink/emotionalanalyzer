<?php
// set our own page header for json...
header('Content-Type: application/json' );

// hardcode the URL endpoint
$url = 'http://72.11.254.102';

// hardcode valence setting?
$valence = 'Generic';

// set up the different scoreTypes we want to process
$scoreTypes = array(
  'detailedScore',
  'wordCloudScore',
  'movingAverage30Score'
);

// create an empty array for holding our results
$results = array();

// look for txt to process
$txt = '';
if ( !isset( $_POST['t'] ) ) {
  echo json_encode( array('error' => 'no txt = no checking...' ) );
  die;
} else {
  $txt = $_POST['t'];
  // #todo SANITIZE?!
  $txt = preg_replace("/[\r\n]+/", " ", $txt );
}
/*
$results['t'] = $txt;
echo json_encode($results);
die;
*/
if ( !function_exists( 'curl_init' ) ) {
  echo json_encode( array('error' => 'curl must be enabled to make this work' ) );
  die;
} // else...

// OK, magic! we need to make 1 "API" POST call for Each of the scoreTypes
foreach ( $scoreTypes as $sc ) {

$data = array(
  'ID' => '123ABC',
  'user' => 'ninthlink',
  'scoreType' => $sc,
  'valenceSetting' => $valence,
  'text' => $txt
);
$data_str = json_encode( $data );

//$flatstr = 'ID=123ABC&user=ninthlink&scoreType='. $sc .'&valenceSetting='. $valence .'&text='. $txt;
//echo $flatstr;
//echo "\n\n";
// init curl...
$ch = curl_init();

// point to our endpoint url
curl_setopt( $ch, CURLOPT_URL, $url );

// set PORT number 9000
curl_setopt( $ch, CURLOPT_PORT, 9000 );

// set a couple more CURLOPTs
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

// set POST
curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $data_str );

// set HTTPHeader
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Content-Length: '. strlen( $data_str )
) );

//echo 'curling...' ."\n\n";

//print_r( $report );

$result[ $sc ] = curl_exec( $ch );

$report = curl_getinfo( $ch );
$result[ 'getinfo'. $sc ] = $report;

curl_close( $ch );

//print_r( $result );
}

// now $result should be an array of json arrays of results by scoreTypes, so
echo json_encode( $result );

// and then?
?>
