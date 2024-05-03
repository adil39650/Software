<?php 
include('header.php');
if(isset($_SESSION['ROLE']) && $_SESSION['ROLE']!='3'){
    header('location:news.php');
    die();
}
?>

<!-- Improved Dashboard with Picture -->
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="SuperV_ViewStaff.php">View Staff</a> <!-- Changed text color to black -->
                    </li>
                    <!-- You can add more links here for additional pages -->
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Picture -->
            <div class="mb-4">
                <img src="pic1.png" alt="Police Van" class="img-fluid" style="max-width: 100%; height: auto;">
            </div>

            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Supervisor Dashboard</h1>
            </div>

            <!-- Company Details -->
            <div class="card mb-4">
                <div class="card-header">
                    Company Details
                </div>
                <div class="card-body">
                    <p>The Yorkshire and Humber Regional Organised Crime Unit (YHROCU) is dedicated to combating organized crime in the region. With a focus on collaboration and innovation, we strive to maintain the safety and security of our communities.</p>
                </div>
            </div>

            <!-- Related Activity -->
            <div class="card">
                <div class="card-header">
                    Related Activity
                </div>
                <div class="card-body">
                    <p>The department within YHROCU responsible for managing support activities requires an improved workflow management system for non-crime related tasks. These tasks can range from individual assignments to collaborative projects aimed at enhancing the overall efficiency of our operations.</p>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include('footer.php')?>
