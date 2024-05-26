<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'auth.php';
include_once 'database.php';

// Check if a bookingId is provided in the URL
if (isset($_GET['bookingId']) && !empty($_GET['bookingId'])) {
    $bookingId = $_GET['bookingId'];

    // Check if the venue booking exists
    $venueBooking = getVenueBookingById($bookingId);

    if ($venueBooking) {
        // Perform the deletion
        deleteVenueBooking($bookingId);

        // Redirect after deleting to avoid resubmission
        header("Location: bookings.php");
        exit();
    } else {
        // Redirect to a 404 page or handle the case when the venue booking doesn't exist
        header("Location: 404.php");
        exit();
    }
} else {
    // Redirect to a 404 page or handle the case when bookingId is not provided
    header("Location: 404.php");
    exit();
}
?>