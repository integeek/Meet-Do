<?php
try {
    $db = new PDO(
        "mysql:host=144.76.54.100;dbname=MeetDo;charset=utf8",
        "meetndodatabase",
        "AppG10-D",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (Exception $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>

<?php
class Bdd {
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    "mysql:host=144.76.54.100;dbname=MeetDo;charset=utf8",
                    "meetndodatabase",
                    "AppG10-D",
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (Exception $e) {
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
