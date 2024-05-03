<?php
include('header.php');

// Redirect if user is not supervisor
if(isset($_SESSION['ROLE']) && ($_SESSION['ROLE'] != '3')){
	header('location:news.php');
	die();
}

// Include database connection
require('db.php');

// Initialize variables
$searchName = ""; // Initialize search name variable

// Check if search query is provided
if(isset($_GET['search'])) {
    // Get the search query
    $searchName = $_GET['search'];

    // Fetch staff members with role 2 matching the search query
    $sql = "SELECT id, username FROM admin_user WHERE role = 2 AND username LIKE '%$searchName%'";
} else {
    // Fetch all staff members with role 2
    $sql = "SELECT id, username FROM admin_user WHERE role = 2";
}

$result = mysqli_query($con, $sql);
?>

<div class="container">
    <h2>Staff Members</h2>

    <!-- Search form -->
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search by name" name="search" value="<?php echo htmlspecialchars($searchName); ?>">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </form>

    <!-- Button for downloading all logs -->
    <div class="mb-3">
        <a href="download_all_logs.php" class="btn btn-primary">Download All Logs</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display each staff member in a table row
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><a href='sv_staff_details.php?id={$row['id']}'>{$row['username']}</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('footer.php'); ?>
