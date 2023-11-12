<?php
require_once '../functions/db.php';
require_once '../layout/header.php';

class ChangePassword
{
    private $userID;

    public function __construct()
    {
        // je check si l'user est log avec la session
        if (!isset($_SESSION['userInfos']['id'])) {
            header("Location: login.php");
            exit();
        }

        $this->userID = $_SESSION['userInfos']['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePasswordChange();
        }
    }
    // function pour afficher la page de modification de mot de passe, c'était plus simple  
    // pour moi de le mettre dans la classe que séparer 2 fichiers (mais pas plus pratique je sais)
    public function renderPage()
    {
        ?>
        <main class="prose mx-auto flex flex-col items-center">
            <h1>Changer le mot de passe</h1>
            <form action="" method="POST">
                <label for="old_password">Ancien mot de passe :</label>
                <input type="password" name="old_password" required>

                <label for="new_password">Nouveau mot de passe :</label>
                <input type="password" name="new_password" required>

                <button type="submit">Changer le mot de passe</button>
            </form>
        </main>
        <?php
        require_once 'layout/footer.php';
    }

    private function handlePasswordChange()
    {
        $oldPassword = $_POST['old_password'];
        $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

        $pdo = getConnection();

        // je verifie si l'ancien mot de passe entré est bon
        $checkPasswordQuery = "SELECT password FROM Customers WHERE id = :id";
        $checkPasswordStmt = $pdo->prepare($checkPasswordQuery);
        $checkPasswordStmt->bindValue(':id', $this->userID, PDO::PARAM_INT);
        $checkPasswordStmt->execute();
        $storedPassword = $checkPasswordStmt->fetchColumn();

        if (password_verify($oldPassword, $storedPassword)) {
            // j'effectue une mise à jour du mot de passe
            $updatePasswordQuery = "UPDATE Customers SET password = :new_password WHERE id = :id";
            $updatePasswordStmt = $pdo->prepare($updatePasswordQuery);
            $updatePasswordStmt->bindValue(':new_password', $newPassword);
            $updatePasswordStmt->bindValue(':id', $this->userID, PDO::PARAM_INT);
            $updatePasswordStmt->execute();

            header("Location: profile.php");
            exit();
        } else {
            echo "L'ancien mot de passe est incorrect.";
        }
    }
}

// j'appel la classe et j'affiche la page render
$changePasswordPage = new ChangePassword();
$changePasswordPage->renderPage();
?>
