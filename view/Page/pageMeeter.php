<?php
require_once('../../controller/meeter/meeter.php');

$user = $pageData['user'];
$activities = $pageData['activities'];
$reviews = $pageData['reviews'];
$averageRating = $pageData['averageRating'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil Meeter - <?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></title>
    <link rel="stylesheet" href="../Style/Meeter.css" />
    <link rel="stylesheet" href="../component/Footer.css" />
    <link rel="stylesheet" href="../component/Navbar.css" />
</head>
<body>
    <!-- Navbar -->
    <div id="navbar-container" class="navbar-container"></div>
    <script src="../component/Navbar.js"></script>
    <script>
        document.getElementById('navbar-container').innerHTML = Navbar(true, "..");
    </script>

    <!-- Contenu principal -->
    <main class="profile-container">

        <!-- Section Profil -->
        <section class="profile-info">
            <h1><?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></h1>
            <p><?php echo htmlspecialchars($user['ville'] . ', ' . $user['code_postal']); ?></p>
            <p>Meeter depuis <?php echo htmlspecialchars($user['annee_inscription']); ?> ans</p>
            <h2>Description :</h2>
            <p><?php echo nl2br(htmlspecialchars($user['description'])); ?></p>
        </section>

        <!-- Section Activités -->
        <section class="activities">
            <h2>Ses activités :</h2>
            <div class="activity-list">
                <?php if (count($activities) > 0): ?>
                    <?php foreach ($activities as $activity) : ?>
                        <div class="activity-card">
                            <img src="<?php echo htmlspecialchars($activity['image_path']); ?>" alt="<?php echo htmlspecialchars($activity['titre']); ?>" />
                            <div class="content">
                                <h3><?php echo htmlspecialchars($activity['titre']); ?></h3>
                                <p>Avec <?php echo htmlspecialchars($activity['organisateur']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucune activité trouvée.</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Section Avis -->
        <section class="reviews">
            <h2>Les avis de ses activités : <?php echo $averageRating; ?>/5</h2>
            <div class="review-list">
                <?php if (count($reviews) > 0): ?>
                    <?php foreach ($reviews as $review) : ?>
                        <div class="review-card">
                            <h3><?php echo htmlspecialchars($review['auteur']); ?></h3>
                            <div class="rating">
                                <?php
                                $fullStars = intval($review['rating']);
                                $emptyStars = 5 - $fullStars;
                                echo str_repeat('★', $fullStars);
                                echo str_repeat('☆', $emptyStars);
                                ?>
                            </div>
                            <p><?php echo htmlspecialchars($review['commentaire']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun avis pour le moment.</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Section Contact -->
        <section class="contact">
            <h2>Une question ?</h2>
            <p>Contactez <?php echo htmlspecialchars($user['prenom']); ?></p>
            <button class="btn-bleu">Envoyer un message</button>
        </section>
    </main>

    <!-- Footer -->
    <footer id="footer-container" class="footer-container"></footer>
    <script src="../component/Footer.js"></script>
    <script>
        document.getElementById('footer-container').innerHTML = Footer("..");
    </script>
</body>
</html>
