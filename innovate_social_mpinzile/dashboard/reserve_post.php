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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_FILES['image'];
    $postDate = $_POST['post_date'];
    $postTime = $_POST['post_time'];

    // Count the number of words in title and description
    $titleWordCount = str_word_count($title);
    $descriptionWordCount = str_word_count($description);

    if (empty($title) || empty($description) || empty($image['name']) || empty($postDate) || empty($postTime)) {
        $errorMsg = "All fields are required.";
    } elseif ($titleWordCount > 7) {
        $errorMsg = "Title should not have more than 7 words.";
    } elseif ($descriptionWordCount > 25) {
        $errorMsg = "Description should not have more than 25 words.";
    } else {
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $maxFileSize = 0.5 * 1024 * 1024; // 0.5 MB

        $imageExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        if (!in_array($imageExtension, $allowedExtensions)) {
            $errorMsg = "Only JPG, JPEG, and PNG images are allowed.";
        } elseif ($image['size'] > $maxFileSize) {
            $errorMsg = "Image size should not exceed 0.5 MB.";
        } else {
            $currentDateTime = new DateTime();
            $selectedDateTime = new DateTime("$postDate $postTime");

            if ($selectedDateTime <= $currentDateTime) {
                $errorMsg = "Selected date and time must be in the future.";
            } else {
                $uploadDir = '../uploads/';
                $imageName = uniqid() . '.' . $imageExtension;
                $uploadPath = $uploadDir . $imageName;

                if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
                    $insertQuery = "INSERT INTO reserved_posts (user_id, title, description, image, post_time, post_date, posted) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $posted = "False";
                    $stmt = $connection->prepare($insertQuery);
                    $stmt->bind_param("issssss", $user_id, $title, $description, $uploadPath, $postTime, $postDate, $posted);

                    if ($stmt->execute()) {
                        $successMsg = "Post reserved successfully!";
                        header('Refresh:3;url=../dashboard');
                    } else {
                        $errorMsg = "Error reserving post: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    $errorMsg = "Error uploading image.";
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve a Post</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<header class="bg-primary text-white text-center py-3">
    <h1 class="display-5">InnovateSocial</h1>
    <p class="lead">Reserve a post and schedule it for future posting.</p>
</header>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php if (isset($errorMsg)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $errorMsg; ?>
                </div>
            <?php endif; ?>
            <?php if (isset($successMsg)) : ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $successMsg; ?>
                </div>
            <?php endif; ?>
            <form enctype="multipart/form-data" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" autocomplete="off">
                <div class="form-group">
                    <label for="title">Title (max 7 words)</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description (max 25 words)</label>
                    <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image (JPG/PNG, max 0.5 MB)</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image" accept="image/jpeg, image/png" required>
                        <label class="custom-file-label" for="image">Choose file...</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="post_date">Post Date</label>
                    <input type="date" class="form-control" id="post_date" name="post_date" required>
                </div>
                <div class="form-group">
                    <label for="post_time">Post Time</label>
                    <input type="time" class="form-control" id="post_time" name="post_time" required>
                </div>
                <button type="submit" class="btn btn-primary" name="reserve_post">Reserve Post</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
