<?php
require_once "../Config/Database.php";
$db = new Database();
$conn = $db->connect();

$id = $_GET['id'];


$stmt = $conn->prepare("SELECT * FROM technologies WHERE id=?");
$stmt->execute([$id]);
$tech = $stmt->fetch();


$sql = "SELECT p.titre, p.statut
        FROM projet_technologie pt
        JOIN projets p ON pt.projet_id = p.id
        WHERE pt.technologie_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
?>

<h2>Details technologie</h2>

<p><b>Nom :</b> <?= $tech['nom'] ?></p>
<p><b>Description :</b> <?= $tech['description'] ?></p>

<h3>Projets utilisant cette technologie</h3>

<table border="1">
<tr>
    <th>Projet</th>
    <th>Statut</th>
</tr>

<?php while($p = $stmt->fetch()) { ?>
<tr>
    <td><?= $p['titre'] ?></td>
    <td><?= $p['statut'] ?></td>
</tr>
<?php } ?>
</table>

<br>
<a href="Liste_Technologies.php">Retour</a>
<a href="Modifier_Technologie.php?id=<?= $id ?>">Modifier</a>
<a href="Supprimer_Technologie.php?id=<?= $id ?>">Supprimer</a>

