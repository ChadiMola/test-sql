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

// SQL INSERT statement for `utilisateur` table
$nom = $_POST["username"];
$email = $_POST["email"];
$mot_de_passe = $_POST["password"];
$numero_telephone = $_POST["phone"];

$sql = "INSERT INTO `utilisateur`( `nom`, `email`, `mot_de_passe`, `numero_telephone`) VALUES ('$nom','$email','$mot_de_passe','$numero_telephone')";

if ($conn->query($sql) === TRUE) {
    // Get the ID of the user that was just inserted
    $id_utilisateur = $conn->insert_id;

    // SQL INSERT statement for `solde` table
    $sql = "INSERT INTO `solde`(`id_utilisateur`, `solde_internet`, `solde`) VALUES ('$id_utilisateur','100','100')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>