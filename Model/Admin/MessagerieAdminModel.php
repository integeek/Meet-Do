<?php
require_once(__DIR__ . "/../Bdd.php");

class MessagerieAdminModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function getMessages($search = "") {
        if ($search !== "") {
            $sql = "SELECT idFormulaireContact AS id, nom, prenom, email, sujet, message, dateEnvoie
                    FROM FormulaireContact
                    WHERE nom LIKE :search OR prenom LIKE :search OR email LIKE :search OR sujet LIKE :search OR message LIKE :search";
            $query = $this->db->prepare($sql);
            $like = "%$search%";
            $query->bindParam(':search', $like, PDO::PARAM_STR);
        } else {
            $sql = "SELECT idFormulaireContact AS id, nom, prenom, email, sujet, message, dateEnvoie FROM FormulaireContact";
            $query = $this->db->prepare($sql);
        }
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteMessage($id) {
        $sql = "DELETE FROM FormulaireContact WHERE idFormulaireContact = :id";
        $query = $this->db->prepare($sql);
        return $query->execute(['id' => $id]);
    }

    public function sendResponse($id, $messageReponse, $userName, $email, $sujet) {
        $destinataire = $email;
        $sujetMail = "Réponse à votre message sur Meet&Do";
        $message = "<html><body style=\"margin: 0;\">";
        $message .= '
        <div style="width: 100%; background-color: #004AAD; height: 5rem; display: flex;"><h1 style="margin: auto auto auto auto;  font-family: Inter, sans-serif;">Meet&DO</h1></div>
        <div style="font-family: Inter;">
            <h3 style="margin: 2rem auto 0 auto; text-align: center; font-family: Inter;">Merci pour votre message</h3>
            <section style="margin: 0 2rem 0 2rem; font-family: Inter;">
                <p style="font-family: Inter;">Bonjour,</p>
                <p style="font-family: Inter;">Nous vous remercions d\'avoir pris le temps de poster un message sur notre plateforme Meet&Do. Voici la réponse de notre administrateur.</p>
                <p style="padding:1rem;border:1px solid #ccc;background:#f9f9f9;">' . nl2br(htmlspecialchars($messageReponse, ENT_QUOTES, 'UTF-8')) . '</p>
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
        $headers = "From: meetdosav@gmail.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";

        mail($destinataire, $sujetMail, $message, $headers);

        $sql = "DELETE FROM FormulaireContact WHERE idFormulaireContact = :id";
        $query = $this->db->prepare($sql);
        return $query->execute(['id' => $id]);
    }
}
?>