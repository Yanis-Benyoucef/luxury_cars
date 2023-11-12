<?php
require_once __DIR__ . '/functions/db.php';
require_once __DIR__ . '/layout/header.php';
require_once 'classes/AppError.php';

if (isset($_GET['success']) && $_GET['success'] == AppError::REVIEW_SUBMITTED) {
    // je check si la variable 'success' est définie dans les paramètres de l'url
    // et si sa valeur correspond au code de succès pour la soumission d'avis
    echo '<p>Votre avis a été soumis avec succès!</p>';
}

$pdo = getConnection();

$query = "SELECT v.id, v.name, v.description, i.image, i.id_vehicle
          FROM Vehicle v
          INNER JOIN Image i ON v.id = i.id_vehicle
          GROUP BY v.id";
$stmt = $pdo->query($query);
$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Véhicules de luxe</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php foreach ($vehicles as $vehicle) : ?>
            <a href="vehicle.php?id=<?php echo $vehicle['id']; ?>">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="<?php echo $vehicle['image']; ?>" alt="<?php echo $vehicle['name']; ?>" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-2xl font-bold"><?php echo $vehicle['name']; ?></h2>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Formulaire d'Avis</h1>
    <?php require_once 'review_form.php'; ?>
</div>

<?php
require_once __DIR__ . '/layout/footer.php';
?>
