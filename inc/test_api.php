<?php 

$response = array(
    'success' => true,
    'challenge_ts' => '2016-09-27T23:25:57Z',
    'hostname' => 'localhost',
    'error-codes' => array('missing-input-response','invalid-input-secret'),
);

echo json_encode( $response );

?>