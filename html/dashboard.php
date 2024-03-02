<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tableau de Bord</title>
  <link rel="stylesheet" href="../style/style.css" />
</head>
<body>
<div class="navbar">
  <h1>Tableau de Bord</h1>
</div>
<div class="sidenav">
  <img src="../images/telecome.png" width="100px" />
  <a href="dashboard.php">Accueil</a>
  <a href="profile.html">Profil</a>
  <a href="#">Déconnexion</a>
</div>

<div class="content-dashboard">
  <div class="card-1">
    <h2>Bienvenue sur votre Tableau de Bord</h2>
    <p>Ceci est une application de démonstration.</p>
  </div>
  <div class="card">
    <h2>Suivi de ma conso et solde</h2>
    <?php
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

    // SQL SELECT statement
    $sql = "SELECT * FROM `solde` WHERE `id_utilisateur`='$id_utilisateur'";

    $result = $conn->query($sql);

    // Define the variables with a default value
    $solde_internet = "Not available";
    $solde = "Not available";

    if ($result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc();
        $solde_internet = $row['solde_internet'];
        $solde = $row['solde'];
    } else {
        echo "No results";
    }

    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the recharge amount from the form
        $recharge = $_POST['recharge'];

        // SQL UPDATE statement
        $sql = "UPDATE `solde` SET `solde`=`solde`+'$recharge' WHERE `id_utilisateur`='$id_utilisateur'";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // SQL SELECT statement
    $sql = "SELECT * FROM `solde` WHERE `id_utilisateur`='$id_utilisateur'";

    $result = $conn->query($sql);

    // Define the variables with a default value
    $solde_internet = "Not available";
    $solde = "Not available";

    if ($result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc();
        $solde_internet = $row['solde_internet'];
        $solde = $row['solde'];
    } else {
        echo "No results";
    }
    $conn->close();
    ?>
    <p>Solde internet : <span class="blue"><?php echo $solde_internet; ?> gb</span></p>
    <p>Solde : <span class="blue"><?php echo $solde; ?> dt</span></p>
  </div>
  <div class="card">
    <h2>Recharge</h2>
    <p>Vous n'avez pas encore effectué d'activités.</p>

    <form id='rechargeform' method="POST">
      <input type="number" name="recharge" min="0" />
      <button type="submit">Recharge</button>
    </form>
  </div>
</div>
<script>
document.getElementById('rechargeform').addEventListener('submit', function(event) {
    // Prevent the form from being submitted
    event.preventDefault();

    // Select the input field
    var recharge = document.getElementsByName('recharge')[0];

    // Check if the input field is empty
    if (recharge.value === '') {
        alert('Please enter a recharge amount');
        return;
    }

    // If everything is fine, submit the form
    event.target.submit();
});</script>
</body>
</html>