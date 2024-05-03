<?php
include('header.php');

// Check if user is logged in
if (!isset($_SESSION['USER_ID'])) {
    header('location: login.php');
    exit();
}

// Include database connection
require('db.php');

// Fetch username of the logged-in user
$userId = $_SESSION['USER_ID'];
$usernameQuery = "SELECT username FROM admin_user WHERE id = $userId";
$usernameResult = mysqli_query($con, $usernameQuery);

// Check if username is found
if (mysqli_num_rows($usernameResult) > 0) {
    $usernameRow = mysqli_fetch_assoc($usernameResult);
    $username = $usernameRow['username'];

    // Fetch tasks assigned to the logged-in user
    $taskSql = "SELECT description FROM tasks WHERE user_id = $userId";
    $taskResult = mysqli_query($con, $taskSql);

    // Initialize a variable to store task rows
    $task_rows = '';

    // Check if any tasks found
    if (mysqli_num_rows($taskResult) > 0) {
        // Generate table rows dynamically
        while ($taskRow = mysqli_fetch_assoc($taskResult)) {
            $task_rows .= "<tr>";
            $task_rows .= "<td>{$taskRow['description']}</td>";
            $task_rows .= "</tr>";
        }
    } else {
        $task_rows = "<tr><td colspan='3'>No tasks assigned</td></tr>";
    }
} else {
    echo "Username not found";
    exit();
}
?>

<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-fw fa-user"></i>
            User Tasks
        </div>
        <div class="card-body">
            <h2>Welcome, <?php echo $username; ?></h2>
            <br>
            <h3>Tasks Assigned to You</h3>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $task_rows; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php')?>
