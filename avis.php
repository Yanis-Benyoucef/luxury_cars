<?php
require_once __DIR__ . '/functions/db.php';
require_once __DIR__ . '/layout/header.php';

$pdo = getConnection();

$query = "SELECT a.id_avis, a.id_vehicle, a.id_customer, a.note, a.commentaire, a.photo, a.date_avis, a.first_name, a.last_name, v.name
          FROM Avis a
          LEFT JOIN Vehicle v ON a.id_vehicle = v.id
          ORDER BY a.date_avis DESC";
$stmt = $pdo->query($query);
$avis = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Avis des clients</h1>

    <?php foreach ($avis as $avisItem) : ?>
        <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-4">
            <div class="p-4">
                <h2 class="text-2xl font-bold"><?php echo $avisItem['name']; ?></h2>
                <p>Note : <?php echo $avisItem['note']; ?>/5</p>
                <p>Commentaire : <?php echo $avisItem['commentaire']; ?></p>
                <p>Auteur : <?php echo $avisItem['first_name'] . ' ' . $avisItem['last_name']; ?></p>
                <p>Date : <?php echo $avisItem['date_avis']; ?></p>
                <?php if ($avisItem['photo']) : ?>
                    <img src="<?php echo 'uploads/reviews/' . $avisItem['photo']; ?>" alt="Photo d'avis" class="mt-2">
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
require_once __DIR__ . '/layout/footer.php';
?>
