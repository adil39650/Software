<?php
include('header.php');

// Include database connection
require('db.php');

// Check if task ID is provided in the URL
if(isset($_GET['task_id'])) {
    $taskId = $_GET['task_id'];
    
    // Fetch task details from the database
    $taskSql = "SELECT description, due_date FROM tasks WHERE id = $taskId";
    $taskResult = mysqli_query($con, $taskSql);
    
    if(mysqli_num_rows($taskResult) == 1) {
        $taskRow = mysqli_fetch_assoc($taskResult);
        $taskDescription = $taskRow['description'];
        $dueDate = $taskRow['due_date'];
    } else {
        // Task not found, redirect to some error page or back to the previous page
        header('location:SuperV_Viewstaff.php');
        die();
    }
} else {
    // Task ID not provided, redirect to some error page or back to the previous page
    header('location:SuperV_Viewstaff.php');
    die();
}

// Handle form submission for updating due date
if(isset($_POST['submit'])) {
    $newDueDate = $_POST['due_date'];
    
    // Update due date in the database
    $updateSql = "UPDATE tasks SET due_date = '$newDueDate' WHERE id = $taskId";
    $updateResult = mysqli_query($con, $updateSql);
    
    if($updateResult) {
        // Redirect back to the task viewing page after successful update
        header("location:SuperV_Viewstaff.php?id=$userId");
        die();
    } else {
        // Error occurred during update, handle accordingly
        echo "Error updating due date";
    }
}
?>

<div class="container">
    <h2>Review Due Date</h2>
    <form method="post">
        <div class="form-group">
            <label for="task_description">Task Description:</label>
            <input type="text" class="form-control" id="task_description" value="<?php echo $taskDescription; ?>" disabled>
        </div>
        <div class="form-group">
            <label for="due_date">Due Date:</label>
            <input type="datetime-local" id="due_date" name="due_date" class="form-control" value="<?php echo $dueDate; ?>" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Update Due Date</button>
    </form>
</div>

<?php include('footer.php'); ?>
