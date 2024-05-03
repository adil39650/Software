<?php
require('db.php');
$error = '';
session_start();
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM admin_user WHERE username='$username' AND password='$password'";
    $res = mysqli_query($con, $sql);
    $count = mysqli_num_rows($res);
    if ($count > 0) {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['ROLE'] = $row['role'];
        $_SESSION['IS_LOGIN'] = 'yes';
        $_SESSION['USERNAME'] = $username;
        $_SESSION['USER_ID'] = $row['id']; // Replace 'id' with the actual column name that represents the user's ID.
        
        if ($row['role'] == 1) {
            header('location:index.php');
            die();
        } elseif ($row['role'] == 2) {
            header('location:user_auth.php');
            die();
        } elseif ($row['role'] == 3) {
            header('location:SuperVhome.php');
            die();
        }
    } else {
        $error = 'Please enter correct login details';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Admin - Login</title>
      <!-- Custom fonts for this template-->
      <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
      <!-- Custom styles for this template-->
      <link href="css/sb-admin.css" rel="stylesheet">
   </head>
   <body class="bg-dark">
      <div class="container">
         <div class="card card-login mx-auto mt150">
            <div class="card-header">Login</div>
            <div class="card-body">
               <form method="post">
                  <div class="form-group">
                     <div class="form-label-group">
                        <input type="username" name="username" class="form-control" placeholder="Username" required="required" autofocus="autofocus">
                        <label for="username">Username</label>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="form-label-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                        <label for="inputPassword">Password</label>
                     </div>
                  </div>
                  <input type="submit" name="submit" class="btn btn-primary btn-block">
				  <?php echo $error?>
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