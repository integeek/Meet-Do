<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../view/Style/fondReservations.css">
    <link rel="stylesheet" href="../../view/component/Navbar/Navbar.css" />
    <link rel="stylesheet" href="../../view/component/Footer/Footer.css" />
    <link rel="stylesheet" href="../../view/component/BoutonBleu.css" />
    <link rel="stylesheet" type="text/css" href="../../view/component/BoutonRouge.css">
    <script src="../../view/component/BoutonBleu.js"></script>
    <script src="../../view/component/BoutonRouge.js"></script>
    <title>Document</title>
</head>
<body>
    <header>
        <div class="navbar-container" id="navbar-container"></div>
        <script src="../../view/component/Navbar/Navbar.js"></script>
        <script>
            document.getElementById("navbar-container").innerHTML = Navbar(
            true,
            "../../view"
            );
        </script>
        <h1>Mes Réservations :</h1>
    </header>
    <main>
    <div class="reservation-list">
        <?php
            session_start();

            if (!isset($_SESSION['user']['email'])) {
                header("Location: ../../view/page/Connexion.php");
                exit;
            }

            $host = '127.0.0.1';
            $dbname = 'test_meetdo1';
            $user = 'root';
            $pass = '';

            try {
                $pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname;charset=utf8", $user, $pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $email = $_SESSION['user']['email'];
                $sql = "SELECT idClient FROM user_valide WHERE email = :email";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $stmt->execute();

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result && isset($result['idClient'])) {
                    $idClient = $result['idClient'];
                    echo "<p>Id client : $idClient</p>";
                } else {
                    echo "<p>Aucun client trouvé pour l'email $email</p>";
                }


                $stmt =  $pdo->prepare("
                    SELECT activite.titre, activite.adresse, activite.prix, evenement.dateEvenement, reservation.nbPlace
                    FROM reservation
                    INNER JOIN evenement ON reservation.idEvenement = evenement.idEvenement
                    INNER JOIN activite ON evenement.idActivite = activite.idActivite
                    WHERE reservation.idClient = :idClient
                ");

                $stmt->execute([':idClient' => $idClient]);
                $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

                function resaComponent($title, $place, $date, $people, $price) {
                    return "
                        <div class='reservation-item'>
                            <h2>$title</h2>
                            <p>Adresse : $place</p>
                            <p>Date : $date</p>
                            <p>Nombre de places : $people</p>
                            <p>Prix : $price €</p>
                        </div>
                    ";
                }
                foreach ($reservations as $resa) {
                    echo resaComponent(
                        $resa['titre'],
                        $resa['adresse'],
                        $resa['dateEvenement'],
                        $resa['nbPlace'],
                        $resa['prix']
                    );
                }

            } catch (PDOException $e) {
                echo "Erreur de connexion à la base de données : " . $e->getMessage();
            }
        ?>
    </div>
    </main>
    <footer id="footer-container" class="footer-container">
        <script src="../../view/component/Footer/Footer.js"></script>
        <script>
            document.getElementById("footer-container").innerHTML = Footer("../../view");
        </script>
    </footer>
</body>
</html>


