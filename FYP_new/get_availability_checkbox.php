<?php

include 'config.php';

// Starting session
session_start();
$user_id = $_SESSION['user_id'];

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['week']) && isset($_GET['check'])) {
    $currentWeek = intval($_GET['week']);
    
    // Handle selected checkboxes (user IDs)
    $userchecked = $_GET['check']; // this is an array of selected user IDs
    $userIds = implode(",", array_map('intval', $userchecked)); // Convert array to comma-separated string

    $response = ['success' => false, 'data' => []];

    // Query to get availability based on the week and selected users
    $query = "SELECT CellNo, availability, user_Id FROM timetable WHERE `Week` = '$currentWeek' AND `user_Id` IN ($userIds)";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $response['success'] = true;
        while ($row = mysqli_fetch_assoc($result)) {
            // Store the data for each user and cell
            $response['data'][] = [
                'cellNo' => $row['CellNo'],
                'availability' => $row['availability'],
                'userId' => $row['user_Id']
            ];
        }
    } else {
        $response['message'] = "No data found for week $currentWeek";
    }

    echo json_encode($response);
}
?>
