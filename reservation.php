<?php
require_once __DIR__ . '/functions/db.php';
require_once __DIR__ . '/layout/header.php';

if (isset($_GET['id'])) {
    $vehicleId = $_GET['id'];
} else {
    header("Location: erreur.php");
    exit();
}

$pdo = getConnection();

// try {
//     // supression de toutes les reservations une fois le formulaire soumis
//     // ALTER TABLE ... AUTO_INCREMENT = 1;
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_all_reservations'])) {
//     $deleteAllQuery = "DELETE FROM Reservations WHERE id_vehicle = :id_vehicle";
//     $deleteAllStmt = $pdo->prepare($deleteAllQuery);
//     $deleteAllStmt->bindValue(':id_vehicle', $vehicleId, PDO::PARAM_INT);
//     $deleteAllStmt->execute();

//     // je redirige après une supression
//     header("Location: reservation.php?id={$vehicleId}");
//     exit();
// }
// } catch (PDOException $e) {
//     echo "Erreur lors de la supression: " . $e->getMessage();
// }

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_all_reservations'])) {
        $deleteAllQuery = "DELETE FROM Reservations WHERE id_vehicle = :id_vehicle";
        $deleteAllStmt = $pdo->prepare($deleteAllQuery);
        $deleteAllStmt->bindValue(':id_vehicle', $vehicleId, PDO::PARAM_INT);
        $deleteAllStmt->execute();

        // Je me suis aidé de chatGpt, je ne sais pas si cette méthode est recommandée ou pas dans la pratique 
        $resetAutoIncrementQuery = "ALTER TABLE Reservations AUTO_INCREMENT = 1";
        $pdo->exec($resetAutoIncrementQuery);

        // je redirige après la supression de la réservation
        header("Location: reservation.php?id={$vehicleId}");
        exit();
    }
} catch (PDOException $e) {
    echo "Erreur lors de la suppression: " . $e->getMessage();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['start_date']) && isset($_POST['end_date'])) {

    $query = "SELECT * FROM Reservations WHERE 
              id_vehicle = :id_vehicle AND (
                (start_date <= :start_date AND end_date >= :start_date) OR
                (start_date <= :end_date AND end_date >= :end_date) OR
                (start_date >= :start_date AND end_date <= :end_date)
              )";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':id_vehicle', $vehicleId, PDO::PARAM_INT);
    $stmt->bindValue(':start_date', $_POST['start_date'], PDO::PARAM_STR);
    $stmt->bindValue(':end_date', $_POST['end_date'], PDO::PARAM_STR);
    $stmt->execute();
    $existingReservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($existingReservations)) {
        $query = "INSERT INTO Reservations (id_vehicle, start_date, end_date) VALUES (:id_vehicle, :start_date, :end_date)";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':id_vehicle', $vehicleId, PDO::PARAM_INT);
        $stmt->bindValue(':start_date', $_POST['start_date'], PDO::PARAM_STR);
        $stmt->bindValue(':end_date', $_POST['end_date'], PDO::PARAM_STR);
        $stmt->execute();

        header("Location: vehicle.php?id={$vehicleId}");
        exit();
    } else {
        echo "Une réservation existe déjà pour ces dates.";
    }
}

$query = "SELECT * FROM Reservations WHERE id_vehicle = :id_vehicle";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':id_vehicle', $vehicleId, PDO::PARAM_INT);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<form action="reservation.php?id=<?php echo $vehicleId; ?>" method="post">
    <label for="start_date">Date de début :</label>
    <input type="date" name="start_date" required>

    <label for="end_date">Date de fin :</label>
    <input type="date" name="end_date" required>

    <button type="submit">Réserver</button>
</form>

<?php
// j'affiche les reservations de la voiture
foreach ($reservations as $reservation) :
    ?>
    <div>
        <p>Réservation du <?php echo $reservation['start_date']; ?> au <?php echo $reservation['end_date']; ?></p>
<?php endforeach; ?>
<form action="reservation.php?id=<?php echo $vehicleId; ?>" method="post">
    <button type="submit" name="delete_all_reservations">Supprimer toutes les réservations</button>
</form>

<?php require_once __DIR__ . '/layout/footer.php'; ?>