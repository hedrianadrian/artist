<!-- updateVenue.php -->

<?php
include 'auth.php';
include_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["update"])) {
        $venueId = $_POST["venueId"];
        $venueName = $_POST["venueName"];
        $capacity = $_POST["capacity"];
        $location = $_POST["location"];
        $contactPerson = $_POST["contactPerson"];
        $contactPhone = $_POST["contactPhone"];

        updateVenue($venueId, $venueName, $capacity, $location, $contactPerson, $contactPhone);

        header("Location: admin_venues.php");
        exit();
    }
}

// Fetch venue details for pre-filling the form
if (isset($_GET['venue_id'])) {
    $venueId = $_GET['venue_id'];
    $venueDetails = getVenueDetails($venueId);
} else {
    // Redirect to venues page if venue_id is not provided
    header("Location: admin_venues.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Update Venue - Artist Hub Admin Dashboard</title>
</head>
<body>
    <div class="header">
        <h1>Artist Hub Admin Dashboard</h1>
        <p>Welcome <a href="logout.php">Logout</a></p>
    </div>

    <header>
        <nav>
            <a href="admin_dashboard.php">Admin Dashboard</a>
            <a href="admin_talents.php">Talents</a>
            <a href="admin_venues.php">Venues</a>
            <a href="admin_bookings.php">Bookings</a>
        </nav>
    </header>

    <div class="container">
        <h2>Update Venue</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="venueId" value="<?php echo $venueDetails['venue_id']; ?>">

            <label for="venueName">Venue Name:</label>
            <input type="text" id="venueName" name="venueName" value="<?php echo $venueDetails['venue_name']; ?>" required>

            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" value="<?php echo $venueDetails['capacity']; ?>" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo $venueDetails['location']; ?>" required>

            <label for="contactPerson">Contact Person:</label>
            <input type="text" id="contactPerson" name="contactPerson" value="<?php echo $venueDetails['contact_person']; ?>" required>

            <label for="contactPhone">Contact Phone:</label>
            <input type="tel" id="contactPhone" name="contactPhone" value="<?php echo $venueDetails['contact_phone']; ?>" required>

            <button type="submit" name="update">Update Venue</button>
        </form>
    </div>
</body>
</html>
