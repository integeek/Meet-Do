<?php
session_start();
unset($_SESSION["user"]);
header("Location: ../Page/Connexion.html");
?>