<?php
require_once "../Config/Database.php";
$db = new Database();
$conn = $db->connect();

$id = $_GET['id'];


$stmt = $conn->prepare("SELECT * FROM projets WHERE id=?");
$stmt->execute([$id]);
$projet = $stmt->fetch();


$sql = "SELECT d.nom, a.role, a.date_affectation
        FROM affections a
        JOIN developpeurs d ON a.developpeur_id = d.id
        WHERE a.projet_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
?>
<h2>Details projet</h2>

<p><b>Titre :</b> <?= $projet['titre'] ?></p>
<p><b>Type :</b> <?= $projet['type_projet'] ?></p>
<p><b>Statut :</b> <?= $projet['statut'] ?></p>
<p><b>Date debut :</b> <?= $projet['date_debut'] ?></p>
<p><b>Date fin :</b> <?= $projet['date_fin'] ?></p>
<p><b>Description :</b> <?= $projet['description'] ?></p>

<h3>Developpeurs affectes</h3>
<table border="1">
<tr>
    <th>Nom</th>
    <th>Role</th>
    <th>Date affectation</th>
</tr>

<?php while($d = $stmt->fetch()) { ?>
<tr>
    <td><?= $d['nom'] ?></td>
    <td><?= $d['role'] ?></td>
    <td><?= $d['date_affectation'] ?></td>
</tr>
<?php } ?>
</table>

<a href="liste_projets.php">Retour</a>
<a href="modifier_projet.php?id=<?= $id ?>">Modifier</a>
<a href="supprimer_projet.php?id=<?= $id ?>">Supprimer</a>