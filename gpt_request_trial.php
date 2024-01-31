<?php
require_once('db.php');
/**
 * Here we are creating a sample program to feed a portion of our data into GPT and query the data with GPT on top of it.
 * We are feeding three columns of the first 500 rows (with non-null values in the three columns) into GPT.
 */
$query = "SELECT * FROM defaultdb.VCFinderFunds WHERE recordID < 500 AND Email is NOT NULL AND Country is NOT NULL";
$result = mysqli_query($con, $query);
$tableData = "";
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $tableData .= "Email: " . $row['Email'] . ", Country: " . $row['Country'] . "; "; // Adjust according to your table structure
    }
    $result->free();
}
$guidingMessage = "The user will ask you some questions about Venture Capital. Attempt to answer their questions. ";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set the content type to JSON
header('Content-Type: application/json');

// Get the JSON POSTed by the JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// The user message from the frontend
$userMessage = $data['message'];

$fullPrompt = $guidingMessage . "\nUser Message: " . $userMessage . "\nTable Data: " . $tableData;


// Removed OpenAI API Key. 
$apiKey = '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';

// OpenAI API URL
$apiUrl = 'https://api.openai.com/v1/completions';

// Prepare the data for the API request
$postData = [
    'model' => 'gpt-3.5-turbo-instruct',
    'prompt' => $fullPrompt,
    'temperature' => 0.7,
    'max_tokens' => 300,
    'top_p' => .8,
    'frequency_penalty' => 0,
    'presence_penalty' => 0,
    //'stream' => true
];

// Setup cURL
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

// Execute the request and fetch the response
$response = curl_exec($ch);
if (curl_errno($ch)) {
    // Log cURL error
    error_log('cURL error: ' . curl_error($ch));
}
curl_close($ch);

// Decode the response
$responseData = json_decode($response, true);
error_log(print_r($responseData, true));


// Extract the reply (you might need to adjust this depending on the response structure)
$reply = $responseData['choices'][0]['text'];

// Send the response back to the JavaScript
echo json_encode(['reply' => $reply]);
?>