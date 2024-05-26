<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'auth.php';
include_once 'database.php';

$venueBookings = getVenueBookings();

// Check if the user is not logged in, redirect to index page
// (You may need to modify this part based on your authentication logic)
// ...

// Check if a bookingId is provided in the URL
if (isset($_GET['bookingId']) && !empty($_GET['bookingId'])) {
    $bookingId = $_GET['bookingId'];

    // Fetch the venue booking details by ID
    $venueBooking = getVenueBookingById($bookingId);

    // Check if the venue booking exists
    if ($venueBooking) {
        // Handle form submission for updating venue booking
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["updateBooking"])) {
                // Retrieve updated values from the form
                $eventName = $_POST["eventName"];
                $venueName = $_POST["venueName"];
                $startDate = $_POST["startDate"];
                $startTime = $_POST["startTime"];
                $endDate = $_POST["endDate"];
                $endTime = $_POST["endTime"];
                $equipmentNeeded = isset($_POST["equipmentNeeded"]) ? implode(", ", $_POST["equipmentNeeded"]) : "";
                $catering = isset($_POST["catering"]) ? $_POST["catering"] : "No";
                $status = 'pending';

                // Additional parameters
                $personInquiring = $_POST["personInquiring"];
                $titleRoleAffiliation = $_POST["titleRoleAffiliation"];
                $contactNumber = $_POST["contactNumber"];
                $dateOfBooking = $_POST["dateOfBooking"];

                // Update the venue booking in the database
                updateVenueBooking($bookingId, $eventName, $venueName, $startDate, $startTime, $endDate, $endTime, $equipmentNeeded, $catering, $status, $personInquiring, $titleRoleAffiliation, $contactNumber, $dateOfBooking);

                // Redirect after updating to avoid resubmission
                header("Location: bookings.php");
                exit();
            }
        }
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Update Venue Booking</title>
</head>
<body>
    <div class="header">
    <img src="logo.png" alt="Artist Hub Logo">
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
        <h2>Update Venue Booking</h2>

        <form method="post" action="update_venue_booking.php?bookingId=<?php echo $venueBooking['venue_booking_id']; ?>">
            <!-- Populate form fields with existing values -->

            <input type="hidden" name="bookingId" value="<?php echo $venueBooking['venue_booking_id']; ?>">
            
            <label for="personInquiring">Person Inquiring:</label>
            <input type="text" id="personInquiring" name="personInquiring" required>

            <label for="titleRoleAffiliation">Title/Role/Affiliation:</label>
            <input type="text" id="titleRoleAffiliation" name="titleRoleAffiliation" required>

            <label for="contactNumber">Contact Number:</label>
            <input type="tel" id="contactNumber" name="contactNumber" required>

            <label for="eventName">Event Name:</label>
            <input type="text" id="eventName" name="eventName" required value="<?php echo $venueBooking['event_name']; ?>">

            <label for="venueName">Venue Name:</label>
            <select id="venueName" name="venueName" required>
                <?php
                $venues = getVenues();
                foreach ($venues as $venue) {
                    echo "<option value='{$venue['venue_name']}'>{$venue['venue_name']}</option>";
                }
                ?>
            </select>

            <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" name="startDate" required value="<?php echo $venueBooking['start_date']; ?>">

            <label for="startTime">Start Time:</label>
            <input type="time" id="startTime" name="startTime" required value="<?php echo $venueBooking['start_time']; ?>">

            <label for="endDate">End Date:</label>
            <input type="date" id="endDate" name="endDate" required value="<?php echo $venueBooking['end_date']; ?>">

            <label for="endTime">End Time:</label>
            <input type="time" id="endTime" name="endTime" required value="<?php echo $venueBooking['end_time']; ?>">

            <label for="equipmentNeeded">Equipment Needed:</label>
            <div>
                <input type="checkbox" id="audio" name="equipmentNeeded[]" value="Audio" <?php if (strpos($venueBooking['equipment_needed'], 'Audio') !== false) echo 'checked'; ?>>
                <label for="audio">Audio</label>

                <input type="checkbox" id="lights" name="equipmentNeeded[]" value="Lights" <?php if (strpos($venueBooking['equipment_needed'], 'Lights') !== false) echo 'checked'; ?>>
                <label for="lights">Lights</label>

                <input type="checkbox" id="ledWall" name="equipmentNeeded[]" value="Led Wall" <?php if (strpos($venueBooking['equipment_needed'], 'Led Wall') !== false) echo 'checked'; ?>>
                <label for="ledWall">Led Wall</label>
            </div>

            <label>Would you like catering?</label>
            <div>
                <input type="radio" id="cateringYes" name="catering" value="Yes" <?php if ($venueBooking['catering'] === 'Yes') echo 'checked'; ?>>
                <label for="cateringYes">Yes</label>

                <input type="radio" id="cateringNo" name="catering" value="No" <?php if ($venueBooking['catering'] === 'No') echo 'checked'; ?>>
                <label for="cateringNo">No</label>
            </div>

            <label for="dateOfBooking">Date of Booking:</label>
            <input type="date" id="dateOfBooking" name="dateOfBooking" required>


            <button type="submit" name="updateBooking">Update Booking</button>
        </form>
    </div>
</body>
</html>
