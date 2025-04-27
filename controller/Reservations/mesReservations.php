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
            $host = '127.0.0.1';
            $dbname = 'test_meetdo';
            $user = 'root';
            $pass = '';

            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                $idClient = $_SESSION['idClient'];
            
                $stmt = $pdo->prepare(
                    'SELECT idReservation 
                     FROM Reservation 
                     WHERE idClient = :idClient'
                );
            
                $stmt->execute([':idClient' => $idClient]);
            
                $idReservations = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            
            } catch (PDOException $e) {
                echo "Erreur de connexion : " . $e->getMessage();
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


