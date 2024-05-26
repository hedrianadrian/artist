<?php
// addtalent.php

// Include necessary files and functions
include 'auth.php';
include_once 'database.php';

// Check if the user is not logged in, redirect to index page
$venueBookings = getVenueBookings(); // Make sure you have the appropriate function defined in database.php

// Handle talent addition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add"])) {
        $talentName = $_POST["talentName"];
        $talentSkill = $_POST["talentSkill"];
        $talentFee = $_POST["talentFee"];

        addTalent($talentName, $talentSkill, $talentFee);

        // Redirect to the talents page after adding talent
        header("Location: admin_talents.php");
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
    <title>Add Talent - Artist Hub Admin Dashboard</title>
</head>
<body>
    <div class="header">
    <img src="logo.png" alt="Artist Hub Logo">
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
        <h2>Add Talent</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="talentName">Talent Name:</label>
            <input type="text" id="talentName" name="talentName" required>

            <label for="talentSkill">Talent Skill:</label>
            <input type="text" id="talentSkill" name="talentSkill" required>

            <label for="talentFee">Talent Fee:</label>
            <input type="text" id="talentFee" name="talentFee" required>

            <button type="submit" name="add">Add Talent</button>
        </form>
    </div>
</body>
</html>
