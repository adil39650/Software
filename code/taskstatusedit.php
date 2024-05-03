<?php
include('header.php');

// Redirect if user is not admin
if(isset($_SESSION['ROLE']) && $_SESSION['ROLE'] != '1'){
    header('location:news.php');
    die();
}

// Include database connection
require('db.php');

// Initialize task ID and user ID
$taskId = isset($_GET['id']) ? $_GET['id'] : null;

if($taskId) {
    // Fetch the current status of the task
    $taskQuery = "SELECT user_id, description, status FROM tasks WHERE id = $taskId";
    $taskResult = mysqli_query($con, $taskQuery);
    if(mysqli_num_rows($taskResult) > 0) {
        $task = mysqli_fetch_assoc($taskResult);
        $currentStatus = $task['status'];
        $taskDescription = $task['description'];
        $userId = $task['user_id'];
    } else {
        echo "No task found.";
        exit();
    }
} else {
    echo "No task ID provided.";
    exit();
}

// Handle form submission to update task status
if(isset($_POST['update'])) {
    $newStatus = $_POST['status'];

    // Update task status in the database
    $updateQuery = "UPDATE tasks SET status = '$newStatus' WHERE id = $taskId";
    if(mysqli_query($con, $updateQuery)) {
        header("location: student.php?id=$userId");
        exit();
    } else {
        echo "Failed to update task status.";
    }
}
?>

<div class="container">
    <h2>Edit Task Status</h2>
    <form method="post">
        <div class="form-group">
            <label for="task">Task Description:</label>
            <textarea class="form-control" id="task" name="task" rows="3" disabled><?php echo $taskDescription; ?></textarea>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control" id="status" name="status">
                <option value="In Progress" <?php echo $currentStatus == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                <option value="Complete" <?php echo $currentStatus == 'Complete' ? 'selected' : ''; ?>>Complete</option>
            </select>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update Status</button>
    </form>
</div>

<?php include('footer.php'); ?>
