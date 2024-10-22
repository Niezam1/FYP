<?php
    // header('Content-Type: application/json');

    // //Starting session
    // session_start();

    // // Enable all error reporting during development
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    
    // //Retrieving user ID from session
    // $user_id = $_SESSION['user_id'];

    //  if (!isset($_SESSION['user_id'])) {
    //     header('location:login.php');
    //     exit;
    // }

    // //Database credentials
    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $dbname = "fcom";

    // //Get the JSON input 
    // $input = file_get_contents('php://input');
    // $data = json_decode($input, true);

    // //Check if data is present
    // if(!isset($data['cellId']) || !isset($data['availability']) || !isset($data['week']) || !isset($data['available_day']) || !isset($data['available_time'])){
    //     echo json_encode(['success' => false, 'message' => 'Invalid input']);
    //     exit;
    // }

    // $cellId = intval($data['cellId']);
    // $availability = $data['availability'];
    // $week = intval($data['week']);
    // $available_day = $data['available_day'];
    // $available_time = intval($data['available_time']);

    // //Validate availability
    // $validAvailabiltiy = ['Free', 'NotFree', 'Classes'];
    // if(!in_array($availability, $validAvailabiltiy)){
    //     echo json_encode(['success' => false, 'message' => 'Invalid input']);
    //     exit;
    // }

    // //Connect to the database
    // $conn = new mysqli($servername, $username, $password, $dbname);

    // //Check connection
    // if($conn->connect_error){
    //     echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    //     exit;
    // }

    // //Determine the table based on availability
    // $table = '';
    // switch($availability){
    //     case 'Free':
    //         $table = 'free';
    //         break;
    //     case 'NotFree':
    //         $table = 'notfree';
    //         break;
    //     case 'Classes':
    //         $table = 'classes';
    //         break;
    //     default:
    //         echo json_encode(['success' => false, 'message' => 'Invalid availability']);
    //         exit;
    // }

    // // Fetch user_name and user_email from the 'userinfo' table
    // $stmt = $conn->prepare("SELECT user_name, user_email FROM `userinfo` WHERE user_id = ?");
    // $stmt->bind_param("i", $user_id);
    // $stmt->execute();
    // $result = $stmt->get_result();

    // if ($result->num_rows > 0) {
    //     // Fetch the row
    //     $row = $result->fetch_assoc();
    //     $user_name = $row['user_name'];
    //     $user_email = $row['user_email'];

    //     // Insert into the appropriate table
    //     $stmt_insert = $conn->prepare("INSERT INTO `$table` (${table}_time, ${table}_day, ${table}_week, user_name, user_email, cell_id) VALUES (?, ?, ?, ?, ?, ?)");
    //     $stmt_insert->bind_param("isisis", $available_time, $available_day, $week, $user_name, $user_email, $cellId);

    //     if ($stmt_insert->execute()) {
    //         echo json_encode(['success' => true, 'message' => 'Data inserted successfully']);
    //     } else {
    //         echo json_encode(['success' => false, 'message' => 'Insert failed']);
    //     }

    //     $stmt_insert->close();
    // } else {
    //     echo json_encode(['success' => false, 'message' => 'User not found']);
    // }

    // // Debugging - Log received data
    // error_log(print_r($data, true));

    // $stmt->close();
    // $conn->close();
?>