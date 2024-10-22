<?php
    //Connect to database
    $conn = new mysqli('localhost', 'root', '', 'fcom');

    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $weekNumber = $_GET['week'];

    //Query to fetch meetings for the specified week
    $sql = "SELECT * FROM meetings WHERE week_number = $weekNumber";
    $result = $conn->query($sql);

    $meetings = array();

    if ($result->num_rows > 0){
        while($row = $result -> fetch_assoc()){
            $meetings[] = array(
                            'title' => $row['title'],
                            'date' => $row['date'],
                            'time' => $row['time'],
                            'attendees' => explode(',', $row['attendees'])
            );
        }
    }

    echo json_encode($meetings);
    $conn -> close();
?>