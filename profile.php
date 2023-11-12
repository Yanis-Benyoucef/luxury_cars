<?php
require_once 'functions/db.php';
require_once 'classes/Utils.php';
require_once 'layout/header.php';


if (!isset($_SESSION['userInfos']['id'])) {
    $_SESSION['loginErrorMessage'] = "Vous devez être identifié pour accéder à cette page";
    Utils::redirect('login.php');
}

// je récupère l'ID de l'utilisateur connecté
$userID = $_SESSION['userInfos']['id'];

$pdo = getConnection();

// je fait une requête SQL pour récupérer les données de l'utilisateur
$query = "SELECT * FROM Customers WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':id', $userID, PDO::PARAM_INT);
$stmt->execute();

// je fait une vérification de la réussite de la requête et gestion des erreurs
if ($stmt->rowCount() === 0) {
    die('Erreur lors de la récupération des données du profil.');
}

// Extraction des données du profil de l'utilisateur
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<main class="prose mx-auto flex flex-col items-center">
    <h1>Profil de <?php echo $userData['first_name'] . ' ' . $userData['last_name']; ?></h1>
    <img src="<?php echo $userData['picture']; ?>" alt="Photo de profil">
    <p>Nom : <?php echo $userData['last_name']; ?></p>
    <p>Prénom : <?php echo $userData['first_name']; ?></p>
    <p>Email : <?php echo $userData['email']; ?></p>
    <br>
    <!-- liens vers mes classes -->
    <a href="classes/UpdateProfile.php?id=<?php echo $userData['id']; ?>">Modifier le profil</a>
    <a href="ChangePassword.php?id=<?php echo $userData['id']; ?>">Modifier le mot de passe</a>
</main>


<?php 
require_once 'layout/footer.php'; 
?>
