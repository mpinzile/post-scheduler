<?php
session_start();
session_destroy();
header("location: ../lib/main.php");
?>