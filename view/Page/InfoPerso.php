<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if (isset($_GET["id"], $_GET["cle"]) && !empty($_GET["id"]) && !empty($_GET["cle"])) {
    $getid = $_GET["id"];
    $getcle = $_GET["cle"];

    $recupUser = $db->prepare("SELECT id, email, password FROM user WHERE id = ? AND cle = ?");
    $recupUser->execute([$getid, $getcle]);

    if ($recupUser->rowCount() > 0) {
        $userInfo = $recupUser->fetch();

        if (!empty($_POST)) {
            if (
                isset($_POST["nom"], $_POST["prenom"], $_POST["adresse"]) &&
                !empty($_POST["nom"]) &&
                !empty($_POST["prenom"])
            ) {
                $nom = strip_tags($_POST["nom"]);
                $prenom = strip_tags($_POST["prenom"]);
                $adresse = strip_tags($_POST["adresse"]);

                // Insertion dans la table user_valide
                $insertUser = $db->prepare("
                    INSERT INTO user_valide (email, password, nom, prenom, adresse)
                    VALUES (:email, :password, :nom, :prenom, :adresse)
                ");
                $insertUser->execute([
                    "email" => $userInfo["email"],
                    "password" => $userInfo["password"],
                    "nom" => $nom,
                    "prenom" => $prenom,
                    "adresse" => $adresse
                ]);

                header("Location: ../Page/FAQ.html");
                exit;
            } else {
                die("Erreur : tous les champs doivent être complétés (nom et prénom obligatoires)");
            }
        }

    } else {
        die("Erreur : identifiant ou clé de sécurité incorrecte");
    }

} else {
    die("Erreur : identifiant ou clé de sécurité manquante");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos informations</title>
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../component/BoutonBleu.css">
    <link rel="stylesheet" href="../Style/InfoPerso.css">
</head>
<body>
    <div class="background-image"></div>
    <header>
        <div id="navbar-container" class="navbar-container"></div>
        <script src="../component/Navbar/Navbar.js"></script>
        <script>
            document.getElementById('navbar-container').innerHTML = Navbar(false, "..");
        </script>
        <script src="../component/Navbar/navAction.js"></script> 

    </header>
    <main>
        <div class="containerLogin">
            <h1>Vos informations</h1>
            <form action="" method="post">
                <p>Nom</p>
                <input class="textbox" type="text" name="nom" required>
                <p>Prénom</p>
                <input class="textbox" type="text" name="prenom" required>
                <p>Adresse (optionnelle)</p>
                <div id="containerAdresse">
                    <input class="textbox" type="text" name="adresse" id="adresse" required>
                    <img id="iconAdresse" src="../assets/img/pin.png" alt="Adresse" >
                </div>
                <div id="boutonContainer"></div>
            </form>
            <script src="../component/BoutonBleu.js"></script>
            <script>
                document.getElementById('boutonContainer').innerHTML = BoutonBleu("Confirmer");
            </script>

        </div>
    </main>
    <footer id="footer-container" class="footer-container">
        <script src="../component/Footer/Footer.js"></script>
        <script>
            document.getElementById('footer-container').innerHTML = Footer("..");
        </script>
    </footer>
    
</body>
</html>