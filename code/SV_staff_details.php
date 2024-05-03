<?php
include('header.php');

// Redirect if user is not supervisor
if(isset($_SESSION['ROLE']) && ($_SESSION['ROLE'] != '3')){
    header('location:news.php');
    die();
}

// Include database connection
require('db.php');

// Check if user ID is provided in the URL
if(isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user details from the database
    $userSql = "SELECT username FROM admin_user WHERE id = $userId";
    $userResult = mysqli_query($con, $userSql);

    if(mysqli_num_rows($userResult) == 1) {
        $userRow = mysqli_fetch_assoc($userResult);
        $username = $userRow['username'];
        // You can fetch more user details if needed
    } else {
        // User not found, redirect to some error page or back to the user listing page
        header('location:SuperV_Viewstaff.php');
        die();
    }
} else {
    // User ID not provided, redirect to some error page or back to the user listing page
    header('location:SuperV_Viewstaff.php');
    die();
}

// Fetch tasks for the user from the database
$taskSql = "SELECT t.id, t.description, t.time_issued, t.due_date, pn.note, pn.timestamp 
            FROM tasks t 
            LEFT JOIN progress_notes pn ON t.id = pn.task_id 
            WHERE t.user_id = $userId";
$taskResult = mysqli_query($con, $taskSql);
?>

<div class="container">
    <h2>User Details</h2>
    <p><strong>Name:</strong> <?php echo $username; ?></p>

    <!-- Search Bar -->
    <div class="mb-3">
        <input type="text" id="searchTask" class="form-control" placeholder="Search tasks...">
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Time Issued</th>
                    <th>Due Date</th>
                    <th>Review Due Date</th> <!-- New column for Review Due Date button -->
                    <th>Progress Notes</th>
                    <th>Time Note Added</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="taskTableBody">
                <?php
                // Display tasks for the user
                while($taskRow = mysqli_fetch_assoc($taskResult)) {
                    echo "<tr>";
                    echo "<td>{$taskRow['description']}</td>";
                    echo "<td>{$taskRow['time_issued']}</td>";
                    echo "<td>{$taskRow['due_date']}</td>";
                    // Review Due Date button linking to SV_reviewdate.php
                    echo "<td><a href='SV_reviewdate.php?task_id={$taskRow['id']}' class='btn btn-warning'>Review Due Date</a></td>";
                    echo "<td>";
                    if ($taskRow['note']) {
                        echo $taskRow['note'];
                    } else {
                        echo "No Progress Notes";
                    }
                    echo "</td>";
                    // Display the time note was added or "N/A" if no note exists
                    echo "<td>";
                    echo $taskRow['timestamp'] ? $taskRow['timestamp'] : "N/A";
                    echo "</td>";
                    // Edit Task button with link to svedittask.php passing task ID
                    echo "<td><a href='svedittask.php?task_id={$taskRow['id']}' class='btn btn-info'>Edit Task</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Button for Edit User -->
    <div>
        <a href="SVedituser.php?id=<?php echo $userId; ?>" class="btn btn-primary">Edit User</a>
        <a href="svaddtask.php?id=<?php echo $userId; ?>" class="btn btn-success">Add Task</a>
    </div>
    <!-- Form for downloading logs -->
    <form action="download_logs.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
        <button type="submit" class="btn btn-primary">Download Logs</button>
    </form>
</div>

<?php include('footer.php'); ?>

<script>
// JavaScript for handling search functionality
document.getElementById('searchTask').addEventListener('input', function() {
    let searchValue = this.value.toLowerCase();
    let rows = document.querySelectorAll('#taskTableBody tr');

    rows.forEach(row => {
        let taskDescription = row.cells[0].textContent.toLowerCase();
        if (taskDescription.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
