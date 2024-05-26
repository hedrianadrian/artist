<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'auth.php';
include_once 'database.php';

$talentsDropdown = getTalentsDropdown();

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
        // Handle form submission for updating talent booking
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["updateBooking"])) {
                // Retrieve updated values from the form
                $eventName = $_POST["eventName"];
                $talentId = $_POST["talentId"];
                $date = $_POST["date"];
                $time = $_POST["time"];
                $personInquiring = $_POST["personInquiring"];
                $titleRoleAffiliation = $_POST["titleRoleAffiliation"];
                $contactNumber = $_POST["contactNumber"];
                $dateOfBooking = $_POST["dateOfBooking"];
                $status = 'pending';

        // Update the talent booking in the database
        updateTalentBooking($bookingId, $eventName, $talentId, $date, $time, $personInquiring, $titleRoleAffiliation, $contactNumber, $dateOfBooking, $status);

        // Redirect after updating to avoid resubmission
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
    <title>Update Talent Booking</title>
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
        <h2>Update Talent Booking</h2>

        <form method="post" action="update_talent_booking.php?bookingId=<?php echo $talentBooking['booking_id']; ?>">
            <!-- Populate form fields with existing values -->
            <input type="hidden" name="bookingId" value="<?php echo $talentBooking['booking_id']; ?>">

            <label for="personInquiring">Person Inquiring:</label>
            <input type="text" id="personInquiring" name="personInquiring" required value="<?php echo $talentBooking['person_inquiring']; ?>">

            <label for="titleRoleAffiliation">Title/Role/Affiliation:</label>
            <input type="text" id="titleRoleAffiliation" name="titleRoleAffiliation" required value="<?php echo $talentBooking['title_role_affiliation']; ?>">

            <label for="contactNumber">Contact Number:</label>
            <input type="tel" id="contactNumber" name="contactNumber" required value="<?php echo $talentBooking['contact_number']; ?>">

            <label for="eventName">Event Name:</label>
            <input type="text" id="eventName" name="eventName" required value="<?php echo $talentBooking['event_name']; ?>">

            <label for="talentId">Talent:</label>
            <select id="talentId" name="talentId" required>
                <?php foreach ($talentsDropdown as $talent): ?>
                    <option value="<?php echo $talent['talent_id']; ?>" <?php if ($talent['talent_id'] == $talentBooking['talent_id']) echo "selected"; ?>>
                        <?php echo $talent['talent_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="date">Event Date:</label>
            <input type="date" id="date" name="date" required value="<?php echo $talentBooking['date']; ?>">

            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required value="<?php echo $talentBooking['time']; ?>">

            <label for="dateOfBooking">Date of Booking:</label>
            <input type="date" id="dateOfBooking" name="dateOfBooking" required value="<?php echo $talentBooking['date_of_booking']; ?>">

        

            <button type="submit" name="updateBooking">Update Booking</button>

        </form>
    </div>
</body>
</html>
