<?php
include('header.php');

// Redirect if user is not admin
if(isset($_SESSION['ROLE']) && ($_SESSION['ROLE'] != '1' && $_SESSION['ROLE'] != '3')){
	header('location:news.php');
	die();
}

// Include database connection
require('db.php');

// Check if user ID is provided in the URL
if(isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    // Fetch user details from the database
    $sql = "SELECT * FROM admin_user WHERE id = $userId";
    $result = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        // You can fetch more user details if needed
    } else {
        // User not found, redirect to some error page or back to the user listing page
        header('location:student.php');
        die();
    }
} else {
    // User ID not provided, redirect to some error page or back to the user listing page
    header('location:students.php');
    die();
}

// Handle form submission for updating user details
if(isset($_POST['submit'])) {
    $newUsername = $_POST['username'];
    // You can handle updating more user details here if needed
    
    // Update user details in the database
    $updateSql = "UPDATE admin_user SET username = '$newUsername' WHERE id = $userId";
    $updateResult = mysqli_query($con, $updateSql);
    
    if($updateResult) {
        // Redirect back to user listing page after successful update
        header('location:student.php');
        die();
    } else {
        // Error occurred during update, handle accordingly (display error message, redirect to error page, etc.)
        echo "Error updating user details";
    }
}
?>

<div class="container">
    <h2>Edit User</h2>
    <form method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" required>
        </div>
        <!-- You can add more fields for editing other user details here if needed -->
        <button type="submit" name="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<?php include('footer.php'); ?>
