<?php
header("Content-Type: application/json");

require 'ratingfunctions.php';
$pdo = connect();

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['userReview']) || !isset($data['rating'])) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid data provided.'
    ]);
    exit;
}

$userReview = $data['userReview'];
$rating = $data['rating'];

try {
    $stmt = $pdo->prepare("INSERT INTO ratings (userReview, rating) VALUES (?, ?)");
    $stmt->execute([$userReview, $rating]);

    $stmt = $pdo->prepare("

    SELECT
        AVG(rating) as avg_rating,
        COUNT(id) as votecount
    
    FROM
        ratings
    
    WHERE
        user_Review = ?

    ");

    $stmt->execute([$userReview]);
    $newRating = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'message' => 'Rating saved successfully.',
        'newAverage' => round($newRating['avg_rating'] ?? 0,2),
        'newCount' => (int)($newRating['vote_count'] ?? 0),
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
