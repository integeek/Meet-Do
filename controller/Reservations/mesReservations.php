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

            $host = '127.0.0.1';
            $dbname = 'test_meetdo1';
            $user = 'root';
            $pass = 'root';

            if (!isset($_SESSION['idClient'])) {
                echo "<p>Erreur : utilisateur non connecté.</p>";
                exit;
            }
            $idClient = $_SESSION['idClient'];

            try {
                $pdo = new PDO("mysql:host=$host;port=8889;dbname=$dbname;charset=utf8", $user, $pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
                    return '
                    <div class="reservation-item">
                        <div class="item-header">
                            <h2>' . htmlspecialchars($title) . '</h2>
                            <img src="../../view/assets/img/macaron1.jpeg" alt="photo-reservation" class="photo-reservation">
                        </div>
                        <div class="item-main">
                            <div class="item-adresse">
                                <img src="../../view/assets/img/icons/position-icon.svg" alt="position-icon">
                                <p>' . htmlspecialchars($place) . '</p>
                            </div>
                            <div class="item-date">
                                <img src="../../view/assets/img/icons/calendar.svg" alt="calendar-icon">
                                <p>' . htmlspecialchars($date) . '</p>
                            </div>
                            <div class="item-places">
                                <img src="../../view/assets/img/icons/group.svg" alt="group-icon">
                                <p>' . htmlspecialchars($people) . ' place(s) réservée(s)</p>
                            </div>
                            <div class="item-prix">
                                <img src="../../view/assets/img/icons/price.svg" alt="price-icon">
                                <p>' . htmlspecialchars($price) . ' €</p>
                            </div>
                        </div>
                        <div class="item-footer">
                            <div id="boutonContainer"></div>
                            <script>
                                document.getElementById("boutonContainer").innerHTML = BoutonBleu("Voir l\'activité");
                            </script>
                            <div id="boutonContainer1"></div>
                            <script>
                                document.getElementById("boutonContainer1").innerHTML = BoutonBleu("Modifier ma réservation");
                            </script>
                            <div id="bouton-rouge" onclick="closePopUp()"></div>
                            <script>
                                document.getElementById("bouton-rouge").innerHTML = BoutonRouge("Annuler ma réservation");
                            </script>
                        </div>
                    </div>
                ';
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


