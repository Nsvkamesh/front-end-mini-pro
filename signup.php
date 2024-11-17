<?php
// Database configuration
$servername = "localhost"; // Replace with your database server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "signup"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $dob = $_POST['Date_of_birth'];
    $password = $_POST['Password'];
    $confirm_password = $_POST['Confirm_Password'];

    // Validate the form data
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (name, email, dob, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $dob, $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            // Registration successful, redirect to home page
            header("Location: home.html");
            exit(); // Make sure to exit after redirection
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the connection
$conn->close();
?>
