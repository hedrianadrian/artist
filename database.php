<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "artisthub";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function addVenueBooking($personInquiring, $titleRoleAffiliation, $contactNumber, $eventName, $venueName, $startDate, $startTime, $endDate, $endTime, $equipmentString, $catering, $dateOfBooking, $status) {
    global $conn;

    $sql = "INSERT INTO venues_bookings (person_inquiring, title_role_affiliation, contact_number, event_name, venue_name, start_date, start_time, end_date, end_time, equipment_needed, catering, date_of_booking, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);

    // Check for errors in the preparation of the statement
    if (!$stmt) {
        die("Error in SQL query: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sssssssssssss", $personInquiring, $titleRoleAffiliation, $contactNumber, $eventName, $venueName, $startDate, $startTime, $endDate, $endTime, $equipmentString, $catering, $dateOfBooking, $status);

    // Execute the query
    $stmt->execute();

    // Close the statement
    $stmt->close();
}


function getVenueBookings() {
    global $conn;

    // Implement your SQL SELECT query here
    $sql = "SELECT * FROM venues_bookings LIMIT 10";

    $result = $conn->query($sql);

    if ($result) {
        // Fetch the results as an array
        $venueBookings = $result->fetch_all(MYSQLI_ASSOC);
        return $venueBookings;
    } else {
        // Handle the case where the query fails
        echo "Error: " . $conn->error;
        return array(); // Return an empty array if no results or an error occurs
    }
}






function getUsers() {
    global $conn;

    // Assuming you have a table named 'users'
    $sql = "SELECT user_id, username FROM users";
    $result = $conn->query($sql);

    $users = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    return $users;
}

function getAdmins() {
    global $conn;

    // Prepare SQL statement to retrieve admin information
    $sql = "SELECT * FROM admin";

    // Execute query
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result) {
        $admins = array();

        // Fetch data from the result set
        while ($row = $result->fetch_assoc()) {
            $admins[] = $row;
        }

        return $admins;
    } else {
        // Handle the query error if needed
        echo "Error: " . $conn->error;
        return array();
    }
}

function promoteUserToAdmin($user_id) {
    global $conn;

    // Move the user to the admin table
    $sql = "INSERT INTO admin (adminUsername, adminPassword) SELECT username, password FROM users WHERE user_id = $user_id";
    $conn->query($sql);

    // Delete the user from the users table
    $sql = "DELETE FROM users WHERE user_id = $user_id";
    $conn->query($sql);
}

function demoteAdminToUser($admin_id) {
    global $conn;

    // Move the admin to the users table
    $sql = "INSERT INTO users (username, password) SELECT adminUsername, adminPassword FROM admin WHERE admin_id = $admin_id";
    $conn->query($sql);

    // Delete the admin from the admin table
    $sql = "DELETE FROM admin WHERE admin_id = $admin_id";
    $conn->query($sql);
}

function deleteUser($user_id) {
    global $conn;

    // Delete the user from the users table
    $sql = "DELETE FROM users WHERE user_id = $user_id";
    $conn->query($sql);
}


function addTalent($talentName, $talentSkill, $talentFee) {
    global $conn;

    $sql = "INSERT INTO talents (talent_name, talent_skill, talent_fee) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $talentName, $talentSkill, $talentFee);
    $stmt->execute();
    $stmt->close();
}

function updateTalent($talentId, $talentName, $talentSkill, $talentFee) {
    global $conn;

    // Set a default value for talent_fee if it's empty
    $talentFee = ($talentFee === '') ? 0.00 : $talentFee;

    $sql = "UPDATE talents SET talent_name = ?, talent_skill = ?, talent_fee = ? WHERE talent_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdi", $talentName, $talentSkill, $talentFee, $talentId);
    
    $stmt->execute();
    $stmt->close();
}

function deleteTalent($talentId) {
    global $conn;

    $sql = "DELETE FROM talents WHERE talent_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $talentId);
    $stmt->execute();
    $stmt->close();
}

function getTalents() {
    global $conn;

    $talents = array();

    $sql = "SELECT * FROM talents";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $talents[] = $row;
        }
    }

    return $talents;
}

function getTalentDetails($talentId) {
    global $conn;

    $sql = "SELECT * FROM talents WHERE talent_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $talentId);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}


function deleteVenue($venueId) {
    global $conn;

    $sql = "DELETE FROM venues WHERE venue_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $venueId);
    $stmt->execute();
    $stmt->close();
}


function getVenues() {
    global $conn;

    $venues = array();

    $sql = "SELECT * FROM venues";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $venues[] = $row;
        }
    }

    return $venues;
}

function getVenueDetails($venueId) {
    global $conn;

    $sql = "SELECT * FROM venues WHERE venue_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $venueId);
    $stmt->execute();
    $result = $stmt->get_result();
    $venueDetails = $result->fetch_assoc();
    $stmt->close();

    return $venueDetails;
}

function addVenue($venueName, $capacity, $location, $contactPerson, $contactPhone) {
    global $conn;

    $sql = "INSERT INTO venues (venue_name, capacity, location, contact_person, contact_phone) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissi", $venueName, $capacity, $location, $contactPerson, $contactPhone);
    $stmt->execute();
    $stmt->close();
}

function updateVenue($venueId, $venueName, $capacity, $location, $contactPerson, $contactPhone) {
    global $conn;

    $sql = "UPDATE venues SET venue_name = ?, capacity = ?, location = ?, contact_person = ?, contact_phone = ? WHERE venue_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissii", $venueName, $capacity, $location, $contactPerson, $contactPhone, $venueId);
    $stmt->execute();
    $stmt->close();
}

// Other functions...

function getTalentsDropdown() {
    global $conn;

    $talents = array();

    $sql = "SELECT talent_id, talent_name FROM talents";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $talents[] = $row;
        }
    }

    return $talents;
}
// 

