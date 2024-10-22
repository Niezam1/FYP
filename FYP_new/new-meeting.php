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
        <title>New Meeting</title>
        <link rel="stylesheet" href="./css/Home.css">

        <style type="text/css">
            .hamburger-pic {
                cursor: pointer;
                width: 40px;
                margin: 10px;
            }

            #sidebar {
                position: fixed;
                top: 0;
                left: -250px;
                width: 250px;
                height: 100%;
                background-color: #333;
                color: white;
                transition: left 0.3s ease;
                z-index: 1000;
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

            .content_container{
                display:flex;
                flex-direction:column;
                flex-wrap:wrap;
                align-items: center;
                width:100%;
                min-height:850px;
            }

            .form{
                margin-top:410px;
            }

            .form input, textarea{
                border:1px solid black;
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
                    <li><a href="dean_index.php">Home</a></li>
                    <li><a href="dean_meeting.php">Meeting</a></li>
                    <li><a href="dean_search.php">Search</a></li>
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
                    <li><a href="dean_search.php">Search</a></li>
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

        <div class="content_container">
            <div class="timetable">
                <div class="week">
                    <i class="fa fa-angle-left prev" onclick="changeWeek(-1)"></i>
                    <div class="date" id="weekNumber">Week 1</div>
                    <i class="fa fa-angle-right next" onclick="changeWeek(1)"></i>
                </div>
                <div class="timetable-container" id="timetableContent">
                    <!--Timetable header cells-->
                    <div class="blank-cell" id="blank"></div>
                    <div>8<br>8:00-9:00</div>
                    <div>9<br>9:00-10:00</div>
                    <div>10<br>10:00-11:00</div>
                    <div>11<br>11:00-12:00</div>
                    <div>12<br>12:00-1:00</div>
                    <div>1<br>1:00-2:00</div>
                    <div>2<br>2:00-3:00</div>
                    <div>3<br>3:00-4:00</div>
                    <div>4<br>4:00-5:00</div>
                    <div>5<br>5:00-6:00</div>
                    <div>6<br>6:00-7:00</div>

                    <!-- Timetable for each day -->
                    <div class="day">Mo</div>
                    <div class="day" id="1" onclick="showDialog(1)" data-hidden-value="Monday-8"></div>
                    <div class="day" id="2" onclick="showDialog(2)" data-hidden-value="Monday-9"></div>
                    <div class="day" id="3" onclick="showDialog(3)" data-hidden-value="Monday-10"></div>
                    <div class="day" id="4" onclick="showDialog(4)" data-hidden-value="Monday-11"></div>
                    <div class="day" id="5" onclick="showDialog(5)" data-hidden-value="Monday-12"></div>
                    <div class="day" id="6" onclick="showDialog(6)" data-hidden-value="Monday-1"></div>
                    <div class="day" id="7" onclick="showDialog(7)" data-hidden-value="Monday-2"></div>
                    <div class="day" id="8" onclick="showDialog(8)" data-hidden-value="Monday-3"></div>
                    <div class="day" id="9" onclick="showDialog(9)" data-hidden-value="Monday-4"></div>
                    <div class="day" id="10" onclick="showDialog(10)" data-hidden-value="Monday-5"></div>
                    <div class="day" id="11" onclick="showDialog(11)" data-hidden-value="Monday-6"></div>
                    <div class="day">Tu</div>
                    <div class="day" id="12" onclick="showDialog(12)" data-hidden-value="Tuesday-8"></div>
                    <div class="day" id="13" onclick="showDialog(13)" data-hidden-value="Tuesday-9"></div>
                    <div class="day" id="14" onclick="showDialog(14)" data-hidden-value="Tuesday-10"></div>
                    <div class="day" id="15" onclick="showDialog(15)" data-hidden-value="Tuesday-11"></div>
                    <div class="day" id="16" onclick="showDialog(16)" data-hidden-value="Tuesday-12"></div>
                    <div class="day" id="17" onclick="showDialog(17)" data-hidden-value="Tuesday-1"></div>
                    <div class="day" id="18" onclick="showDialog(18)" data-hidden-value="Tuesday-2"></div>
                    <div class="day" id="19" onclick="showDialog(19)" data-hidden-value="Tuesday-3"></div>
                    <div class="day" id="20" onclick="showDialog(20)" data-hidden-value="Tuesday-4"></div>
                    <div class="day" id="21" onclick="showDialog(21)" data-hidden-value="Tuesday-5"></div>
                    <div class="day" id="22" onclick="showDialog(22)" data-hidden-value="Tuesday-6"></div>
                    <div class="day">We</div>
                    <div class="day" id="23" onclick="showDialog(23)" data-hidden-value="Wednesday-8"></div>
                    <div class="day" id="24" onclick="showDialog(24)" data-hidden-value="Wednesday-9"></div>
                    <div class="day" id="25" onclick="showDialog(25)" data-hidden-value="Wednesday-10"></div>
                    <div class="day" id="26" onclick="showDialog(26)" data-hidden-value="Wednesday-11"></div>
                    <div class="day" id="27" onclick="showDialog(27)" data-hidden-value="Wednesday-12"></div>
                    <div class="day" id="28" onclick="showDialog(28)" data-hidden-value="Wednesday-1"></div>
                    <div class="day" id="29" onclick="showDialog(29)" data-hidden-value="Wednesday-2"></div>
                    <div class="day" id="30" onclick="showDialog(30)" data-hidden-value="Wednesday-3"></div>
                    <div class="day" id="31" onclick="showDialog(31)" data-hidden-value="Wednesday-4"></div>
                    <div class="day" id="32" onclick="showDialog(32)" data-hidden-value="Wednesday-5"></div>
                    <div class="day" id="33" onclick="showDialog(33)" data-hidden-value="Wednesday-6"></div>
                    <div class="day">Th</div>
                    <div class="day" id="34" onclick="showDialog(34)" data-hidden-value="Thursday-8"></div>
                    <div class="day" id="35" onclick="showDialog(35)" data-hidden-value="Thursday-9"></div>
                    <div class="day" id="36" onclick="showDialog(36)" data-hidden-value="Thursday-10"></div>
                    <div class="day" id="37" onclick="showDialog(37)" data-hidden-value="Thursday-11"></div>
                    <div class="day" id="38" onclick="showDialog(38)" data-hidden-value="Thursday-12"></div>
                    <div class="day" id="39" onclick="showDialog(39)" data-hidden-value="Thursday-1"></div>
                    <div class="day" id="40" onclick="showDialog(40)" data-hidden-value="Thursday-2"></div>
                    <div class="day" id="41" onclick="showDialog(41)" data-hidden-value="Thursday-3"></div>
                    <div class="day" id="42" onclick="showDialog(42)" data-hidden-value="Thursday-4"></div>
                    <div class="day" id="43" onclick="showDialog(43)" data-hidden-value="Thursday-5"></div>
                    <div class="day" id="44" onclick="showDialog(44)" data-hidden-value="Thursday-6"></div>
                    <div class="day">Fr</div>
                    <div class="day" id="45" onclick="showDialog(45)" data-hidden-value="Friday-8"></div>
                    <div class="day" id="46" onclick="showDialog(46)" data-hidden-value="Friday-9"></div>
                    <div class="day" id="47" onclick="showDialog(47)" data-hidden-value="Friday-10"></div>
                    <div class="day" id="48" onclick="showDialog(48)" data-hidden-value="Friday-11"></div>
                    <div class="day" id="49" onclick="showDialog(49)" data-hidden-value="Friday-12"></div>
                    <div class="day" id="50" onclick="showDialog(50)" data-hidden-value="Friday-1"></div>
                    <div class="day" id="51" onclick="showDialog(51)" data-hidden-value="Friday-2"></div>
                    <div class="day" id="52" onclick="showDialog(52)" data-hidden-value="Friday-3"></div>
                    <div class="day" id="53" onclick="showDialog(53)" data-hidden-value="Friday-4"></div>
                    <div class="day" id="54" onclick="showDialog(54)" data-hidden-value="Friday-5"></div>
                    <div class="day" id="55" onclick="showDialog(55)" data-hidden-value="Friday-6"></div>
                </div>
            </div>

            <div class="form">
                <form action="" method="POST">
                    <div class="subject-container">
                        <label for="meeting_subject">Meeting Subject : </label>
                        <input type="text" name="meeting_subject" class="text_field" placeholder="Enter meeting subject">
                    </div>

                    <div class="description-container">
                        <label for="meeting_description">Meeting Description : </label>
                        <textarea id="meeting_description" name="meeting_description" class="text_field" rows="8" cols="70" placeholder="Enter meeting description"></textarea>
                    </div>

                    <input type="submit" value="Create">
                </form>
            </div>
        </div>

        <script>
            let subMenu = document.getElementById("subMenu");
            let currentWeek = 1;

            function updateWeekDisplay() {
                document.getElementById('weekNumber').innerText = `Week ${currentWeek}`;
            }

            function toggleHamburger() {
                const sidebar = document.getElementById('sidebar');
                const isOpen = sidebar.style.left === '0px'; // Check if sidebar is open

                // Toggle the sidebar position
                sidebar.style.left = isOpen ? '-250px' : '0px';
            }

            function toggleMenu(){
                subMenu.classList.toggle("open-menu");
            }

            // Change week and update the URL and timetable
            function changeWeek(weekChange) {
                currentWeek += weekChange;

                // Prevent week number from going below 1 or above 14
                if (currentWeek < 1) {
                    currentWeek = 1;
                } else if (currentWeek > 14) {
                    currentWeek = 14;
                }

                // Update the URL with the current week
                const url = new URL(window.location);
                url.searchParams.set('week', currentWeek);
                window.history.pushState({}, '', url);

                // Reload the page to reflect the new week data
                location.reload();
            }

            // Initial page load actions
            window.onload = function() {
                const urlParams = new URLSearchParams(window.location.search);
                const savedWeek = urlParams.get('week'); // Get 'week' from URL
                if (savedWeek) {
                    currentWeek = parseInt(savedWeek, 10);
                } else {
                    currentWeek = 1; // Default to week 1 if no week is in the URL
                }
                updateWeekDisplay(); // Show the saved week
                updateTimetable(); // Load timetable for the current week
            }
        </script>
    </body>
</html>