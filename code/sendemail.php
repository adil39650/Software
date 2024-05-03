<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include PHPMailer classes manually
require 'E:\Xampp\htdocs\Example\PHPMailer-master\src\Exception.php';
require 'E:\Xampp\htdocs\Example\PHPMailer-master\src\PHPMailer.php';
require 'E:\Xampp\htdocs\Example\PHPMailer-master\src\SMTP.php';

// Include database connection
require('db.php');

// Redirect if user is not admin
if(isset($_SESSION['ROLE']) && $_SESSION['ROLE'] != '3'){
	header('location:news.php');
	die();
}

// Fetch users with rank 2 from the database
$sql = "SELECT id, username, email FROM admin_user WHERE role = 2";
$result = mysqli_query($con, $sql);

// Initialize an array to store user options for the dropdown
$userOptions = array();

// Check if any users found
if(mysqli_num_rows($result) > 0) {
    // Generate dropdown options dynamically
    while($row = mysqli_fetch_assoc($result)) {
        $userOptions[$row['id']] = $row['username'];
        $userEmails[$row['id']] = $row['email']; // Store user emails for notifications
    }
} else {
    // No users found, handle accordingly
    echo "No users found";
    exit();
}

// Handle form submission for adding task
if(isset($_POST['submit'])) {
    $userId = $_POST['user_id'];
    $taskDescription = $_POST['task_description'];
    
    // Insert task into the tasks table
    $insertSql = "INSERT INTO tasks (user_id, description) VALUES ($userId, '$taskDescription')";
    $insertResult = mysqli_query($con, $insertSql);
    
    if($insertResult) {
        // Send email notification to the user using PHPMailer
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';  // SMTP server for Gmail
            $mail->SMTPAuth   = true;               // Enable SMTP authentication
            $mail->Username   = 'khanjohnny465@gmail.com '; // SMTP username (your Gmail email)
            $mail->Password   = 'uvmj qugc aicc txyk';           // SMTP password (your Gmail password)
            $mail->SMTPSecure = 'tls';              // Enable TLS encryption (STARTTLS)
            $mail->Port       = 587;                // TCP port to connect to

            // Recipients
            $mail->setFrom('khanjohnny465@gmail.com ', 'SuperVisor');
            $mail->addAddress($userEmails[$userId]);     // Add a recipient

            // Content
            $mail->isHTML(false);                     // Set email format to HTML
            $mail->Subject = 'New Task Assigned';
            $mail->Body    = "Dear User,\n\nA new task has been assigned to you. Please log in to your account to view it.";

    // Send the email
    $mail->send();
    echo 'Email sent successfully!';

            
            // Redirect to success page
            header('location: task_success.php');
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    } else {
        // Error occurred during task addition, handle accordingly
        echo "Error adding task";
    }
}
?>
