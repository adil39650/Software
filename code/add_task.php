<?php
include('header.php');

// Redirect if user is not admin
if(isset($_SESSION['ROLE']) && $_SESSION['ROLE'] != '1'){
	header('location:news.php');
	die();
}

// Include database connection
require('db.php');

// Include PHPMailer classes manually
require 'E:\Xampp\htdocs\Example\PHPMailer-master\src\Exception.php';
require 'E:\Xampp\htdocs\Example\PHPMailer-master\src\PHPMailer.php';
require 'E:\Xampp\htdocs\Example\PHPMailer-master\src\SMTP.php';

// Fetch users with rank 2 from the database
$sql = "SELECT id, username, email FROM admin_user WHERE role = 2";
$result = mysqli_query($con, $sql);

// Initialize an array to store user options for the dropdown
$userOptions = array();

// Check if any users found
if(mysqli_num_rows($result) > 0) {
    // Generate dropdown options dynamically
    while($row = mysqli_fetch_assoc($result)) {
        $userId = $row['id'];
        $username = $row['username'];
        $userEmail = $row['email'];
        $userOptions[$userId] = "$username ($userEmail)"; // Combine username and email for display
        $userEmails[$userId] = $userEmail; // Store user emails for notifications
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
        // Send email notification to the staff member
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';    // SMTP server for Gmail
            $mail->SMTPAuth   = true;                // Enable SMTP authentication
            $mail->Username   = 'khanjohnny465@gmail.com'; // SMTP username (your Gmail email)
            $mail->Password   = 'uvmj qugc aicc txyk'; // App password for Gmail
            $mail->SMTPSecure = 'tls';               // Enable TLS encryption (STARTTLS)
            $mail->Port       = 587;                 // TCP port to connect to

            // Recipients
            $mail->setFrom('khanjohnny465@gmail.com', 'Your Name');
            $mail->addAddress($userEmails[$userId]); // Add a recipient

            // Content
            $mail->isHTML(false);                                  // Set email format to plain text
            $mail->Subject = 'New Task Assigned';
            $mail->Body    = "Dear $username,\n\nA new task has been assigned to you. Please log in to your account to view it.";

            // Send the email
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        // Redirect back to the same page after successful task addition
        header('location:student.php');
        die();
    } else {
        // Error occurred during task addition, handle accordingly
        echo "Error adding task";
    }
}
?>

<div class="container">
    <h2>Add Task</h2>
    <form method="post">
        <div class="form-group">
            <label for="user_id">Select User:</label>
            <select class="form-control" id="user_id" name="user_id" required>
                <option value="">Select User</option>
                <?php
                // Generate dropdown options
                foreach($userOptions as $userId => $userDisplay) {
                    echo "<option value='$userId'>$userDisplay</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="task_description">Task Description:</label>
            <textarea class="form-control" id="task_description" name="task_description" rows="3" required></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Add Task</button>
    </form>
</div>

<?php include('footer.php'); ?>
