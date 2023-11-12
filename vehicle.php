<?php
require_once __DIR__ . '/functions/db.php';
require_once __DIR__ . '/layout/header.php';

// je recupere l'id du vehicle depuis la requete GET
if (isset($_GET['id'])) {
    $vehicleId = $_GET['id'];
} else {
    header("Location: erreur.php");
    exit();
}

$pdo = getConnection();

$query = "SELECT 
              v.id AS vehicle_id,
              v.name,
              v.description,
              m.model,
              b.brand,
              f.fuel,
              GROUP_CONCAT(c.color) AS colors,
              GROUP_CONCAT(i.image) AS images
          FROM 
              Vehicle v
          INNER JOIN 
              Image i ON v.id = i.id_vehicle
          INNER JOIN 
              Model m ON v.model = m.id_model
          INNER JOIN 
              Brand b ON m.brand = b.id_brand
          INNER JOIN 
              Fuel f ON v.fuel_type = f.id_fuel
          LEFT JOIN 
              Color_Vehicle cv ON v.id = cv.id_vehicle
          LEFT JOIN 
              Color c ON cv.id_color = c.id_color
          WHERE 
              v.id = :vehicle_id
          GROUP BY 
              v.id";
$stmt = $pdo->prepare($query);
$stmt->bindValue(":vehicle_id", $vehicleId, PDO::PARAM_INT);
$stmt->execute();
$vehicleData = $stmt->fetch(PDO::FETCH_ASSOC);

// je redirige en cas d'erreur
if (!$vehicleData) {
    header("Location: erreur.php");
    exit();
}
?>
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4"><?php echo $vehicleData['name']; ?></h1>
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <?php 
        $images = explode(',', $vehicleData['images']);
        foreach ($images as $vehicleImage): ?>
            <img src="<?php echo $vehicleImage; ?>" 
                 alt="<?php echo $vehicleData['name']; ?>" class="w-full h-48 object-cover" /> 
        <?php endforeach; ?>

        <div class="p-4">
            <p>Description : <?php echo $vehicleData['description']; ?></p>
            <p>Modèle : <?php echo $vehicleData['model']; ?></p>
            <p>Marque : <?php echo $vehicleData['brand']; ?></p>
            <p>Carburant : <?php echo $vehicleData['fuel']; ?></p>
            <p>Couleurs : <?php echo $vehicleData['colors']; ?></p>

            <a href="reservation.php?id=<?php echo $vehicleData['vehicle_id']; ?>">Réserver ce véhicule</a>

        </div>
    </div>
</div>
