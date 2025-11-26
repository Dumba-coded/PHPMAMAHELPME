<?php
function connect() {
    $host = "localhost"; 
    $user = "root";
    $pass = "";
    $dbname = "reviewpage";
    $charset = "utf8mb4";

    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    return new PDO($dsn, $user, $pass, $options);
}

function getData(){
    $pdo = connect();
    $stmt = $pdo->query("
        SELECT 
            m.id,
            m.title,
            AVG(r.rating) as avg_rating,
            COUNT(r.id) as vote_count
        FROM movies m
        LEFT JOIN ratings r ON m.id = r.user_review
        GROUP BY m.id, m.title
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
