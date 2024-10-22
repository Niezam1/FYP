<?php
    $conn = new mysqli('localhost', 'root', '', 'fcom');

    if ($conn->connect_error){
        die("Connection Failed: " . $conn->connect_error);
    }
?>