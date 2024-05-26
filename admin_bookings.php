<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'auth.php';
include_once 'database.php';
require('fpdf/fpdf.php'); // Include FPDF library

// Function to generate PDF report
function generatePDFReport($bookings) {
    $pdf = new FPDF();
    $pdf->AddPage();
    
    // Add logo at the top
    $pdf->Image('logo.jpg', 10, 10, 60); // Adjust the path and size as needed
    
    // Add date and time
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(190, 10, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 1, 'R');
    // Add title below the logo
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(190, 40, 'Talent Bookings Report', 0, 1, 'C'); // Adjust the vertical position to allow space for the logo
    
    // Add table header
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(27, 8, 'Person Inquiring', 1, 0, 'C');
    $pdf->Cell(32, 8, 'Title/Role/Affiliation', 1, 0, 'C');
    $pdf->Cell(28, 8, 'Contact Number', 1, 0, 'C');
    $pdf->Cell(33, 8, 'Event Name', 1, 0, 'C');
    $pdf->Cell(33, 8, 'Talent Name', 1, 0, 'C');
    $pdf->Cell(20, 8, 'Date', 1, 0, 'C');
    $pdf->Cell(18, 8, 'Status', 1, 1, 'C');
    
    // Add table data
    $pdf->SetFont('Arial', '', 10);
    foreach ($bookings as $booking) {
        $pdf->Cell(27, 8, $booking['person_inquiring'], 1, 0, 'C');
        $pdf->Cell(32, 8, $booking['title_role_affiliation'], 1, 0, 'C');
        $pdf->Cell(28, 8, $booking['contact_number'], 1, 0, 'C');
        $pdf->Cell(33, 8, $booking['event_name'], 1, 0, 'C');
        $pdf->Cell(33, 8, getTalentNameById($booking['talent_id']), 1, 0, 'C');
        $pdf->Cell(20, 8, $booking['date'], 1, 0, 'C');
        $pdf->Cell(18, 8, $booking['status'], 1, 1, 'C');
    }

    // Add date and time at the bottom
    $pdf->SetY(-15); // Position at 1.5 cm from bottom
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(0, 10, 'Generated on ' . date('Y-m-d H:i:s'), 0, 0, 'C');
    
    $pdf->Output();
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["confirm"])) {
        $bookingId = $_POST["bookingId"]; // Change to 'bookingId'
        updateBookingStatus($bookingId, 'confirmed');
    } elseif (isset($_POST["decline"])) {
        $bookingId = $_POST["bookingId"]; // Change to 'bookingId'
        updateBookingStatus($bookingId, 'declined');
    } elseif (isset($_POST["pending"])) {
        $bookingId = $_POST["bookingId"]; // Change to 'bookingId'
        updateBookingStatus($bookingId, 'pending');
    } elseif (isset($_POST["generate_report"])) {
        $bookings = getBookings();
        generatePDFReport($bookings);
    }
}

// Fetch bookings from the database
$bookings = getBookings();
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
        <h2>Talent Bookings</h2>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <button type="submit" name="generate_report">Generate Report</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Person Inquiring</th>
                    <th>Title/Role/Affiliation</th>
                    <th>Contact Number</th>
                    <th>Event Name</th>
                    <th>Talent Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo $booking['person_inquiring']; ?></td>
                        <td><?php echo $booking['title_role_affiliation']; ?></td>
                        <td><?php echo $booking['contact_number']; ?></td>
                        <td><?php echo $booking['event_name']; ?></td>
                        <td><?php echo getTalentNameById($booking['talent_id']); ?></td>
                        <td><?php echo $booking['date']; ?></td>
                        <td><?php echo $booking['status']; ?></td>
                        <td>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <input type="hidden" name="bookingId" value="<?php echo $booking['booking_id']; ?>">
                                <button type="submit" name="confirm">Confirm</button>
                                <button type="submit" name="decline">Decline</button>
                                <button type="submit" name="pending">Pending</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
