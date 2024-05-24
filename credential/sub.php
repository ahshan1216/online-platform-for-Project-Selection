<?php
// Start the session
session_start();
include '../database.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email' AND password='$password'";
    $result = mysqli_query($connection, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $student_id = $row['student_id'];
        $teacher_id = $row['teacher_id'];
        $super_admin = $row['student_id'];
        $master_admin = $row['student_id'];
        $verify= $row['verify'];
        
        $role= $row['role'];

        if($role == 'student')
    {
        $_SESSION['student_id'] = $student_id;
        $_SESSION['role'] = $role;
        $_SESSION['verify'] = $verify;
        header("Location: ../student_dashboard/");
        exit();
       
    }

    else if( $role == 'faculty')
    {
        $_SESSION['teacher_id'] = $teacher_id;
        $_SESSION['role'] = $role;
        $_SESSION['verify'] = $verify;
        header("Location: ../faculty_dashboard/");
        exit();
       
    }
    else if($role == 'super_admin')
    {
        $_SESSION['super_admin'] = $super_admin;
        $_SESSION['role'] = $role;
        $_SESSION['verify'] = $verify;
        header("Location: ../moderator/");
        exit();
    }
    else if($role == 'master_admin')
    {
        $_SESSION['master_admin'] = $master_admin;
        $_SESSION['role'] = $role;
        $_SESSION['verify'] = $verify;
        header("Location: ../master_admin/");
        exit();
    }

    else
    {
        $_SESSION['admin'] = $teacher_id;
        $_SESSION['role'] = $role;
        $_SESSION['verify'] = $verify;
        header("Location: ../head_admin_dashboard/");
        exit();
       
    }
       
    }

    else
    {
        echo '<style>
        .error-message {
            background-color: #f8d7da; /* Light red background color */
            color: #721c24; /* Dark red text color */
            padding: 10px 15px; /* Padding around the message */
            border: 1px solid #f5c6cb; /* Border around the message */
            border-radius: 5px; /* Rounded corners */
            margin-bottom: 20px; /* Bottom margin to separate it from other elements */
            font-size: 16px; /* Font size */
            font-weight: bold; /* Bold text */
        }
        .centered-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
        
        .icon-container {
            display: inline-block;
            background-color: red;
            border-radius: 50%;
            padding: 20px;
        }
        
        .question-mark {
            font-size: 60px;
            color: white;
            font-weight: bold;
            line-height: 1;
        }
        
        .message {
            margin-top: 20px;
            font-size: 24px;
            color: red;
            font-weight: bold;
        }
        
    </style>';
        echo '<div class="centered-message">
        <div class="icon-container">
            <span class="question-mark">?</span>
        </div>
        <div class="message">
            Email and password Wrong Or Account Not Exist
        </div>
        <div id="countdown">Redirecting in 6 seconds...</div>
    </div>
    ';

    echo '<script>
    // Countdown timer
    var seconds = 6;
    var countdownElement = document.getElementById("countdown");

    function countdown() {
        seconds--;
        countdownElement.textContent = "Redirecting in " + seconds + " seconds...";
        if (seconds <= 0) {
            clearInterval(timer);
            // Redirect to another website
            window.location.href = "signin.php";
        }
    }

    // Start countdown
    var timer = setInterval(countdown, 1000);
</script>';
    }

    

    // Example of storing user data in session variables
    


    // Redirect the user after successful login
   
} else {
    // Redirect or display an error if the form was not submitted via POST
    echo "Form submission method not allowed";
}
?>
