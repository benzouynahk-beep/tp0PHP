<?php
require_once "../Config/Database.php";
$db = new Database();
$conn = $db->connect();

$sql = "SELECT p.*, COUNT(a.developpeur_id) AS nb_dev
        FROM projets p
        LEFT JOIN affections a ON p.id = a.projet_id
        GROUP BY p.id";
$stmt = $conn->prepare($sql);
$stmt->execute();
?>
<h2>Liste des projets</h2>

<table border="1">
<tr>
    <th>Titre</th>
    <th>Type</th>
    <th>Statut</th>
    <th>Date fin</th>
    <th>Nb developpeurs</th>
    <th>Actions</th>
</tr>

<?php while($p = $stmt->fetch()) { ?>
<tr>
    <td><?= $p['titre'] ?></td>
    <td><?= $p['type_projet'] ?></td>
    <td><?= $p['statut'] ?></td>
    <td><?= $p['date_fin'] ?></td>
    <td><?= $p['nb_dev'] ?></td>
    <td>
        <a href="details_projet.php?id=<?= $p['id'] ?>">Details</a>
        <a href="modifier_projet.php?id=<?= $p['id'] ?>">Modifier</a>
        <a href="supprimer_projet.php?id=<?= $p['id'] ?>">Supprimer</a>
    </td>
</tr>
<?php } ?>
</table>

<a href="ajout_projet.php">+ Ajouter projet</a>