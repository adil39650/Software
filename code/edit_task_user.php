<?php
require('db.php');
session_start();

// Check if the user is logged in and has the role of 2 (staff)
if (!isset($_SESSION['IS_LOGIN']) || $_SESSION['ROLE'] != 2) {
    header('location:login.php');
    exit;
}

// Fetch user's tasks
$user_id = $_SESSION['USER_ID']; // Ensure this is set in the login process
$sql = "SELECT id, description, status FROM tasks WHERE user_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch task details based on task ID from the URL
if(isset($_GET['id'])) {
    $taskId = $_GET['id'];
    
    // Fetch the current task details
    $taskQuery = "SELECT user_id, description, status FROM tasks WHERE id = ? AND user_id = ?";
    $stmt = $con->prepare($taskQuery);
    $stmt->bind_param("ii", $taskId, $user_id);
    $stmt->execute();
    $taskResult = $stmt->get_result();
    
    if(mysqli_num_rows($taskResult) > 0) {
        $task = mysqli_fetch_assoc($taskResult);
        $currentStatus = $task['status'];
        $taskDescription = $task['description'];
    } else {
        echo "No task found or you don't have permission to edit this task.";
        exit();
    }

    // Handle form submission to update task status
    if(isset($_POST['update'])) {
        $newStatus = $_POST['status'];
        $newTaskDescription = $_POST['task'];

        // Delete associated progress notes
        $deleteProgressQuery = "DELETE FROM progress_notes WHERE task_id = ?";
        $stmt = $con->prepare($deleteProgressQuery);
        $stmt->bind_param("i", $taskId);
        $stmt->execute();

        // Delete the existing task
        $deleteQuery = "DELETE FROM tasks WHERE id = ?";
        $stmt = $con->prepare($deleteQuery);
        $stmt->bind_param("i", $taskId);
        $stmt->execute();

        // Insert the updated task into the database
        $insertQuery = "INSERT INTO tasks (user_id, description, status) VALUES (?, ?, ?)";
        $stmt = $con->prepare($insertQuery);
        $stmt->bind_param("iss", $user_id, $newTaskDescription, $newStatus);
        
        if($stmt->execute()) {
            header("location: userhome.php");
            exit();
        } else {
            echo "Failed to update task.";
        }
    }
} else {
    echo "No task ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Task - User</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>
<body class="bg-dark">
    <div class="container">
        <div class="card mx-auto mt-5">
            <div class="card-header">Edit Task</div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label for="task">Task Description:</label>
                        <textarea class="form-control" id="task" name="task" rows="3"><?php echo htmlspecialchars($taskDescription, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" id="status" name="status">
                            <option value="In Progress" <?php echo $currentStatus == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                            <option value="Complete" <?php echo $currentStatus == 'Complete' ? 'selected' : ''; ?>>Complete</option>
                        </select>
                    </div>
                    <button type="submit" name="update" class="btn btn-primary">Update Task</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>
</html>
