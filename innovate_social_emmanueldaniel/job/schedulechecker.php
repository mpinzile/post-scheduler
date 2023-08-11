<?php
//timzone
date_default_timezone_set('Africa/Nairobi');

// database connection
require_once('/Applications/XAMPP/xamppfiles/htdocs/innovatesocial/authentication/linker.php');
error_reporting(E_ALL);

// Querying the database for scheduled posts whose date and time have passed
$currentTimestamp = time();
$currentDateTime = date("Y-m-d H:i", $currentTimestamp);
$newCurrentTimestamp = strtotime($currentDateTime);



$query = "SELECT * FROM posts WHERE status='Scheduled'";

$result = mysqli_query($starlink, $query);

if (mysqli_num_rows($result) >= 1) {
    while ($row = mysqli_fetch_array($result)) {

        $postId = $row['post_id'];
        $scheduleTime = $row['post_time_date'];
        $newScheduleTime = strtotime($scheduleTime);

        if ($newScheduleTime <= $newCurrentTimestamp) {

       $updateQuery = "UPDATE posts SET status='Published' WHERE post_id=$postId";
        mysqli_query($starlink, $updateQuery);
        }
    }
}

?>