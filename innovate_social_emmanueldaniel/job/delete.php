<?php
require_once("../authentication/linker.php");
if(isset($_GET['id'])){
$postids = $_GET['id'];
$sql = "DELETE FROM posts WHERE useremail='$postids' AND status = 'Scheduled'";
$result = $starlink->query($sql);

if ($result) {
        header("location: ../lib/main.php");
}

}
?>