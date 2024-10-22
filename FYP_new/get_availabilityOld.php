<?php
// get_availability.php

    header('Content-Type: application/json');

    // Start session
    session_start();

    // Database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "fcom";

    // Check if the user is logged in
    if(!isset($_SESSION['user_id'])){
        header('location:login.php');
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // Get the week from the query parameter
    if(!isset($_GET['week'])){
        echo json_encode(['success' => false, 'message' => 'Week not specified']);
        exit;
    }

    $week = intval($_GET['week']);

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
    }

    // List of tables representing different availability statuses
    $tables = ['free' => 'Free', 'notfree' => 'NotFree', 'classes' => 'Classes'];
    $availabilityData = [];

    foreach ($tables as $tableName => $availabilityType) {
        $stmt = $conn->prepare("SELECT cell_id FROM $tableName WHERE week = ? AND user_id = ?");
        if(!$stmt){
            continue; // Skip if prepare fails
        }
        $stmt->bind_param("ii", $week, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()){
            $cellId = $row['cell_id'];
            $availabilityData[$cellId] = $availabilityType; // Store availability type
        }
        $stmt->close();
    }

    echo json_encode(['success' => true, 'data' => $availabilityData]);

    $conn->close();
?>
