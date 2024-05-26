<?php
include 'auth.php';
include_once 'database.php';

if (isset($_GET['id'])) {
    $venueBookingId = $_GET['id'];

    // Attempt to delete the venue booking
    $result = deleteVenueBooking($venueBookingId);

    if ($result) {
        // Successful deletion, redirect to index page
        header("Location: index.php");
        exit();
    } else {
        // Failed to delete, redirect to index page with an error message
        header("Location: index.php?delete_error=true");
        exit();
    }
} else {
    // Redirect to index page if venue_booking_id is not provided
    header("Location: index.php");
    exit();
}

