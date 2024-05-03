<?php
require('db.php');
session_start();

// Check if the user is logged in and has the role of 2 (staff)
if (!isset($_SESSION['IS_LOGIN']) || $_SESSION['ROLE'] != 2) {
    header('location:login.php');
    exit;
}

// Fetch user's tasks along with progress notes
$user_id = $_SESSION['USER_ID']; // Ensure this is set in the login process
$sql = "SELECT t.id, t.description AS task_description, t.status, t.due_date, pn.note AS progress_note 
        FROM tasks t 
        LEFT JOIN progress_notes pn ON t.id = pn.task_id 
        WHERE t.user_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Staff - Home</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>
<body class="bg-dark">
    <div class="container">
        <div class="card mx-auto mt-5">
            <div class="card-header">Staff Dashboard</div>
            <div class="card-body">
                Welcome, <?php echo isset($_SESSION['USERNAME']) ? htmlspecialchars($_SESSION['USERNAME'], ENT_QUOTES, 'UTF-8') : 'User'; ?>!
                <!-- Display tasks and progress notes in a table -->
                <h3>Your Tasks</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Task Description</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Progress Notes</th>
                            <th>Edit Task/Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['task_description'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['due_date'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo $row['progress_note'] ? htmlspecialchars($row['progress_note'], ENT_QUOTES, 'UTF-8') : 'No Progress Notes Available'; ?></td>
                            <td>
                                <a href="edit_task_user.php?id=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                                <?php if (!$row['progress_note']): ?>
                                <a href="useraddprogress.php?task_id=<?php echo $row['id']; ?>" class="btn btn-primary">Add Progress Notes</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="logout.php" class="btn btn-warning">Logout</a>
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