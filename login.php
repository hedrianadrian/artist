<?php
include 'database.php';
include 'auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $loginResult = login($username, $password);

    if ($loginResult) {
        header("Location: index.php");
        exit();
    } else {
        $loginError = "Invalid username or password";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["adminLogin"])) {
    $adminUsername = $_POST["adminUsername"];
    $adminPassword = $_POST["adminPassword"];

    $adminLoginResult = adminLogin($adminUsername, $adminPassword);

    if ($adminLoginResult) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $adminLoginError = "Invalid admin credentials";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Artist Hub</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 500px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label, button {
            margin-bottom: 15px;
            padding: 10px;
            box-sizing: border-box;
            color: white;
            text-align; center;
        }

        input {
            color: black;
        }

        button {
            background-color: #4CAF50; /* Green */
            color: white;
            border: none;
            padding: 12px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        p {
            text-align: center;
            margin-top: 15px;
            color:#14c91a;

        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        
        <?php
        if (isset($loginError)) {
            echo "<p style='color: red;'>$loginError</p>";
        }
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="login">Login</button>
        </form>

        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>

    <div class="container">
        <h2>Admin Login</h2>
        
        <?php
        if (isset($adminLoginError)) {
            echo "<p style='color: red;'>$adminLoginError</p>";
        }
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="adminUsername">Admin Username:</label>
            <input type="text" id="adminUsername" name="adminUsername" required>

            <label for="adminPassword">Admin Password:</label>
            <input type="password" id="adminPassword" name="adminPassword" required>

            <button type="submit" name="adminLogin">Admin Login</button>
        </form>
    </div>

</body>
</html>