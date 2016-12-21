<?php
// set our own page header for json...
header('Content-Type: application/json' );

// hardcode the URL endpoint
$url = 'http://72.11.254.102';

if ( !function_exists( 'curl_init' ) ) {
  echo json_encode( array('error' => 'curl must be enabled to make this work' ) );
  die;
} // else...

$txt = '';
if ( !isset( $_REQUEST['txt'] ) ) {
  echo json_encode( array('error' => 'no txt = no checking...' ) );
  die;
} else {
  $txt = $_REQUEST['txt'];
  // #todo SANITIZE?!
}

$data = array(
  'ID' => '123ABC',
  'user' => 'ninthlink',
  'scoreType' => 'basicScore',
  'valenceSetting' => 'Generic',
  'text' => $txt
);
$data_str = json_encode( $data );
//echo $data_str;

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

//$report = curl_getinfo( $ch );
//print_r( $report );

$result = curl_exec( $ch );
curl_close( $ch );

//print_r( $result );
echo $result;


?>
