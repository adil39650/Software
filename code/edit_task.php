<?php
include('header.php');

// Redirect if user is not admin
if(isset($_SESSION['ROLE']) && $_SESSION['ROLE'] != '1'){
    header('location:news.php');
    die();
}

// Include database connection
require('db.php');

// Fetch task details based on task ID from the URL
if(isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    // Fetch user's username for display
    $usernameQuery = "SELECT username FROM admin_user WHERE id = $userId";
    $usernameResult = mysqli_query($con, $usernameQuery);
    $usernameRow = mysqli_fetch_assoc($usernameResult);
    $username = $usernameRow['username'];

    // Fetch existing tasks for the selected user
    $taskSql = "SELECT id, description FROM tasks WHERE user_id = $userId";
    $taskResult = mysqli_query($con, $taskSql);

    // Check if any tasks found
    if(mysqli_num_rows($taskResult) > 0) {
        $taskRow = mysqli_fetch_assoc($taskResult);
        $existingTaskId = $taskRow['id'];
    } else {
        $existingTaskId = null;
    }

    // Handle form submission for editing task
    if(isset($_POST['submit'])) {
        $taskDescription = $_POST['task_description'];
        
        // Check if there's an existing task to update
        if($existingTaskId) {
            // Update the existing task
            $updateSql = "UPDATE tasks SET description = '$taskDescription' WHERE id = $existingTaskId";
        } else {
            // Insert a new task if none exists
            $updateSql = "INSERT INTO tasks (user_id, description) VALUES ($userId, '$taskDescription')";
        }

        $updateResult = mysqli_query($con, $updateSql);
        
        if($updateResult) {
            // Redirect back to the task listing page after successful task update
            header('location:student.php');
            die();
        } else {
            // Error occurred during task update, handle accordingly
            echo "Error updating task";
        }
    }
} else {
    echo "User ID not provided";
    exit();
}
?>

<div class="container">
    <h2>Edit Task for <?php echo $username; ?></h2>
    <form method="post">
        <div class="form-group">
            <label for="task_description">Task Description:</label>
            <textarea class="form-control" id="task_description" name="task_description" rows="3" required></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Update Task</button>
    </form>
</div>

<?php include('footer.php'); ?>
