<?php
session_start();
include_once '../../Controller/meeter/meeter.php';
$nom = $pageData['prenom'] . ' ' . $pageData['nom'];
$ville = $pageData['localisation'];
$anciennete = $pageData['anciennete'];
$description = $pageData['description'];
$photo = $pageData['photoProfil'];
$activites = $pageData['activites'];
$avis = $pageData['avis'];
$moyenne = $pageData['moyenneAvis'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <base href="http://localhost/view/page/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Meeter</title>
    <link rel="stylesheet" href="../Style/Meeter.css">
    <link rel="stylesheet" href="../component/Navbar/Navbar.css" />
    <link rel="stylesheet" href="../component/Footer/Footer.css" />
</head>

<body>

    <header>
        <div id="navbar-container" class="navbar-container"></div>
        <script src="../component/Navbar/Navbar.js"></script>
        <script>
            (async () => {
                document.getElementById('navbar-container').innerHTML = await Navbar("..");
            })();
        </script>
        <script src="../component/Navbar/navAction.js"></script>
    </header>

    <main class="profile-container">

        <section class="profile-info">
            <div style="display: flex; align-items: center; gap: 10px;">
                <?php if (!empty($photo)) : ?>
                    <img src="<?php echo htmlspecialchars($photo); ?>" alt="Photo de profil de <?php echo htmlspecialchars($nom); ?>" class="photo-profil">
                <?php endif; ?>
                <h1><?php echo htmlspecialchars($nom); ?></h1>
            </div>
            <p><?php echo htmlspecialchars($ville); ?></p>
            <h2>Description :</h2>
            <p><?php echo htmlspecialchars($description); ?></p>
        </section>

        <section class="activities">
            <h2>Ses activités :</h2>
            <div class="activity-list">
                <?php foreach ($activites as $act) : ?>
                    <div class="activity-card">
                        <img src="<?php echo htmlspecialchars($act['image'] ?? '../assets/img/default.jpg'); ?>"
                            alt="Image activité" class="activity-image">
                        <div class="content">
                            <h3><?php echo htmlspecialchars($act['titre']); ?></h3>
                            <p><?php echo htmlspecialchars($act['description']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="reviews">
            <h2>Les avis de ses activités : <?php echo $moyenne ? $moyenne . "/5" : "Aucun avis"; ?></h2>
            <div class="review-list">
                <?php foreach ($avis as $a) : ?>
                    <div class="review-card">
                        <h3><?php echo htmlspecialchars($a['auteur']); ?></h3>
                        <div class="rating"><?php echo str_repeat("★", $a['note']) . str_repeat("☆", 5 - $a['note']); ?></div>
                        <p><?php echo htmlspecialchars($a['commentaire']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer id="footer-container" class="footer-container"></footer>
    <script src="../component/Footer/Footer.js"></script>
    <script>
        document.getElementById('footer-container').innerHTML = Footer("..");
    </script>


</body>

</html>