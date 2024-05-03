<?php 
include('header.php');

// If user isn't admin it will take them to login page
if(isset($_SESSION['ROLE']) && $_SESSION['ROLE'] != '1'){
    header('location:news.php');
    die();
}

require('db.php');

$sql = "SELECT * FROM admin_user WHERE role = 2";
$result = mysqli_query($con, $sql);

$table_rows = '';

if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $table_rows .= "<tr>";
        $table_rows .= "<td>{$row['username']}</td>";
        $table_rows .= "<td><a href='edit_user.php?id={$row['id']}' class='btn btn-primary'>Edit</a></td>";
        $table_rows .= "<td><button class='btn btn-danger' onclick='deleteUser({$row['id']})'>Delete</button></td>";
        $table_rows .= "<td><a href='add_task.php?id={$row['id']}' class='btn btn-success'>Add Task</a></td>";

        $taskSql = "SELECT description, status FROM tasks WHERE user_id = {$row['id']}";
        $taskResult = mysqli_query($con, $taskSql);
        $taskCount = mysqli_num_rows($taskResult);
        $tasks = '';
        $status = '';
        if($taskCount > 0) {
            while($taskRow = mysqli_fetch_assoc($taskResult)) {
                $tasks .= $taskRow['description'] . '<br>';
                $status = $taskRow['status'] ?: 'In Progress'; // Default to 'In Progress' if status is null
            }
        } else {
            $tasks = 'No tasks assigned';
            $status = 'No Task Assigned';
        }
        $table_rows .= "<td>$tasks</td>";
        $table_rows .= "<td>$status</td>"; // Displaying the status
        $table_rows .= "<td><a href='edit_task.php?id={$row['id']}' class='btn btn-info'>Edit Task</a></td>";
        $table_rows .= "<td><a href='taskstatusedit.php?id={$row['id']}' class='btn btn-warning'>Edit Task Progress</a></td>";
        
        $table_rows .= "</tr>";
    }
} else {
    $table_rows = "<tr><td colspan='8'>No users found</td></tr>";
}

?>
<div class="container-fluid">

   <div class="card mb-3">
      <div class="card-header">
         <i class="fa fa-fw fa-user"></i>
         Staff Table
         <a href="admin_adduser.php"> Add user</a>
      </div>
      <div class="card-body">
         <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
               <thead>
                  <tr>
                     <th>Name</th>
                     <th>Edit</th>
                     <th>Delete</th>
                     <th>Add Task</th>
                     <th>Tasks Assigned</th>
                     <th>Task Status</th> <!-- New Column Header for Task Status -->
                     <th>Edit Task</th>
                     <th>Task Progress</th>
                  </tr>
               </thead>
               <tbody>
                  <?php echo $table_rows; ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

<script>
function deleteUser(userId) {
    if(confirm("Are you sure you want to delete this user?")) {
        window.location.href = 'delete_user.php?id=' + userId;
    }
}
</script>

<?php include('footer.php')?>
