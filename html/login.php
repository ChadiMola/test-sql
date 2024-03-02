<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tunisietelecome";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the form data
$nom = $_POST['username'];
$mot_de_passe = $_POST['password'];

// SQL SELECT statement
$sql = "SELECT * FROM `utilisateur` WHERE `nom`='$nom' AND `mot_de_passe`='$mot_de_passe'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User found, start a session and store the user's ID in a session variable
    session_start();
    $row = $result->fetch_assoc();
    $_SESSION['id_utilisateur'] = $row['id'];

    // Redirect to dashboard
    header("Location: dashboard.php");
    exit();
} else {
    // User not found, redirect back to login with error message
    header("Location: login.html?error=Invalid username or password");
    exit();
}

$conn->close();
?>