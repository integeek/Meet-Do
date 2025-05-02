<?php 

require_once("../../model/bddAmbre.php");
if(!empty($_POST)){
    $email = $_POST["emailSend"];
    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);
    $expiricy = date("Y-m-d H:i:s", time() + 60*30);//30 minutes
    
    $sql = "UPDATE user_valide SET reset_token_hash = :reset_token, reset_token_expires_at= :reset_expires WHERE email = :email";
    $query = $db -> prepare($sql);
    $query->execute([
        "email" => $email,
        "reset_token" => $token_hash,
        "reset_expires" => $expiricy
    ]);

    if ($query->rowCount() > 0){
        $lienMDP = "http://localhost/view/page/NouveauPass.php?token=$token";

        $destinataire = $email;
        $sujet = "Réinitialisation de votre mot de passe Meet&Do";
        $message = "<html><body style=\"margin: 0;\">";
        $message .= '
        <style>
            @import url(\'https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap\');
        </style>
        <div style="width: 100%; background-color: #004AAD; height: 5rem; display: flex;"><h1 style="margin: auto auto auto auto;  font-family: Inter, sans-serif;">Meet&DO</h1></div>
        <div style="font-family: Inter;">
            <section style="margin: 0 2rem 0 2rem; font-family: Inter;">
                <p style="font-family: Inter;">Bonjour,</p>
                
                <p style="font-family: Inter;"><a  target="_blank "href="' . $lienMDP . '">Cliquez ici pour réinitialiser votre mot de passe</a></p>                
                <p style="font-family: Inter;">Si vous n’êtes pas à l’origine de cette inscription, ignorez simplement ce message.</p>
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

        if (mail($destinataire, $sujet, $message, $headers)) {
            echo "L'email a été envoyé avec succès.";
        } else {
            echo "L'email n'a pas pu être envoyé.";
        }

    }


}else {
    $_SESSION["erreur"] = "le formulaire est incomplet";
    header("Location: ../../view/Page/Inscription.php");
}

?>