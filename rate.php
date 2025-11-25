<?php

// This php file receives the data from the ratingscript.js file and stores the data witin a phpMyAdmin database.   
require 'ratingfunctions.php';
$mysqli = connect();

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['userReview']) || !isset($data['rating'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
    exit;
}

$userReview = $userReview['userReview'];
$rating = $data['rating'];

// to query databse
$stmt = $mysqli->prepare("INSERT INTO ratings (movie_id, rating) VALUES (?, ?)");

$stmt->bind_param("ii", $userReview, $rating); 

// Execute the statement
if ($stmt->execute()) {
    echo json_encode([
    'status' => 'success',
    'message' => 'Rating saved.'
    ]);

} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to save rating.']);
}