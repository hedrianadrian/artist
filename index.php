<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'auth.php';
include_once 'database.php';

// Check if the user is not logged in, redirect to index page
$venueBookings = getVenueBookings(); // Make sure you have the appropriate function defined in database.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Artist Hub</title>
    <style>

.about-us {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background-image: url("gb.png");
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.about-us h2 {
    text-align: center;
    font-size: 2em;
    color: #2c3e50;
    margin-bottom: 20px;
}

.about-us p {
    margin-bottom: 20px;
    text-align: justify;
    color: black;
}

    </style>
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

    <section class="about-us">
        <h2>About Us</h2>
        <p>Welcome to Artist Hub, the premier platform dedicated to connecting artists, performers, and art enthusiasts.</p>

        <p>Our mission is to create a vibrant and supportive community where creativity thrives and talent shines. We believe in the power of art to inspire, connect, and transform lives. Whether you're an artist looking to showcase your talents, a venue seeking exciting performances, or an art lover eager to explore and support the local arts scene, we have you covered.</p>

        <p>Explore our diverse range of talents, discover amazing venues, and stay updated on the latest events and bookings. Join us in celebrating the rich tapestry of artistic expression that makes our community unique.</p>

        <p>Thank you for being a part of Artist Hub. Together, let's create, inspire, and elevate the world of art.</p>
    </section>
</body>
</html>
