<?php
    define("SERVERNAME", "localhost");
    define("USERNAME", "root");
    define("USERPASSWORD", "");
    define("DATABASENAME", "innovatesocial");

    $connection = new mysqli(SERVERNAME, USERNAME, USERPASSWORD, DATABASENAME);

    if ($connection->connect_error) {
        die('Connection Failed: ' . $connection->connect_error);
    }
?>
