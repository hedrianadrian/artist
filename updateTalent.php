<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'auth.php';
include_once 'database.php';

// Check if the user is not logged in, redirect to index page
$venueBookings = getVenueBookings(); // Make sure you have the appropriate function defined in database.php

// Fetch talents from the database
$talents = getTalents();

// Check if talent_id is provided in the URL
if (isset($_GET['talent_id'])) {
    $talentId = $_GET['talent_id'];

    // Fetch the talent details for the specified talent_id
    $talentDetails = getTalentDetails($talentId);

    // Handle talent update
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $talentName = isset($_POST["talentName"]) ? $_POST["talentName"] : $talentDetails['talent_name'];
        $talentSkill = isset($_POST["talentSkill"]) ? $_POST["talentSkill"] : $talentDetails['talent_skill'];
        $talentFee = isset($_POST["talentFee"]) ? $_POST["talentFee"] : $talentDetails['talent_fee'];

        updateTalent($talentId, $talentName, $talentSkill, $talentFee);

        // Redirect to talents page after updating talent
        header("Location: admin_talents.php");
        exit();
    }
} else {
    // If talent_id is not provided, redirect to talents page
    header("Location: admin_talents.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Update Talent - Artist Hub Admin Dashboard</title>
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
        <h2>Update Talent</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?talent_id=" . $talentId; ?>">
            <label for="talentName">Talent Name:</label>
            <input type="text" id="talentName" name="talentName" value="<?php echo $talentDetails['talent_name']; ?>" required>

            <label for="talentSkill">Talent Skill:</label>
            <input type="text" id="talentSkill" name="talentSkill" value="<?php echo $talentDetails['talent_skill']; ?>" required>

            <label for="talentFee">Talent Fee:</label>
            <input type="text" id="talentFee" name="talentFee" value="<?php echo $talentDetails['talent_fee']; ?>" required>

            <button type="submit" name="update">Update Talent</button>
        </form>
    </div>
</body>
</html>
