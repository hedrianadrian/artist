<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'auth.php';
include_once 'database.php';

// Check if the user is not logged in, redirect to index page
$venueBookings = getVenueBookings(); // Make sure you have the appropriate function defined in database.php

// Fetch talents from the database
$talents = getTalents();
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

    <section>
        <h2>Talents</h2>

        <table>
            <thead>
                <tr>
                    <th>Talent Name</th>
                    <th>Talent Skill</th>
                    <th>Talent Fee</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($talents as $talent): ?>
                    <tr>
                        <td><?php echo $talent['talent_name']; ?></td>
                        <td><?php echo $talent['talent_skill']; ?></td>
                        <td><?php echo $talent['talent_fee']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

</body>
</html>
