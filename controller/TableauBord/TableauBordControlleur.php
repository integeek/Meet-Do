<?php
require_once("../../model/Bdd.php");
require_once("../../model/TableauBord/TableauBordModel.php");

class TableauBordController {
    private $model;
    public function __construct($db) {
        $this->model = new TableauBordModel($db);
    }

    public function getData() {
        $nombreClient = $this->model->getNombreClient();
        $nombreActivite = $this->model->getNombreActivite();
        $nombreActiviteTheme = $this->model->getNombreActiviteTheme();
        $nombreActiviteParMois = $this->model->getNombreActiviteParMois();

        $jsonData = [
            "nombreClient" => $nombreClient,
            "nombreActivite" => $nombreActivite,
            "nombreActiviteTheme" => $nombreActiviteTheme,
            "nombreActiviteParMois" => $nombreActiviteParMois
        ];

        header('Content-Type: application/json');
        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
    }
}

// ROUTEUR SIMPLE
$db = Bdd::getInstance();
$controller = new TableauBordController($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->getData();
} else {
    echo json_encode(["error" => "Méthode non autorisée"]);
}
?>