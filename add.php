<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'auth.php';
include_once 'database.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_venue_booking"])) {
    $eventName = $_POST["event_name"];
    $venueName = $_POST["venue_name"];
    $startDate = $_POST["start_date"];
    $startTime = $_POST["start_time"];
    $endDate = $_POST["end_date"];
    $endTime = $_POST["end_time"];
    $numAttendees = $_POST["num_attendees"];
    $equipmentNeeds = isset($_POST["equipment_needs"]) ? $_POST["equipment_needs"] : array();
    $catering = isset($_POST["catering"]) ? $_POST["catering"] : 'No';

    $result = addVenueBooking($eventName, $venueName, $startDate, $startTime, $endDate, $endTime, $numAttendees, $equipmentNeeds, $catering);

    if ($result) {
        header("Location: index.php");
        exit();
    } else {
        $addError = "Failed to add venue booking. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Venue Booking</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<   <div class="header">
<img src="logo.png" alt="Artist Hub Logo">
        <p>Welcome!     <a href="logout.php">Logout</a></p>
    </div>

    <div class="container">
        <h2>Add Venue Booking</h2>
        <?php
        if (isset($addError)) {
            echo "<p style='color: red;'>$addError</p>";
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="event_name">Event Name:</label>
            <input type="text" id="event_name" name="event_name" required>

            <label for="venue_name">Venue Name:</label>
            <!-- Dropdown Box for Venue -->
            <select id="venue_name" name="venue_name" required>
                <option value="Coliseum">Coliseum</option>
                <option value="Amphitheater">Amphitheater</option>
                <option value="Auditorium">Auditorium</option>
                <option value="Cinema">Cinema</option>
                <option value="Arena">Arena</option>
            </select>

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="start_time">Start Time:</label>
            <input type="time" id="start_time" name="start_time" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>

            <label for="end_time">End Time:</label>
            <input type="time" id="end_time" name="end_time" required>

            <label for="num_attendees">Number of Attendees:</label>
            <input type="number" id="num_attendees" name="num_attendees" required>

            <label for="equipment_needs">Equipment Needs:</label>
            <!-- Checklist for Equipment Needs -->
            <input type="checkbox" id="audio" name="equipment_needs[]" value="Audio">
            <label for="audio">Audio & Sounds</label>
            <input type="checkbox" id="sounds" name="equipment_needs[]" value="Sounds">
            <label for="sounds">Lights</label>
            <input type="checkbox" id="led_wall" name="equipment_needs[]" value="Led Wall">
            <label for="led_wall">Led Wall</label>

            <label>Catering:</label>
            <label for="catering_yes">Yes</label>
            <input type="radio" id="catering_yes" name="catering" value="Yes">
            <label for="catering_no">No</label>
            <input type="radio" id="catering_no" name="catering" value="No" checked>

            <button type="submit" name="add_venue_booking">Add Venue Booking</button>
        </form>
    </div>
</body>
</html>
