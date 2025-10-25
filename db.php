<?php
    $server = "localhost";
    $user = "root";
    $password = "";
    $dbname = "my_php_db";

    $conn = new mysqli($server, $user, $password, $dbname,3307);
    if(!$conn){
        echo "Error: {$conn->connect_error}";
    }

?>
