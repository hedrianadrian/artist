<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'auth.php';
include_once 'database.php';

// Check if the user is not logged in, redirect to login page

// Check if venue_booking_id is provided in the URL
if (isset($_GET['id'])) {
    $venueBookingId = $_GET['id'];

    // Retrieve venue booking details for the given venue_booking_id
    $venueBookingDetails = getVenueBookingDetails($venueBookingId);

    // Check if the venue booking exists
    if ($venueBookingDetails) {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_venue_booking"])) {
            // Extract updated data from the form
            $eventName = $_POST["event_name"];
            $venueName = $_POST["venue_name"];
            $startDate = $_POST["start_date"];
            $startTime = $_POST["start_time"];
            $endDate = $_POST["end_date"];
            $endTime = $_POST["end_time"];
            $numAttendees = $_POST["num_attendees"];
            $equipmentNeeds = isset($_POST["equipment_needs"]) ? $_POST["equipment_needs"] : array();
            $catering = isset($_POST["catering"]) ? $_POST["catering"] : 'No';

            // Update the venue booking
            $result = updateVenueBooking($venueBookingId, $eventName, $venueName, $startDate, $startTime, $endDate, $endTime, $numAttendees, $equipmentNeeds, $catering);

            if ($result) {
                header("Location: index.php");
                exit();
            } else {
                $updateError = "Failed to update venue booking. Please try again.";
            }
        }
    } else {
        // Venue booking not found, redirect to index page
        header("Location: index.php");
        exit();
    }
} else {
    // Redirect to index page if venue_booking_id is not provided
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Venue Booking</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <h1>Artist Hub</h1>
        <p>Welcome <a href="logout.php">Logout</a></p>
    </div>

    <div class="container">
        <h2>Update Venue Booking</h2>
        <?php
        if (isset($updateError)) {
            echo "<p style='color: red;'>$updateError</p>";
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $venueBookingId); ?>">
            <!-- Include input fields with current venue booking details -->
            <!-- Update the input values based on the $venueBookingDetails array -->
            <label for="event_name">Event Name:</label>
            <input type="text" id="event_name" name="event_name" value="<?php echo $venueBookingDetails['event_name']; ?>" required>

            <label for="venue_name">Venue Name:</label>
            <!-- Include a dropdown box for Venue with selected value -->
            <select id="venue_name" name="venue_name" required>
                <!-- Add options for Venue, mark the selected one based on $venueBookingDetails['venue_name'] -->
                <option value="Coliseum" <?php echo ($venueBookingDetails['venue_name'] == 'Coliseum') ? 'selected' : ''; ?>>Coliseum</option>
                <option value="Amphitheater" <?php echo ($venueBookingDetails['venue_name'] == 'Amphitheater') ? 'selected' : ''; ?>>Amphitheater</option>
                <option value="Auditorium" <?php echo ($venueBookingDetails['venue_name'] == 'Auditorium') ? 'selected' : ''; ?>>Auditorium</option>
                <option value="Cinema" <?php echo ($venueBookingDetails['venue_name'] == 'Cinema') ? 'selected' : ''; ?>>Cinema</option>
                <option value="Arena" <?php echo ($venueBookingDetails['venue_name'] == 'Arena') ? 'selected' : ''; ?>>Arena</option>
            </select>

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo $venueBookingDetails['start_date']; ?>" required>

            <label for="start_time">Start Time:</label>
            <input type="time" id="start_time" name="start_time" value="<?php echo $venueBookingDetails['start_time']; ?>" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo $venueBookingDetails['end_date']; ?>" required>

            <label for="end_time">End Time:</label>
            <input type="time" id="end_time" name="end_time" value="<?php echo $venueBookingDetails['end_time']; ?>" required>

            <label for="num_attendees">Number of Attendees:</label>
            <input type="number" id="num_attendees" name="num_attendees" value="<?php echo $venueBookingDetails['num_attendees']; ?>" required>

            <label for="equipment_needs">Equipment Needs:</label>
            
<!-- Include checkboxes for Equipment Needs with checked values based on $venueBookingDetails['equipment_needs'] -->
<label for="audio">Audio</label>
<input type="checkbox" id="audio" name="equipment_needs[]" value="Audio" <?php echo (in_array('Audio', $venueBookingDetails['equipment_needs'])) ? 'checked' : ''; ?>>
<label for="sounds">Sounds</label>
<input type="checkbox" id="sounds" name="equipment_needs[]" value="Sounds" <?php echo (in_array('Sounds', $venueBookingDetails['equipment_needs'])) ? 'checked' : ''; ?>>
<label for="led_wall">Led Wall</label>
<input type="checkbox" id="led_wall" name="equipment_needs[]" value="Led Wall" <?php echo (in_array('Led Wall', $venueBookingDetails['equipment_needs'])) ? 'checked' : ''; ?>>


            <label>Catering:</label>
            <!-- Include radio buttons for Catering with checked value based on $venueBookingDetails['catering'] -->
            <label for="catering_yes">Yes</label>
            <input type="radio" id="catering_yes" name="catering" value="Yes" <?php echo ($venueBookingDetails['catering'] == 'Yes') ? 'checked' : ''; ?>>
            <label for="catering_no">No</label>
            <input type="radio" id="catering_no" name="catering" value="No" <?php echo ($venueBookingDetails['catering'] == 'No') ? 'checked' : ''; ?>>

            <!-- Add the Update Venue Booking button -->
            <button type="submit" name="update_venue_booking">Update Venue Booking</button>
        </form>
    </div>
</body>
</html>
