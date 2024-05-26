<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'auth.php';
include_once 'database.php';

// Check if the user is not logged in, redirect to index page
$venueBookings = getVenueBookings(); // Make sure you have the appropriate function defined in database.php

// Fetch venues from the database
$venues = getVenues();
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
        <h2>Venues</h2>

        <table>
            <thead>
                <tr>
                    <th>Venue Name</th>
                    <th>Capacity</th>
                    <th>Location</th>
                    <th>Contact Person</th>
                    <th>Contact Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($venues as $venue): ?>
                    <tr>
                        <td><?php echo $venue['venue_name']; ?></td>
                        <td><?php echo $venue['capacity']; ?></td>
                        <td><?php echo $venue['location']; ?></td>
                        <td><?php echo $venue['contact_person']; ?></td>
                        <td><?php echo $venue['contact_phone']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

</body>
</html>
