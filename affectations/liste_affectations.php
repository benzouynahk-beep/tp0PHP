<?php
require_once "../Config/Database.php";
$db = new Database();
$conn = $db->connect();

$filterStatut = isset($_GET['statut']) ? $_GET['statut'] : '';

$sql = "SELECT a.id, d.nom AS dev_nom, p.titre AS projet_titre, p.statut, a.date_affectation
        FROM affections a
        JOIN developpeurs d ON a.developpeur_id = d.id
        JOIN projets p ON a.projet_id = p.id";

if($filterStatut != '') {
    $sql .= " WHERE p.statut = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$filterStatut]);
} else {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}
?>
<h2>Liste des affectations</h2>

<form method="GET">
    <label>Filtrer par statut :</label>
    <select name="statut">
        <option value="">Tous</option>
        <option value="en cours" <?= $filterStatut=="en cours"?"selected":"" ?>>En cours</option>
        <option value="en attente" <?= $filterStatut=="en attente"?"selected":"" ?>>En attente</option>
        <option value="termine" <?= $filterStatut=="termine"?"selected":"" ?>>Termine</option>
    </select>
    <button>Filtrer</button>
</form>

<table border="1">
<tr>
    <th>Developpeur</th>
    <th>Projet</th>
    <th>Statut</th>
    <th>Date affectation</th>
    <th>Actions</th>
</tr>

<?php while($a = $stmt->fetch()) { ?>
<tr>
    <td><?= $a['dev_nom'] ?></td>
    <td><?= $a['projet_titre'] ?></td>
    <td><?= $a['statut'] ?></td>
    <td><?= $a['date_affectation'] ?></td>
    <td>
        <a href="modifier_affectation.php?id=<?= $a['id'] ?>">Modifier</a>
        <a href="supprimer_affectation.php?id=<?= $a['id'] ?>">Supprimer</a>
    </td>
</tr>
<?php } ?>
</table>

<a href="ajout_affectation.php">+ Ajouter affectation</a>