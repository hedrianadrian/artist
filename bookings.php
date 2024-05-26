<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'auth.php';
include_once 'database.php';

// Check if the user is not logged in, redirect to index page
$venueBookings = getVenueBookings(); // Make sure you have the appropriate function defined in database.php

// Fetch talents for dropdown
$talentsDropdown = getTalentsDropdown();


// Handle venue booking addition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submitBooking"])) {
        $eventName = $_POST["eventName"];
        $talentId = $_POST["talentId"];
        $date = $_POST["date"];
        $time = $_POST["time"];
        $personInquiring = $_POST["personInquiring"];
        $titleRoleAffiliation = $_POST["titleRoleAffiliation"];
        $contactNumber = $_POST["contactNumber"];
        $dateOfBooking = $_POST["dateOfBooking"];
        $status = "pending";

        // Modify the addBooking function in database.php to handle the new fields
        addBooking($eventName, $talentId, $date, $time, $personInquiring, $titleRoleAffiliation, $contactNumber, $dateOfBooking, $status);

        // Add a confirmation message
        $confirmationMessage = "Booking successfully submitted!";

    } elseif (isset($_POST["bookVenue"])) {
        $eventName = $_POST["eventName"];
        $venueName = $_POST["venueName"];
        $startDate = $_POST["startDate"];
        $startTime = $_POST["startTime"];
        $endDate = $_POST["endDate"];
        $endTime = $_POST["endTime"];
        $equipmentNeeded = isset($_POST["equipmentNeeded"]) ? $_POST["equipmentNeeded"] : [];
    
    // Implode the array to form the $equipmentString
        $equipmentString = implode(', ', $equipmentNeeded);
        $catering = isset($_POST["catering"]) ? $_POST["catering"] : "No";
        $personInquiring = $_POST["personInquiring"];
        $titleRoleAffiliation = $_POST["titleRoleAffiliation"];
        $contactNumber = $_POST["contactNumber"];
        $dateOfBooking = $_POST["dateOfBooking"];
        $status = "pending";

        // Modify the addVenueBooking function in database.php to handle the new fields
        addVenueBooking($personInquiring, $titleRoleAffiliation, $contactNumber, $eventName, $venueName, $startDate, $startTime, $endDate, $endTime, $equipmentString, $catering, $dateOfBooking, $status);
        // Redirect after form submission to avoid resubmission
        header("Location: bookings.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Artist Hub</title>
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
    <h2>Book Talent</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <label for="personInquiring">Person Inquiring:</label>
        <input type="text" id="personInquiring" name="personInquiring" required>

        <label for="titleRoleAffiliation">Title/Role/Affiliation:</label>
        <input type="text" id="titleRoleAffiliation" name="titleRoleAffiliation" required>

        <label for="contactNumber">Contact Number:</label>
        <input type="tel" id="contactNumber" name="contactNumber" required>

        <label for="eventName">Event Name:</label>
        <input type="text" id="eventName" name="eventName" required>

        <label for="talentId">Talent:</label>
        <select id="talentId" name="talentId" required>
            <?php foreach ($talentsDropdown as $talent): ?>
                <option value="<?php echo $talent['talent_id']; ?>"><?php echo $talent['talent_name']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="date">Event Date:</label>
        <input type="date" id="date" name="date" required value="<?php echo date('Y-m-d'); ?>">

        <label for="time">Time:</label>
        <input type="time" id="time" name="time" required>

        <label for="dateOfBooking">Date of Booking:</label>
        <input type="date" id="dateOfBooking" name="dateOfBooking" required value="<?php echo date('Y-m-d'); ?>">

        <button type="submit" name="submitBooking">Submit Booking</button>
        
    </form>
</div>

    <section>
        <h2>Talent Bookings</h2>

        <table>
            <thead>
                <tr>
                    <th>Person Inquiring</th>
                    <th>Title/Role/Affiliation</th>
                    <th>Contact Number</th>
                    <th>Event Name</th>
                    <th>Talent</th>
                    <th>Event Date</th>
                    <th>Time</th>
                    <th>Date of Booking</th>
                    <th>Status</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php $bookings = getBookings(); ?>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo $booking['person_inquiring']; ?></td>
                        <td><?php echo $booking['title_role_affiliation']; ?></td>
                        <td><?php echo $booking['contact_number']; ?></td>
                        <td><?php echo $booking['event_name']; ?></td>
                        <td><?php echo getTalentNameById($booking['talent_id']); ?></td>
                        <td><?php echo $booking['date']; ?></td>
                        <td><?php echo $booking['time']; ?></td>
                        <td><?php echo $booking['date_of_booking']; ?></td>
                        <td><?php echo $booking['status']; ?></td>
                        <td>
                        <!-- Update button -->
                        <a href="update_talent_booking.php?bookingId=<?php echo $booking['booking_id']; ?>">Update</a>
                        
                        <!-- Delete button -->
                        <a href="delete_talent_booking.php?bookingId=<?php echo $booking['booking_id']; ?>" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <div class="container">
        <h2>Book Venue</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Your form fields go here -->
            <label for="personInquiring">Person Inquiring:</label>
            <input type="text" id="personInquiring" name="personInquiring" required>

            <label for="titleRoleAffiliation">Title/Role/Affiliation:</label>
            <input type="text" id="titleRoleAffiliation" name="titleRoleAffiliation" required>

            <label for="contactNumber">Contact Number:</label>
            <input type="tel" id="contactNumber" name="contactNumber" required>

            <label for="eventName">Event Name:</label>
            <input type="text" id="eventName" name="eventName" required>

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
            <input type="date" id="startDate" name="startDate" required>

            <label for="startTime">Start Time:</label>
            <input type="time" id="startTime" name="startTime" required>

            <label for="endDate">End Date:</label>
            <input type="date" id="endDate" name="endDate" required>

            <label for="endTime">End Time:</label>
            <input type="time" id="endTime" name="endTime" required>

            <label for="equipmentNeeded">Equipment Needed:</label>
            <div>
            <input type="checkbox" id="audio" name="equipmentNeeded[]" value="Audio">
            <label for="audio">Audio</label>
            <input type="checkbox" id="lights" name="equipmentNeeded[]" value="Lights">
            <label for="lights">Lights</label>
            <input type="checkbox" id="ledWall" name="equipmentNeeded[]" value="Led Wall">
            <label for="ledWall">Ledwall</label>
            <input type="checkbox" id="NoNeed" name="equipmentNeeded[]" value="No Need">
            <label for="NoNeed">No Tech Needs</label>
            </div>

            <label>Would you like catering?</label>
            <div>
                <input type="radio" id="cateringYes" name="catering" value="Yes">
                <label for="cateringYes">Yes</label>

                <input type="radio" id="cateringNo" name="catering" value="No" checked>
                <label for="cateringNo">No</label>
            </div>

            <label for="dateOfBooking">Date of Booking:</label>
            <input type="date" id="dateOfBooking" name="dateOfBooking" required>

            <button type="submit" name="bookVenue">Book Venue</button>
        </form>
    </div>

                <!-- Display Venue Bookings -->
        <h2>Venue Bookings</h2>
        <table>
            <thead>
                <tr>
                    <th>Person Inquiring</th>
                    <th>Title/Role/Affiliation</th>
                    <th>Contact Number</th>
                    <th>Event Name</th>
                    <th>Venue Name</th>
                    <th>Start Date</th>
                    <th>Start Time</th>
                    <th>End Date</th>
                    <th>End Time</th>
                    <th>Equipment Needed</th>
                    <th>Catering</th>
                    <th>Date of Booking</th>
                    <th>Status</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($venueBookings as $booking): ?>
                    <tr>
                        <td><?php echo $booking['person_inquiring']; ?></td>
                        <td><?php echo $booking['title_role_affiliation']; ?></td>
                        <td><?php echo $booking['contact_number']; ?></td>
                        <td><?php echo $booking['event_name']; ?></td>
                        <td><?php echo $booking['venue_name']; ?></td>
                        <td><?php echo $booking['start_date']; ?></td>
                        <td><?php echo $booking['start_time']; ?></td>
                        <td><?php echo $booking['end_date']; ?></td>
                        <td><?php echo $booking['end_time']; ?></td>
                        <td><?php echo $booking['equipment_needed']; ?></td>
                        <td><?php echo $booking['catering']; ?></td>
                        <td><?php echo $booking['date_of_booking']; ?></td>
                        <td><?php echo $booking['status']; ?></td>
                        <td>
                        <!-- Update button -->
                        <a href="update_venue_booking.php?bookingId=<?php echo $booking['venue_booking_id']; ?>">Update</a>
                        
                        <!-- Delete button -->
                        <a href="delete_venue_booking.php?bookingId=<?php echo $booking['venue_booking_id']; ?>" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
</body>
</html>
