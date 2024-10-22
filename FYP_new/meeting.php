<?php
    //Connect to the database server
    include 'config.php';

    // Enable all error reporting during development
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //Starting session
    session_start();
    
    //Retrieving user ID from session
    $user_id = $_SESSION['user_id'];
    
    if(!isset($user_id)){
        header('Location: login.php');
        exit();
    }else{
        //Set a cookies that expires in 2 hours
        $cookie_name = "user_id";
        $cookie_value = $user_id;
        $expire_time = time() + (2 * 60 * 60); //Current time + 2 hours

        setcookie($cookie_name, $cookie_value, $expire_time, "/"); //Set the cookie
    }
?>

<!DOCTYPE HTML>
<html lang="en">
    <head></head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>This Week</title>
        <link rel="stylesheet" href="Home.css">

        <style type="text/css">
            .hamburger-pic {
                cursor: pointer;
                width: 40px; /* Adjust size as needed */
                margin: 10px; /* Adjust positioning as needed */
            }

            #sidebar {
                position: fixed;
                top: 0;
                left: -250px; /* Hide off-screen */
                width: 250px;
                height: 100%;
                background-color: #333; /* Sidebar background color */
                color: white;
                transition: left 0.3s ease; /* Transition for smooth slide-in */
                z-index: 1000; /* Ensure it's in front of other elements */
            }

            .sidebar-content {
                padding: 20px;
            }
            
            .sidebar h2 {
                margin: 0;
                font-size: 24px;
            }

            .sidebar ul {
                list-style-type: none;
                padding: 0;
            }

            .sidebar ul li {
                margin: 15px 0;
            }

            .sidebar ul li a {
                color: white;
                text-decoration: none;
            }

            .sidebar .closebtn {
                background: none;
                border: none;
                color: white;
                font-size: 30px;
                cursor: pointer;
                position: absolute;
                top: 10px;
                right: 20px;
            }

            .meeting-week{
                display:flex;
                align-items:center;
                justify-content:space-between;
                border-bottom:2px solid black;
                width:50%;
                height:50px;
                margin-right:auto;
                margin-left:auto;
                padding:0 50px;
            }

            .meeting-week .prev,
            .meeting-week .next{
                cursor:pointer;
            }

            .sub-menu-wrap{
                position: fixed;
                top: 9%;
                right: -1%;
                width: 320px;
                max-height: 0px;
                overflow: hidden;
                transition: max-height 0.5s;
                z-index: 2000;
            }

            .sub-menu-wrap.open-menu{
                max-height: 400px;
            }

            .sub-menu{
                background: #018fd1;
                padding: 20px;
                margin: 10px;
                border-bottom-right-radius: 16px;
                border-bottom-left-radius: 16px;
            }

            .user-info{
                display: flex;
                align-items: center;
            }

            .user-info h3{
                font-weight: 500;
                font-family: "Poppins", sans-serif;
                color:rgb(214, 226, 232);
            }

            .user-info img{
                width: 60px;
                border-radius: 50%;
                margin-right: 15px;
            }

            .sub-menu hr{
                border: 0;
                height: 1px;
                width: 100%;
                background: #ccc;
                margin: 15px 10px;
            }

            .sub-menu-link{
                display: flex;
                align-items: center;
                text-decoration: none;
                color: #525252;
                margin: 12px 0;
            }

            .sub-menu-link p{
                width: 100%;
            }

            .sub-menu-link:hover p{
                font-weight: 600;
            }
        </style>
    </head>
    <body>
        <header>
            <img style="height:40px;
                        margin-left:10px;
                        cursor:pointer;
                        color:white;"
                        src="images/hamburger_icon.png" class="hamburger-pic" onclick="toggleHamburger()"
            />

            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="meeting.php">Meeting</a></li>
                    <li><a href="search.php">Search</a></li>
                </ul>
            </nav>

            <img style="height:40px; 
                margin-right:10px; 
                cursor:pointer;" 
                src="images/user-icon_master.png" class="user-pic" onclick="toggleMenu()" 
            />
        </header>

        <div id="sidebar" class="sidebar">
            <button class="closebtn" onclick="toggleHamburger()">&times;</button>
            <div class="sidebar-content">
                <h2>Menu</h2>
                <ul>
                    <li><a href="search.php">Search</a></li>
                </ul>
            </div>
        </div>

        <div class="sub-menu-wrap" id="subMenu">
            <div class="sub-menu">
            <!--User Information-->
                <div class="user-info">
                    <img src="images/user-icon_master.png" />
                    <div class="user-info" style="display: block;">
                        <h3>Hello, <?php echo $_SESSION['user_name']?></h3>
                        <h3><?php echo $_SESSION['user_email']?></h3>
                    </div>
                </div>
                <hr />
                <!--Logout link-->
                <a href="logout.php" class="sub-menu-link">
                    <p style="
                        background-color:red; 
                        border-radius:8px; 
                        text-align:center; 
                        color:white; 
                        font-weight:600; 
                        margin-top:5px; 
                        padding:5px;">Logout
                    </p>
                </a>
            </div>
        </div>

        <div class="container">
            <div class="meeting-week">
                <i class="fa fa-angle-left prev" onclick="changeWeek(-1)"></i>
                <h3>Meetings for Week <span id="weekNumber"></span></h3>
                <i class="fa fa-angle-right next" onclick="changeWeek(1)"></i>
            </div>
            <div class="meeting-schedule" id="meetingSchedule">

            </div>
        </div>

        <script>
            let subMenu = document.getElementById("subMenu");
            let currentWeek = parseInt(localStorage.getItem('currentWeek')) || 1;

            function toggleHamburger() {
                const sidebar = document.getElementById('sidebar');
                const isOpen = sidebar.style.left === '0px'; // Check if sidebar is open

                // Toggle the sidebar position
                sidebar.style.left = isOpen ? '-250px' : '0px'; // Adjust according to sidebar width
            }

            function toggleMenu(){
                subMenu.classList.toggle("open-menu");
            }

            window.onload = function(){
                document.getElementById('weekNumber').innerText = currentWeek;

                //Fetch meeting schedules for the current week
                fetchMeetingsForWeek(currentWeek);
            };

            //function to change the week
            function changeWeek(weekChange){
                currentWeek += weekChange;

                //Prevent week number from going below 1
                if (currentWeek < 1){
                    currentWeek = 1;
                }

                if(currentWeek > 14){
                    currentWeek = 14;
                }

                //Save the current week in localStorage
                localStorage.setItem('currentWeek', currentWeek)

                updateWeekDisplay();
            }

            //Update the displayed week number
            function updateWeekDisplay(){
                document.getElementById('weekNumber').innerText = `${currentWeek}`;
            }
        </script>
    </body>
</html>