<?php


require_once("../authentication/linker.php");
date_default_timezone_set('Africa/Nairobi');


error_reporting(E_ALL);


$currentTimestamp = time();
$currentDateTime = date("Y-m-d H:i", $currentTimestamp);
$newCurrentTimestamp = strtotime($currentDateTime);


$mainstream = "SELECT * FROM posts WHERE status = 'Published' ORDER BY post_id DESC";
$resultss = mysqli_query($starlink, $mainstream);
$posts = [];


if (mysqli_num_rows($resultss) >= 1) {
while ($rowss = mysqli_fetch_array($resultss)) {


        $post_name = $rowss['username'];
        $post_email = $rowss['useremail'];
        $post_content = $rowss['post_content'];
        $post_image = $rowss['post_image'];
        $scheduleTime = $rowss['post_time_date'];
        $newScheduleTime = strtotime($scheduleTime);


        $time = $scheduleTime;
        $post = [
            'name' => $post_name,
            'email' => $post_email,
            'content' => $post_content,
            'time' => $time,
            'image' => $post_image
        ];


        $posts[] = $post;
    }
}


echo json_encode($posts);


?>
