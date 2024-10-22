<?php
include 'config.php';
// Starting session
session_start();
$user_id = $_SESSION['user_id'];

if (isset($_POST['submit'])) {

    // Retrieve POST data
    $table_selected = $_POST['availability'];
    $table_time = $_POST['hidden_time'];
    $table_day = $_POST['hidden_day'];
    $table_week = $_POST['hidden_week'];
    $cell_id = $_POST['hidden_cellId'];


    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO `timetable` (`CellNo`, `Day`, `Time`, `Week`, `availability`, `User_id`) VALUES (?, ?, ?, ?, ?, ?)");

    // Check if prepare failed then display error messages
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }


    $stmt->bind_param('isiisi', $cell_id, $table_day, $table_time, $table_week, $table_selected, $user_id);

    // Execute the statement
    if ($stmt->execute()) {
        //if the insert is success, then redirect to dean index page and alert success message
        echo '
        <script>
            alert("Record inserted successfully!"); 
            window.location.href = "dean_index.php?week=' . $table_week . '";
        </script>';

    } else {
        die('Query failed: ' . htmlspecialchars($stmt->error));
    }

    // Close the statement
    $stmt->close();
}

$conn->close();
