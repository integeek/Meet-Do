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

                $destinataire = $userInfo["email"];
                $sujet = "Confirmation de votre inscription à Meet&Do";
                $message = "<html><body style=\"margin: 0;\">";
                $message .= '
                <style>
                    @import url(\'https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap\');
                </style>
                <div style="width: 100%; background-color: #004AAD; height: 5rem; display: flex;"><h1 style="margin: auto auto auto auto;  font-family: Inter, sans-serif;">Meet&DO</h1></div>
                <div style="font-family: Inter;">
                    <h3 style="margin: 2rem auto 0 auto; text-align: center; font-family: Inter;">Bienvenue chez Meet&Do</h3>
                    <section style="margin: 0 2rem 0 2rem; font-family: Inter;">
                        <p style="font-family: Inter;">Bonjour,</p>
                        <p style="font-family: Inter;">Félicitations ! Votre compte Meet&Do a bien été activé.</p>
                        
                        <p style="font-family: Inter;">Vous pouvez désormais accéder à toutes les fonctionnalités de la plateforme, participer à des événements, créer des activités et échanger avec la communauté.</p>
                        <p style="font-family: Inter;">Nous sommes ravis de vous compter parmi nos utilisateurs !</p>
                        <p style="font-family: Inter;">À très vite sur Meet&Do !  </p>
                    </section>
                    <div style="display: flex; justify-content: center;">
                        <div style="width: 40%; border-bottom: 1px solid #64A0FB; margin-top: 2rem; margin-bottom: 2rem;">
                        </div>
                    </div>
                    <section style="margin: 0 auto 0 auto; text-align: center; font-family: Inter;">
                        <p style="font-family: Inter;">Notre équipe reste à votre entière disposition pour toute question</p>
                        <p style="font-family: Inter;">Tel: +33 6 07 46 76 89 &nbsp; Email: meetanddo@gmail.com</p>
                    </section>
                    <section style="margin-top: 3rem; font-family: Inter;">
                        <h4 style="text-align: center; font-family: Inter;">Restez connecté ! </h4>
                        <div style="display: flex; margin: 0 auto 0 auto;">
                            <a style="width: 33%; display: flex; align-items: center; justify-content: center;" href="https://www.facebook.com">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b9/2023_Facebook_icon.svg/768px-2023_Facebook_icon.svg.png" alt="Logo" style="width: 10%; height: auto; cursor: pointer; margin: 0 auto 0 auto;">
                            </a>
                            <a style="width: 33%; display: flex; justify-content: center; align-items: center;" href="https://www.instagram.com">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Instagram_icon.png/960px-Instagram_icon.png" alt="Logo" style="width: 10%; height: auto; cursor: pointer; margin: 0 auto 0 auto;">
                            </a> 
                            <a style="width: 33%; display: flex; justify-content: center; align-items: center;" href="https://www.linkedin.com">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTuRALyVA0K3z9C2yeZhRpUG7LGbVzLJD8ZmcZReeui69NRx2xonJ3JR5MhTfdFdE-NFSE&usqp=CAU" alt="Logo" style="width: 10%; height: auto; cursor: pointer; margin: 0 auto 0 auto;">
                            </a>  
                        </div>
                    </section>
                </div>
                ';
                $message .= "</body></html>";
                $headers = "From: integeek789@gmail.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=UTF-8\r\n";
                // $message = "http://localhost/view/page/InfoPerso.php?id=" . $_SESSION["user"]["id"] . "&cle=" . $cle;
                // $headers = "From: integeek789@gmail.com";
                if (mail($destinataire, $sujet, $message, $headers)) {
                    echo "L'email a été envoyé avec succès.";
                } else {
                    echo "L'email n'a pas pu être envoyé.";
                }

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