<?php
session_start();
require_once('../inc/connection.php');
date_default_timezone_set('Africa/Nairobi');

if (!isset($_SESSION['username'])) {
    header("Location: ../login");
    exit();
}

$username = $_SESSION['username'];

$userQuery = "SELECT user_id FROM users WHERE username = ?";
$stmt = $connection->prepare($userQuery);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
$user_id = $userData['user_id'];
$stmt->close();

// Retrieve user's posted posts
$postsQuery = "SELECT * FROM posts WHERE user_id = ?";
$stmt = $connection->prepare($postsQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$postsResult = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<!-- Header Section -->
<header class="bg-primary text-white text-center py-3">
    <h1 class="display-5">Manage Your Posts</h1>
</header>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <?php if ($postsResult->num_rows > 0) : ?>
                <?php while ($post = $postsResult->fetch_assoc()) : ?>
                    <div class="card mb-3">
                        <img src="<?php echo $post['image']; ?>" class="card-img-top" alt="Post Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $post['title']; ?></h5>
                            <p class="card-text"><?php echo $post['description']; ?></p>
                            <p class="card-text">Posted on <?php echo $post['post_date']; ?> at <?php echo $post['post_time']; ?></p>
                            <div class="btn-group">
                                <a href="#" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                <a href="#" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="alert alert-info" role="alert">
                    You do not have any posts yet. <a href="create_post.php">Create a new post</a>.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
