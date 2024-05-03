<?php
// Include database connection
require('db.php');

// Include FPDF library
require('E:\Xampp\htdocs\Example\fpdf186\fpdf.php');

// Initialize PDF
$pdf = new FPDF();
$pdf->AddPage();

// Set font
$pdf->SetFont('Arial', 'B', 16);

// Fetch staff members with role 2 from the database
$staffSql = "SELECT id, username FROM admin_user WHERE role = 2";
$staffResult = mysqli_query($con, $staffSql);

// Loop through each staff member
while ($staffRow = mysqli_fetch_assoc($staffResult)) {
    $userId = $staffRow['id'];
    $username = $staffRow['username'];

    // Add user details to PDF
    $pdf->Cell(0, 10, "User Details: $username", 0, 1);

    // Fetch tasks for the user from the database
    $taskSql = "SELECT t.description, t.time_issued, t.due_date, pn.note, pn.timestamp 
                FROM tasks t 
                LEFT JOIN progress_notes pn ON t.id = pn.task_id 
                WHERE t.user_id = $userId";
    $taskResult = mysqli_query($con, $taskSql);

    // Add tasks and progress notes to PDF
    while ($taskRow = mysqli_fetch_assoc($taskResult)) {
        $pdf->Cell(0, 10, "Task: {$taskRow['description']}", 0, 1);
        $pdf->Cell(0, 10, "Time Issued: {$taskRow['time_issued']}", 0, 1);
        $pdf->Cell(0, 10, "Due Date: {$taskRow['due_date']}", 0, 1);
        if ($taskRow['note']) {
            $pdf->Cell(0, 10, "Progress Note: {$taskRow['note']}", 0, 1);
            $pdf->Cell(0, 10, "Time Note Added: {$taskRow['timestamp']}", 0, 1);
        } else {
            $pdf->Cell(0, 10, "No Progress Notes", 0, 1);
        }
        $pdf->Ln();
    }

    // Add separator between users
    $pdf->Cell(0, 10, "-----------------------------------------", 0, 1);
}

// Output PDF as download
$pdf->Output('all_user_tasks.pdf', 'D');
?>
