<?php
// Check if a session is not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require('db.php');

// Check if the user is already logged in
if (!isset($_SESSION['IS_LOGIN'])) {
    header('location:login.php');
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $memorable_word = isset($_POST['memorable_word']) ? $_POST['memorable_word'] : ''; // Set the memorable word to an empty string if not provided
    
    // Retrieve user ID from session
    $user_id = $_SESSION['USER_ID'];
    
    // Fetch the memorable word associated with the user from the database
    $sql = "SELECT memorable_word FROM admin_user WHERE id = '$user_id'";
    $result = mysqli_query($con, $sql);
    
    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $db_memorable_word = $row['memorable_word'];

        // Check if the memorable word matches
        if ($memorable_word == $db_memorable_word || $db_memorable_word === null) { // Allow login if the provided word matches the stored word or if no word is set
            // Redirect to user home page
            header('location:userhome.php');
            exit();
        } else {
            $error = "Incorrect memorable word. Please try again.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Authentication</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <style>
        body {
            background-color: #343a40;
            color: #ffffff;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            width: 400px;
            background-color: #212529;
            border: none;
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background-color: #343a40;
            color: #ffffff;
            padding: 0.75rem;
            font-weight: bold;
            border-bottom: 1px solid #454d55;
        }

        .card-body {
            padding: 1.25rem;
        }

        .form-label-group {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-label-group>input {
            height: auto;
            border-radius: 0.25rem;
            padding: 10px;
            background-color: #343a40;
            color: #ffffff;
            border: 1px solid #ced4da;
        }

        .form-label-group>label {
            position: absolute;
            top: 0;
            left: 0;
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            pointer-events: none;
            color: #ffffff;
            background-color: transparent;
            border: none;
            border-radius: 0.25rem;
            transition: all 0.1s ease-in-out;
        }

        .form-label-group input::-webkit-input-placeholder {
            color: transparent;
        }

        .form-label-group input:-ms-input-placeholder {
            color: transparent;
        }

        .form-label-group input::-ms-input-placeholder {
            color: transparent;
        }

        .form-label-group input::-moz-placeholder {
            color: transparent;
        }

        .form-label-group input::placeholder {
            color: transparent;
        }

        .form-label-group input:not(:placeholder-shown)~label {
            background-color: transparent;
            top: -0.375rem;
            font-size: 12px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .text-danger {
            color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card card-login mx-auto mt150">
            <div class="card-header">Login with Memorable Word</div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="text" id="memorable_word" name="memorable_word" class="form-control" placeholder="Enter Memorable Word (optional)" autofocus="autofocus">
                            <label for="memorable_word">Memorable Word</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                    <?php if (isset($error)) {
                        echo "<div class='text-danger'>$error</div>";
                    } ?>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
