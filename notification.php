<?php

$decoded_params = [];

// Option 1: Receive JSON parameters from the calling URL
function isValidJSON($str) {
    json_decode($str);
    return json_last_error() == JSON_ERROR_NONE;
 }
 
 $json_params = file_get_contents("php://input");
 
 if (strlen($json_params) > 0 && isValidJSON($json_params))
   $decoded_params = json_decode($json_params, true);

// Option 2: If your are using Laravel, grab $decoded_params from Request $rquest instance as follows
// $decoded_params = $request->all();

// Confirming Logic
// Search for an associated stored payment request (e.g. invoice / contribution) using;  $decoded_params['body']['result']['referenceNumber']
// Compare the associated stored payment request using; $decoded_params['body']['result']['transactionNumber'] == {local payment request/invoice number} && $decoded_params['body']['result']['resultCode'] === '0'

header('Content-type: application/json');

echo json_encode([
    'success' => true, 
    'status' => $decoded_params['body']['result']['resultStatus'],
    'message' => 'Callback received successfully',
]);

?>