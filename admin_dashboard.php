<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'auth.php';
include_once 'database.php';

// Check if the user is not logged in, redirect to index page
$venueBookings = getVenueBookings(); // Make sure you have the appropriate function defined in database.php


// Fetch users from the database
$users = getUsers(); // Make sure you have the appropriate function defined in database.php
$admins = getAdmins();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Artist Hub Admin Dashboard</title>
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
            <a href="admin_bookings.php">Talent Bookings</a>
            <a href="admin_bookings2.php">Venue Bookings</a>

        </nav>
    </header>

    <div class="container">
    <h2>User Management</h2>

    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['user_id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td>
                        <form action="admin_manage_user.php" method="post" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                            <button type="submit" name="promote">Promote</button>
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="register.php"><button>Add User</button></a>
</div>

<div class="container">
    <h2>Admin Management</h2>

    <table>
        <thead>
            <tr>
                <th>Admin ID</th>
                <th>Admin Username</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admins as $admin): ?>
                <tr>
                    <td><?php echo $admin['admin_id']; ?></td>
                    <td><?php echo $admin['adminUsername']; ?></td>
                    <td>
                        <form action="admin_manage_user.php" method="post" onsubmit="return confirm('Are you sure you want to demote this admin?');">
                            <input type="hidden" name="admin_id" value="<?php echo $admin['admin_id']; ?>">
                            <button type="submit" name="demote">Demote</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


</body>
</html>




