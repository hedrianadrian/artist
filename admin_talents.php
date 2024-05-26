<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'auth.php';
include_once 'database.php';
include('fpdf/fpdf.php'); // Include FPDF library

// Check if the user is not logged in, redirect to index page
$venueBookings = getVenueBookings(); // Make sure you have the appropriate function defined in database.php

// Fetch talents from the database
$talents = getTalents();

// Function to generate PDF report
function generatePDFReport($talents) {
    $pdf = new FPDF();
    $pdf->AddPage();
    
    // Add logo
    $pdf->Image('logo.jpg', 10, 10, 60); // Adjust the path and size as needed
    
    // Add date and time
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(190, 10, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 1, 'R');
    
    // Move the cursor down after the logo and date
    $pdf->Ln(30);
    
    // Add title
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(190, 10, 'Talents Report', 0, 1, 'C');
    
    // Add table headers
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, 'Talent ID', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Talent Name', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Talent Skill', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Talent Fee', 1, 1, 'C');
    
    // Add table data
    foreach ($talents as $talent) {
        $pdf->Cell(50, 10, $talent['talent_id'], 1, 0, 'C');
        $pdf->Cell(50, 10, $talent['talent_name'], 1, 0, 'C');
        $pdf->Cell(50, 10, $talent['talent_skill'], 1, 0, 'C');
        $pdf->Cell(40, 10, $talent['talent_fee'], 1, 1, 'C');
    }
    
    // Output the PDF
    $pdf->Output();
    exit;
}

// Handle talent addition and PDF report generation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add"])) {
        // Redirect to addtalent.php for adding talent
        header("Location: addtalent.php");
        exit();
    } elseif (isset($_POST["update"])) {
        // Redirect to updatetalent.php for updating talent with talent_id as a parameter
        $talentId = $_POST["talentId"];
        header("Location: updatetalent.php?talent_id=" . $talentId);
        exit();
    } elseif (isset($_POST["delete"])) {
        // Delete talent directly without confirmation
        $talentId = $_POST["talentId"];
        deleteTalent($talentId);
        
        // Redirect back to the same page after deletion
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } elseif (isset($_POST["generate_report"])) {
        // Generate PDF report
        generatePDFReport($talents);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Artist Hub Admin Dashboard</title>
</head>
<body>
    <div class="header">
    <img src="logo.png" alt="Artist Hub Logo">
        <h1>Artist Hub Admin Dashboard</h1>
        <p>Welcome <a href="logout.php">Logout</a></p>
    </div>

    <header>
        <nav>
            <a href="admin_dashboard.php">Admin Dashboard</a>
            <a href="admin_talents.php">Talents</a>
            <a href="admin_venues.php">Venues</a>
            <a href="admin_bookings.php">Talent Bookings</a>
            <a href="admin_bookings2.php">Venue Bookings</a>
        </nav>
    </header>

    <div class="container">
        <h2>Talents</h2>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <button type="submit" name="add">Add Talent</button>
            <button type="submit" name="generate_report">Generate Report</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Talent ID</th>
                    <th>Talent Name</th>
                    <th>Talent Skill</th>
                    <th>Talent Fee</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($talents as $talent): ?>
                    <tr>
                        <td><?php echo $talent['talent_id']; ?></td>
                        <td><?php echo $talent['talent_name']; ?></td>
                        <td><?php echo $talent['talent_skill']; ?></td>
                        <td><?php echo $talent['talent_fee']; ?></td>
                        <td>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <input type="hidden" name="talentId" value="<?php echo $talent['talent_id']; ?>">
                                <button type="submit" name="update">Update</button>
                                <button type="submit" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
