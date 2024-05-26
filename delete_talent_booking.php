<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'auth.php';
include_once 'database.php';

// Check if the user is not logged in, redirect to index page
// (You may need to modify this part based on your authentication logic)
// ...

// Check if a bookingId is provided in the URL
if (isset($_GET['bookingId']) && !empty($_GET['bookingId'])) {
    $bookingId = $_GET['bookingId'];

    // Fetch the talent booking details by ID
    $talentBooking = getTalentBookingById($bookingId);

    // Check if the talent booking exists
    if ($talentBooking) {
        // Handle talent booking deletion
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["deleteBooking"])) {
                // Perform the deletion of the talent booking from the database
                deleteTalentBooking($bookingId);

                // Redirect after deleting to avoid resubmission
                header("Location: bookings.php");
                exit();
            }
        }
    } else {
        // Redirect to a 404 page or handle the case when the talent booking doesn't exist
        header("Location: 404.php");
        exit();
    }
} else {
    // Redirect to a 404 page or handle the case when bookingId is not provided
    header("Location: 404.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Delete Talent Booking</title>
</head>
<body>
    <div class="header">
        <h1>Artist Hub</h1>
        <p>Welcome! <a href="logout.php">Logout</a></p>
    </div>

    <header>
        <nav>
            <a href="index.php">Home</a>
            <a href="talents.php">Talents</a>
            <a href="venues.php">Venues</a>
            <a href="bookings.php">Bookings</a>
        </nav>
    </header>

    <div class="container">
        <h2>Delete Talent Booking</h2>

        <p>Are you sure you want to delete the talent booking for "<?php echo $talentBooking['event_name']; ?>"?</p>

        <form method="post" action="delete_talent_booking.php?bookingId=<?php echo $talentBooking['booking_id']; ?>">
            <!-- Hidden input to confirm the deletion -->
            <input type="hidden" name="deleteBooking">

            <button type="submit">Yes, Delete</button>
            <a href="bookings.php">No, Cancel</a>
        </form>
    </div>
</body>
</html>
