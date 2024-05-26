<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Function to check if a user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function login($username, $password) {
    global $conn;

    $hashedPassword = hash('sha256', $password); // Basic hashing, improve as needed

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$hashedPassword'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login successful
        return true;
    } else {
        // Invalid username or password
        return false;
    }
}

function register($username, $password) {
    global $conn;

    $hashedPassword = hash('sha256', $password);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";
    $result = $conn->query($sql);

    return $result;
}

function logout() {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page after logout
    header("Location: login.php");
    exit();
}


// Add this function in your auth.php file
function adminLogin($adminUsername, $adminPassword) {
    global $conn;

    // Prepare SQL statement to retrieve admin information
    $sql = "SELECT * FROM admin WHERE adminUsername = ?";

    // Bind parameters and execute query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $adminUsername);
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Check if admin exists
    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        var_dump($admin); // Output the admin array for debugging

        // Check if the password matches
        if ($adminPassword === $admin['adminPassword']) {
            return true; // Admin login successful
        } else {
            echo "Password verification failed (direct comparison)<br>";
        }
    } else {
        echo "Admin not found<br>";
    }

    return false; // Admin login failed
}

?>
