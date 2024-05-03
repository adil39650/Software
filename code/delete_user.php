<?php
// Include database connection
require('db.php');

// Check if user ID is provided in the URL
if(isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    // Delete associated tasks first
    $deleteTasksSql = "DELETE FROM tasks WHERE user_id = $userId";
    $deleteTasksResult = mysqli_query($con, $deleteTasksSql);

    // Proceed to delete the user if tasks deletion is successful
    if($deleteTasksResult) {
        $deleteSql = "DELETE FROM admin_user WHERE id = $userId";
        $deleteResult = mysqli_query($con, $deleteSql);

        if($deleteResult) {
            // User deleted successfully, redirect back to the user listing page
            header('location: student.php');
            exit();
        } else {
            // Error occurred during deletion, handle accordingly
            echo "Error deleting user";
        }
    } else {
        // Error occurred during tasks deletion, handle accordingly
        echo "Error deleting associated tasks";
    }
} else {
    // Redirect to the user listing page if user ID is not provided
    header('location: student.php');
    exit();
}
?>
