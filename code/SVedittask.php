<?php
include('header.php');

// Redirect if user is not supervisor
if(isset($_SESSION['ROLE']) && ($_SESSION['ROLE'] != '3')){
    header('location:news.php');
    die();
}

// Include database connection
require('db.php');

// Check if task ID is provided in the URL
if(isset($_GET['task_id'])) {
    $taskId = $_GET['task_id'];
    
    // Fetch task details from the database
    $taskSql = "SELECT description FROM tasks WHERE id = $taskId";
    $taskResult = mysqli_query($con, $taskSql);
    
    if(mysqli_num_rows($taskResult) == 1) {
        $taskRow = mysqli_fetch_assoc($taskResult);
        $taskDescription = $taskRow['description'];
    } else {
        // Task not found, redirect to some error page or back to the staff details page
        header('location:SV_staff_details.php');
        die();
    }
} else {
    // Task ID not provided, redirect to some error page or back to the staff details page
    header('location:SV_staff_details.php');
    die();
}

// Handle form submission for updating task details
if(isset($_POST['submit'])) {
    $newTaskDescription = $_POST['task_description'];
    
    // Update task details in the database
    $updateSql = "UPDATE tasks SET description = '$newTaskDescription' WHERE id = $taskId";
    $updateResult = mysqli_query($con, $updateSql);
    
    if($updateResult) {
        // Redirect back to staff details page after successful update
        header('location:SV_staff_details.php');
        die();
    } else {
        // Error occurred during update, handle accordingly
        echo "Error updating task details";
    }
}
?>

<div class="container">
    <h2>Edit Task</h2>
    
    <!-- Form for editing task -->
    <form action="" method="post">
        <!-- Task description input field -->
        <div class="form-group">
            <label for="task_description">Task Description:</label>
            <input type="text" class="form-control" id="task_description" name="task_description" value="<?php echo $taskDescription; ?>" required>
        </div>
        
        <!-- Button to submit task changes -->
        <button type="submit" name="submit" class="btn btn-primary">Submit Task Changes</button>
    </form>
</div>

<?php include('footer.php'); ?>
