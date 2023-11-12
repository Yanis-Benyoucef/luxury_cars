<?php

require_once '../functions/db.php';
require_once '../layout/header.php';

class UpdateProfile
{
    private $pdo;
    private $userID;
    private $userData;

    public function __construct()
    {
        
        $this->pdo = getConnection();

        // je check si l'user est log avec la session
        if (!isset($_SESSION['userInfos']['id'])) {
            header("Location: login.php");
            exit();
        }

        $this->userID = $_SESSION['userInfos']['id'];

        $this->getUserData();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->updateProfile();
        }

        // Affichage du formulaire de mise à jour du profil
        $this->renderForm();
    }

    // je recupere les données de l'utilisateur
    private function getUserData()
    {
        $query = "SELECT * FROM Customers WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $this->userID, PDO::PARAM_INT);
        $stmt->execute();
        $this->userData = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // j'effectue un update dans la base de donnée 
    private function updateProfile()
    {
        $newLastName = $_POST['new_last_name'];
        $newFirstName = $_POST['new_first_name'];

        $updateQuery = "UPDATE Customers SET last_name = :new_last_name, first_name = :new_first_name WHERE id = :id";
        $updateStmt = $this->pdo->prepare($updateQuery);
        $updateStmt->bindValue(':new_last_name', $newLastName);
        $updateStmt->bindValue(':new_first_name', $newFirstName);
        $updateStmt->bindValue(':id', $this->userID, PDO::PARAM_INT);
        $updateStmt->execute();

        header("Location: profile.php");
        exit();
    }

    // function pour afficher la page de modification de profile, c'était plus simple aussi
    // pour moi de le mettre dans la classe que séparer 2 fichiers
    private function renderForm()
    {
        ?>
        <main class="prose mx-auto flex flex-col items-center">
            <h1>Modifier le profil</h1>
            <form action="" method="POST">
                <label for="new_last_name">Nouveau nom :</label>
                <input type="text" name="new_last_name" value="<?php echo $this->userData['last_name']; ?>" required>

                <label for="new_first_name">Nouveau prénom :</label>
                <input type="text" name="new_first_name" value="<?php echo $this->userData['first_name']; ?>" required>

                <button type="submit">Mettre à jour</button>
            </form>
        </main>
        <?php

        require_once '../layout/footer.php';
    }
}

new UpdateProfile();
