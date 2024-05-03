<?php
// Include database connection
require('db.php');

// Check if user ID is provided
if(isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    
    // Fetch user details from the database
    $userSql = "SELECT username, email, role, memorable_word FROM admin_user WHERE id = $userId";
    $userResult = mysqli_query($con, $userSql);
    
    if(mysqli_num_rows($userResult) == 1) {
        $userRow = mysqli_fetch_assoc($userResult);
        $username = $userRow['username'];
        $email = $userRow['email'];
        $role = $userRow['role'];
        $memorableWord = $userRow['memorable_word'];
        
        // Fetch tasks and progress notes for the user from the database
        $taskSql = "SELECT t.description, t.time_issued, t.due_date, pn.note, pn.timestamp 
                    FROM tasks t 
                    LEFT JOIN progress_notes pn ON t.id = pn.task_id 
                    WHERE t.user_id = $userId";
        $taskResult = mysqli_query($con, $taskSql);
        
        // Prepare file content
        $fileContent = "User Details:\n";
        $fileContent .= "Username: $username\n";
        $fileContent .= "Email: $email\n";
        $fileContent .= "Role: $role\n";
        $fileContent .= "Memorable Word: $memorableWord\n\n";
        $fileContent .= "Tasks:\n";
        while($taskRow = mysqli_fetch_assoc($taskResult)) {
            $fileContent .= "Task: {$taskRow['description']}\n";
            $fileContent .= "Time Issued: {$taskRow['time_issued']}\n";
            $fileContent .= "Due Date: {$taskRow['due_date']}\n";
            if ($taskRow['note']) {
                $fileContent .= "Progress Note: {$taskRow['note']}\n";
                $fileContent .= "Time Note Added: {$taskRow['timestamp']}\n";
            } else {
                $fileContent .= "No Progress Notes\n";
            }
            $fileContent .= "\n";
        }
        
        // Set headers for file download
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="user_tasks.txt"');
        
        // Output file content
        echo $fileContent;
        
        // Exit script
        exit();
    } else {
        // User not found
        echo "User not found";
    }
} else {
    // User ID not provided
    echo "User ID not provided";
}
?>
