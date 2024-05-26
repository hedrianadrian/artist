<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'auth.php';
include_once 'database.php';
require('fpdf/fpdf.php'); // Include FPDF library

// Function to generate PDF report
function generatePDFReport($venueBookings) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->Image('logo.jpg', 10, 10, 60); // Adjust the path and size as needed
    
    // Add date and time
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(190, 10, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 1, 'R');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(180, 10, 'Venue Bookings Report', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(35, 8, 'Event Name', 1, 0, 'C');
    $pdf->Cell(35, 8, 'Venue Name', 1, 0, 'C');
    $pdf->Cell(25, 8, 'Start Date', 1, 0, 'C');
    $pdf->Cell(20, 8, 'Start Time', 1, 0, 'C');
    $pdf->Cell(20, 8, 'End Date', 1, 0, 'C');
    $pdf->Cell(20, 8, 'End Time', 1, 0, 'C');
    $pdf->Cell(20, 8, 'Status', 1, 1, 'C');
    
    foreach ($venueBookings as $booking) {
        $pdf->Cell(35, 8, $booking['event_name'], 1, 0, 'C');
        $pdf->Cell(35, 8, $booking['venue_name'], 1, 0, 'C');
        $pdf->Cell(25, 8, $booking['start_date'], 1, 0, 'C');
        $pdf->Cell(20, 8, $booking['start_time'], 1, 0, 'C');
        $pdf->Cell(20, 8, $booking['end_date'], 1, 0, 'C');
        $pdf->Cell(20, 8, $booking['end_time'], 1, 0, 'C');
        $pdf->Cell(20, 8, $booking['status'], 1, 1, 'C');
    }
    
    $pdf->Output();
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? null;
    $bookingId = $_POST["bookingId"] ?? null;

    if ($action === "approve") {
        updateVenueBookingStatus($bookingId, 'Confirmed');
    } elseif ($action === "decline") {
        updateVenueBookingStatus($bookingId, 'Declined');
    } elseif ($action === "pending") {
        updateVenueBookingStatus($bookingId, 'Pending');
    } elseif ($action === "generate_report") {
        $venueBookings = getVenueBookings();
        generatePDFReport($venueBookings);
    }
}

// Fetch venue bookings from the database
$venueBookings = getVenueBookings();
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
    <h2>Venue Bookings</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <button type="submit" name="action" value="generate_report">Generate Report</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Venue Name</th>
                <th>Start Date</th>
                <th>Start Time</th>
                <th>End Date</th>
                <th>End Time</th>
                <th>Status</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($venueBookings as $booking): ?>
                <tr>
                    <td><?php echo $booking['event_name']; ?></td>
                    <td><?php echo $booking['venue_name']; ?></td>
                    <td><?php echo $booking['start_date']; ?></td>
                    <td><?php echo $booking['start_time']; ?></td>
                    <td><?php echo $booking['end_date']; ?></td>
                    <td><?php echo $booking['end_time']; ?></td>
                    <td><?php echo $booking['status']; ?></td>
                    <td>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="bookingId" value="<?php echo $booking['venue_booking_id']; ?>">
                            <input type="hidden" name="action" value="approve">
                            <button type="submit">Confirm</button>
                        </form>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="bookingId" value="<?php echo $booking['venue_booking_id']; ?>">
                            <input type="hidden" name="action" value="decline">
                            <button type="submit">Decline</button>
                        </form>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="bookingId" value="<?php echo $booking['venue_booking_id']; ?>">
                            <input type="hidden" name="action" value="pending">
                            <button type="submit">Pending</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
    
</body>
</html>
