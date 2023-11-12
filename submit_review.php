<?php
session_start();

require_once 'classes/AppError.php';
require_once 'classes/Utils.php';
require_once 'functions/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification si l'utilisateur est connecté
    if (!isset($_SESSION['userInfos']['id'])) {
        Utils::redirect('login.php?error=' . AppError::AUTH_REQUIRED);
    }

    // Extraction des données postées
    if (
        !isset($_POST['name']) ||
        !isset($_POST['firstname']) ||
        !isset($_POST['vehicle']) ||
        !isset($_POST['note']) ||
        !isset($_POST['comment'])
    ) {
        Utils::redirect('index.php?error=' . AppError::MISSING_DATA);
    }

    $pdo = getConnection();

    // Extraction des données postées
    [
        'name' => $name,
        'firstname' => $firstname,
        'vehicle' => $vehicle,
        'note' => $note,
        'comment' => $comment
    ] = $_POST;

    $idCustomer = $_SESSION['userInfos']['id'];

     // Traitement de l'upload de la photo
     $uploadDir = __DIR__ . '/uploads/reviews/';
     $uploadedFile = $_FILES['profile-pic']['tmp_name'];
     $photoName = uniqid() . '_' . $_FILES['profile-pic']['name'];
     $photoPath = $uploadDir . $photoName;
 
     if (move_uploaded_file($uploadedFile, $photoPath)) {
         // Enregistrement de l'avis dans la base de données avec le nom du fichier photo
         $query = "INSERT INTO Avis (id_vehicle, id_customer, note, commentaire, first_name, last_name, photo) VALUES (?, ?, ?, ?, ?, ?, ?)";
         $insertStmt = $pdo->prepare($query);
         $insertStmt->execute([$vehicle, $idCustomer, $note, $comment, $firstname, $name, $photoName]);
         
         Utils::redirect('index.php?success=' . AppError::REVIEW_SUBMITTED);
     } else {
         Utils::redirect('index.php?error=' . AppError::FILE_UPLOAD_ERROR);
     }
 } else {
     Utils::redirect('index.php');
 }
?>
