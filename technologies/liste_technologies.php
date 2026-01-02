<?php
require_once "../Config/Database.php";
$db = new Database();
$conn = $db->connect();

$sql = "SELECT t.*, COUNT(pt.projet_id) AS nb_projets
        FROM technologies t
        LEFT JOIN projet_technologie pt ON t.id = pt.technologie_id
        GROUP BY t.id";

$stmt = $conn->prepare($sql);
$stmt->execute();
?>

<h2>Liste des technologies</h2>

<table border="1">
<tr>
    <th>Nom</th>
    <th>Nb projets</th>
    <th>Actions</th>
</tr>

<?php while($t = $stmt->fetch()) { ?>
<tr>
    <td><?= $t['nom'] ?></td>
    <td><?= $t['nb_projets'] ?></td>
    <td>
        <a href="Details_Technologie.php?id=<?= $t['id'] ?>">Details</a>
        <a href="Modifier_Technologie.php?id=<?= $t['id'] ?>">Modifier</a>
        <a href="Supprimer_Technologie.php?id=<?= $t['id'] ?>">Supprimer</a>
    </td>
</tr>
<?php } ?>
</table>

<a href="Ajout_Technologie.php">+ Ajouter technologie</a>
