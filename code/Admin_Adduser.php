<?php
include('header.php');

// Check if user is already logged in and redirect
if(isset($_SESSION['ROLE']) && ($_SESSION['ROLE'] != '1' && $_SESSION['ROLE'] != '3')){
    header('location:news.php');
    die();
}
// Include database connection
require('db.php');

// Define error variable
$error = '';

// Check if form is submitted
if(isset($_POST['submit'])){
    // Retrieve form data
    $username = $_POST['user_name'];
    $password = $_POST['password'];
    $email = $_POST['email']; 
    $memorable_word = $_POST['memorable_word']; // Added memorable word field
    
    // Check if username already exists in database
    $check_query = "SELECT * FROM admin_user WHERE username='$username'";
    $check_result = mysqli_query($con, $check_query);
    $count = mysqli_num_rows($check_result);
    
    if($count == 0){
        // Insert new user into database
        $insert_query = "INSERT INTO admin_user (username, password, email, memorable_word, role) VALUES ('$username', '$password', '$email', '$memorable_word', '2')"; // Added memorable word field
        $insert_result = mysqli_query($con, $insert_query);
        
        if($insert_result){
            // User has been created
            $error = 'User has been created';
        } else {
            // Error in insertion
            $error = 'Error in user creation';
        }
    } else {
        // Username already exists
        $error = 'Username already exists. Please choose a different username.';
    }
}
?>

<html>
<body>

<div id="box">
    <h1>Signup</h1>
    <form method="post">
        <label for="user_name">Username:</label>
        <input id="user_name" type="text" name="user_name" required><br>

        <label for="password">Password:</label>
        <input id="password" type="password" name="password" required><br>

        <label for="email">Email:</label> 
        <input id="email" type="email" name="email" required><br> 

        <label for="memorable_word">Memorable Word:</label> <!-- Added memorable word field -->
        <input id="memorable_word" type="text" name="memorable_word" required><br> <!-- Added memorable word field -->

        <input type="submit" name="submit" value="Signup"><br>

        <div class="signup"><?php echo $error; ?></div>
    </form>
</div>

</body>
</html>
