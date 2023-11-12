<?php
require_once 'functions/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // je recupere les données du formulaire
    $name = $_POST['name'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // j'ai eu recours de chatgpt pour faire ceci car j'y arrivai pas 
    // Gestion de l'upload de la photo de profil
    $targetDir = "uploads/";
    $profilePic = $targetDir . basename($_FILES["profile-pic"]["name"]);
    move_uploaded_file($_FILES["profile-pic"]["tmp_name"], $profilePic);

    // j'enregistre les données dans la base de donnée
    $pdo = getConnection();
    $query = "INSERT INTO Customers (last_name, first_name, email, password, picture) 
              VALUES (:last_name, :first_name, :email, :password, :picture)";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':last_name', $name);
    $stmt->bindValue(':first_name', $firstname);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->bindValue(':picture', $profilePic);

    if ($stmt->execute()) {
        // je redirige l'utilisateur apres l'inscription
        header("Location: login.php");
        exit();
    } else {
        echo "Une erreur s'est produite lors de l'inscription.";
    }
}
?>
