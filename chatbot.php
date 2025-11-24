<?php
// chatbot.php – backend for Course Assistant using Groq (Llama 3.3 70B)

header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1) Get user message
$userMessage = $_POST['message'] ?? '';

if (trim($userMessage) === '') {
    echo json_encode(['reply' => 'Please type a message.']);
    exit;
}

// 2) Groq API key (gsk_...)
$apiKey = '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';

// 3) Groq Chat Completions endpoint
$apiUrl = 'https://api.groq.com/openai/v1/chat/completions';

// 4) Request payload
$payload = [
    "model" => "llama-3.3-70b-versatile",
    "messages" => [
        [
            "role" => "system",
            "content" => "You are a friendly assistant for a course enquiry website. 
                          Answer briefly and clearly, and help with courses, enquiries, and basic questions."
        ],
        [
            "role" => "user",
            "content" => $userMessage
        ]
    ],
    "temperature" => 0.6,
    "stream" => false
];

// 5) cURL call to Groq
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($ch);

if ($response === false) {
    $error = curl_error($ch);
    curl_close($ch);
    echo json_encode(['reply' => 'Error contacting AI server: ' . $error]);
    exit;
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode < 200 || $httpCode >= 300) {
    echo json_encode(['reply' => 'Groq API error. HTTP status: ' . $httpCode . ' (check key / model / account).']);
    exit;
}

// 6) Decode response
$data = json_decode($response, true);
$reply = $data['choices'][0]['message']['content'] ?? 'Sorry, I could not generate a response.';

echo json_encode(['reply' => $reply]);
