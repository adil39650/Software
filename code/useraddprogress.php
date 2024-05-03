<?php
require('db.php');
session_start();

// Check if the user is logged in and has the role of 2 (staff)
if (!isset($_SESSION['IS_LOGIN']) || $_SESSION['ROLE'] != 2) {
    header('location:login.php');
    exit;
}

// Ensure task_id is provided in the URL
if (!isset($_GET['task_id'])) {
    header('location:staff_dashboard.php');
    exit;
}

$error = '';

// Handle form submission for adding progress notes
if (isset($_POST['submit'])) {
    $task_id = $_GET['task_id'];
    $progress_note = $_POST['progress_note'];

    // Insert progress note into the progress_notes table
    $sql = "INSERT INTO progress_notes (task_id, note) VALUES (?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("is", $task_id, $progress_note);
    if ($stmt->execute()) {
        // Progress note added successfully, redirect to staff dashboard
        header('location:userhome.php');
        exit;
    } else {
        // Error occurred during progress note insertion
        $error = "Error adding progress note";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Progress Notes</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>
<body class="bg-dark">
    <div class="container">
        <div class="card mx-auto mt-5">
            <div class="card-header">Add Progress Notes</div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label for="progress_note">Progress Note:</label>
                        <textarea class="form-control" id="progress_note" name="progress_note" rows="3" required></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Add Progress Note</button>
                    <div class="error"><?php echo $error; ?></div>
                </form>
            </div>
            <div class="card-footer">
                <a href="userhome.php" class="btn btn-secondary">Back to Dashboard</a>
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
