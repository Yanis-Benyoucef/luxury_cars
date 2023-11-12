<?php
session_start();

require_once 'classes/AppError.php';
require_once 'classes/Utils.php';
require_once 'functions/db.php';


if (!isset($_POST['email']) || !isset($_POST['password'])) {
    // je redirige si il manque des données
    Utils::redirect('login.php?error=' . AppError::AUTH_REQUIRED_FIELDS);
}

// je vais extraire les données postées
[
    'email' => $email,
    'password' => $password
] = $_POST;

// je fais une instance de PDO représentant la connexion à la base de données
try {
    $pdo = getConnection();
} catch (PDOException) {
    Utils::redirect('login.php?error=' . AppError::DB_CONNECTION);
}

// je cherche un utilisateur avec l'adresse e-mail fournie
$query = "SELECT * FROM Customers WHERE email = ?";
$connectStmt = $pdo->prepare($query);
$connectStmt->execute([$email]);

$user = $connectStmt->fetch();

// si l'user n'est pas trouvé je redirige et j'affiche un message d'erreur
if ($user === false) {
    Utils::redirect('login.php?error=' . AppError::USER_NOT_FOUND);
}

// si l'user est trouvé mais que je mot de passe est pas bon j'affiche un msg d'erreur et je redirige
if (!password_verify($password, $user['password'])) {
    Utils::redirect('login.php?error=' . AppError::INVALID_CREDENTIALS);
}

$_SESSION['userInfos'] = [
    'id' => $user['id'],
    'email' => $email,
    'first_name' => $user['first_name'],
    'last_name' => $user['last_name'],
    'picture' => $user['picture'] 
];

Utils::redirect('profile.php');
// authentification réussie, j'enregistre les informations de l'utilisateur dans la session et je redirige vers la page du profil
?>
