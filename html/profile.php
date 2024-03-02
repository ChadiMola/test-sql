<?php
// Start the session at the beginning of the script
session_start();

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

$id_utilisateur = $_SESSION['id_utilisateur'];

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the new email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL UPDATE statement
    $sql = "UPDATE `utilisateur` SET `email`='$email', `mot_de_passe`='$password' WHERE `id`='$id_utilisateur'";

    if ($conn->query($sql) === TRUE) {
            header("Location: dashboard.php");
       } else {
           echo "Error: " . $sql . "<br>" . $conn->error;
       }
}

// SQL SELECT statement
$sql = "SELECT * FROM `utilisateur` WHERE `id`='$id_utilisateur'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $row = $result->fetch_assoc();
    $username = $row['nom'];
    $email = $row['email'];
} else {
    echo "No results";
}

$conn->close();
?>