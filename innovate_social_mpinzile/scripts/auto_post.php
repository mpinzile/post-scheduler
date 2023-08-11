<?php
require_once('../inc/connection.php');
date_default_timezone_set('Africa/Nairobi');

// Fetch reserved posts that need to be posted
$reservedPostsQuery = "SELECT * FROM reserved_posts WHERE post_date <= CURDATE() AND post_time <= CURTIME() AND posted = 'False'";
$reservedPostsResult = $connection->query($reservedPostsQuery);

while ($reservedPost = $reservedPostsResult->fetch_assoc()) {
    $user_id = $reservedPost['user_id'];
    $title = $reservedPost['title'];
    $description = $reservedPost['description'];
    $image = $reservedPost['image'];
    $post_time = $reservedPost['post_time'];
    $post_date = $reservedPost['post_date'];

    // Insert the reserved post into the 'posts' table
    $insertQuery = "INSERT INTO posts (user_id, title, description, image, post_time, post_date) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($insertQuery);
    $stmt->bind_param("isssss", $user_id, $title, $description, $image, $post_time, $post_date);
    $stmt->execute();

    // Delete the reserved post
    $deleteQuery = "DELETE FROM reserved_posts WHERE reserve_id = ?";
    $deleteStmt = $connection->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $reservedPost['reserve_id']);
    $deleteStmt->execute();
}

$connection->close();
?>
