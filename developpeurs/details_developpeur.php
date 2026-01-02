
<?php
require_once "../Config/Database.php";
$db = new Database();
$conn = $db->connect();

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM developpeurs WHERE id=?");
$stmt->execute([$id]);
$dev = $stmt->fetch();


$sql = "SELECT p.titre, p.statut, a.role, a.date_affectation
        FROM affections a
        JOIN projets p ON a.projet_id = p.id
        WHERE a.developpeur_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
?>

<h2>Details developpeur</h2>

<p><b>Nom :</b> <?= $dev['nom'] ?></p>
<p><b>Email :</b> <?= $dev['email'] ?></p>
<p><b>Specialite :</b> <?= $dev['specialite'] ?></p>

<h3>Projets affectes</h3>

<table border="1">
<tr>
    <th>Projet</th>
    <th>Statut</th>
    <th>Role</th>
    <th>Date</th>
</tr>

<?php while($p = $stmt->fetch()) { ?>
<tr>
    <td><?= $p['titre'] ?></td>
    <td><?= $p['statut'] ?></td>
    <td><?= $p['role'] ?></td>
    <td><?= $p['date_affectation'] ?></td>
</tr>
<?php } ?>
</table>

<br>
<a href="Liste_Developpeurs.php">Retour</a>
<a href="Modifier_Developpeur.php?id=<?= $dev['id'] ?>">Modifier</a>
<a href="Supprimer_Developpeur.php?id=<?= $dev['id'] ?>">Supprimer</a>