function addBooking($eventName, $talentId, $date, $time, $personInquiring, $titleRoleAffiliation, $contactNumber, $dateOfBooking, $status) {
    global $conn;

    // Format the date to 'YYYY-MM-DD'
    $formattedDate = date('Y-m-d', strtotime($date));
    $formattedDateOfBooking = date('Y-m-d', strtotime($dateOfBooking));

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO talents_bookings (event_name, talent_id, date, time, status, person_inquiring, title_role_affiliation, contact_number, date_of_booking) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Error in SQL query: " . $conn->error);
    }

    $stmt->bind_param("sisssssss", $eventName, $talentId, $formattedDate, $time, $status, $personInquiring, $titleRoleAffiliation, $contactNumber, $formattedDateOfBooking);

    // Execute the statement
    $stmt->execute();

    // Close the statement
    $stmt->close();
}




function getBookings() {
    global $conn;

    $bookings = array();

    $sql = "SELECT * FROM talents_bookings";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
    }

    return $bookings;
}

function getTalentNameById($talentId) {
    global $conn;

    $sql = "SELECT talent_name FROM talents WHERE talent_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $talentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $talentName = $row['talent_name'];
    $stmt->close();

    return $talentName;
}


function updateBookingStatus($bookingId, $status) {
    global $conn;

    $sql = "UPDATE talents_bookings SET status = ? WHERE booking_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $bookingId);
    $stmt->execute();
    $stmt->close();
    
}

function updateVenueBookingStatus($bookingId, $status) {
    global $conn;

    $sql = "UPDATE venues_bookings SET status = ? WHERE venue_booking_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $bookingId);

    if ($stmt->execute()) {
        echo "Status updated successfully"; // Add this line for debugging
    } else {
        echo "Error updating status: " . $stmt->error; // Add this line for debugging
    }

    $stmt->close();
}

function getTalentBookingById($bookingId) {
    global $conn;

    $sql = "SELECT * FROM talents_bookings WHERE booking_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query: " . $conn->error);
    }

    $stmt->bind_param("i", $bookingId);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $talentBooking = $result->fetch_assoc();
        $stmt->close();
        return $talentBooking;
    } else {
        $stmt->close();
        return false; // Talent booking not found
    }
}

// Function to update talent booking in the database
function updateTalentBooking($bookingId, $eventName, $talentId, $date, $time, $personInquiring, $titleRoleAffiliation, $contactNumber, $dateOfBooking, $status) {
    global $conn;

    $sql = "UPDATE talents_bookings SET 
            event_name = ?,
            talent_id = ?,
            date = ?,
            time = ?,
            person_inquiring = ?,
            title_role_affiliation = ?,
            contact_number = ?,
            date_of_booking = ?,
            status = 'pending'  -- Set the default status here
            WHERE booking_id = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query: " . $conn->error);
    }

    $stmt->bind_param("ssssssssi", $eventName, $talentId, $date, $time, $personInquiring, $titleRoleAffiliation, $contactNumber, $dateOfBooking, $bookingId);
    $stmt->execute();
    $stmt->close();
}

function deleteTalentBooking($bookingId) {
    global $conn;

    // SQL query to delete the talent booking by ID
    $sql = "DELETE FROM talents_bookings WHERE booking_id = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query: " . $conn->error);
    }

    // Bind the parameter and execute the statement
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();
    $stmt->close();
}

// Function to update venue booking details
function updateVenueBooking($bookingId, $eventName, $venueName, $startDate, $startTime, $endDate, $endTime, $equipmentNeeded, $catering, $status, $personInquiring, $titleRoleAffiliation, $contactNumber, $dateOfBooking) {
    global $conn;

    $sql = "UPDATE venues_bookings SET 
            event_name = ?,
            venue_name = ?,
            start_date = ?,
            start_time = ?,
            end_date = ?,
            end_time = ?,
            equipment_needed = ?,
            catering = ?,
            status = ?,
            person_inquiring = ?,
            title_role_affiliation = ?,
            contact_number = ?,
            date_of_booking = ?
            WHERE venue_booking_id = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query: " . $conn->error);
    }

    $stmt->bind_param("sssssssssssssi", $eventName, $venueName, $startDate, $startTime, $endDate, $endTime, $equipmentNeeded, $catering, $status, $personInquiring, $titleRoleAffiliation, $contactNumber, $dateOfBooking, $bookingId);
    $stmt->execute();
    $stmt->close();
}



function getVenueBookingById($bookingId) {
    global $conn;

    // SQL query to retrieve venue booking details
    $sql = "SELECT * FROM venues_bookings WHERE venue_booking_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query: " . $conn->error);
    }

    // Bind the parameter and execute the statement
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch the venue booking details as an associative array
    $venueBooking = $result->fetch_assoc();

    // Close the statement
    $stmt->close();

    return $venueBooking;
}

function getVenueBookingDetails($venueBookingId) {
    global $conn;

    // Implement your SQL SELECT query to retrieve details by venue_booking_id
    $sql = "SELECT * FROM venues_bookings WHERE venue_booking_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $venueBookingId);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $venueBookingDetails = $result->fetch_assoc();

        // Explode equipment_needs into an array
        $venueBookingDetails['equipment_needs'] = explode(', ', $venueBookingDetails['equipment_needs']);

        return $venueBookingDetails;
    } else {
        return null; // Return null if no results
    }
}

function deleteVenueBooking($bookingId) {
    global $conn;

    $sql = "DELETE FROM venues_bookings WHERE venue_booking_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query: " . $conn->error);
    }

    $stmt->bind_param("i", $bookingId);
    $stmt->execute();
    $stmt->close();
}
?>

