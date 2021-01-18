<?php
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=stages;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch (Exception $erreur){
            die('Erreur : ' . $erreur->getMessage());
    }
?>