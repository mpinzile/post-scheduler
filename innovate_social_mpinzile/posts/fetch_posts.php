<?php
require_once('../inc/connection.php');
date_default_timezone_set('Africa/Nairobi');

// Assuming you have a database connection established
// $connection = mysqli_connect("host", "username", "password", "database");

// Retrieve all posts from the database
$query = "SELECT p.*, u.username FROM posts p 
          INNER JOIN users u ON p.user_id = u.user_id 
          ORDER BY p.post_date DESC, p.post_time DESC";
$result = mysqli_query($connection, $query);

$posts = [];
while ($row = mysqli_fetch_assoc($result)) {
    $posts[] = $row;
}

// Function to calculate the time elapsed since the post was created
function timeElapsed($datetime) {
    $now = new DateTime();
    $postTime = new DateTime($datetime);
    $interval = $now->diff($postTime);
    
    if ($interval->y > 0) {
        return $interval->format('%y years ago');
    } elseif ($interval->m > 0) {
        return $interval->format('%m months ago');
    } elseif ($interval->d > 0) {
        return $interval->format('%d days ago');
    } elseif ($interval->h > 0) {
        return $interval->format('%h hours ago');
    } elseif ($interval->i > 0) {
        return $interval->format('%i minutes ago');
    } else {
        return 'Just now';
    }
}

// Generate HTML for the fetched posts or a message if no posts are available
$output = '';
if (count($posts) > 0) {
    foreach ($posts as $post) {
        $output .= '
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <img src="' . $post['image'] . '" class="card-img-top" alt="Post Image">
                    <div class="card-body">
                        <h5 class="card-title">' . $post['title'] . '</h5>
                        <p class="card-text">' . $post['description'] . '</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <small class="text-muted">
                            <i class="far fa-user"></i> ' . $post['username'] . ' &nbsp;&nbsp;
                            <i class="far fa-clock"></i> ' . timeElapsed($post['post_date'] . ' ' . $post['post_time']) . '
                        </small>
                    </div>
                </div>
            </div>';
    }
} else {
    $output = '
        <div class="col-md-12 text-center">
            <p style="font-size: 24px; color: #999;"><i class="fas fa-exclamation-circle"></i> No posts available.</p>
        </div>';
}

echo $output;
?>
