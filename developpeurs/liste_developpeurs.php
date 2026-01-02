
<?php
include "../Config/Database.php"; 


$projets = $pdo->query("SELECT * FROM projet")->fetchAll();


$name_filter = isset($_GET['name']) ? $_GET['name'] : '';
$project_filter = isset($_GET['project_id']) ? $_GET['project_id'] : '';

$sql = "SELECT d.*, COUNT(a.id_projet) as nb_projets 
        FROM developpeur d 
        LEFT JOIN affectation a ON d.id_dev = a.id_dev 
        WHERE d.nom_dev LIKE :name";

if ($project_filter != '') {
    $sql .= " AND d.id_dev IN (SELECT id_dev FROM affectation WHERE id_projet = :proj_id)";
}

$sql .= " GROUP BY d.id_dev";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'name' => "%$name_filter%"
] + ($project_filter != '' ? ['proj_id' => $project_filter] : []));
$developers = $stmt->fetchAll();
?>

<h2>Liste des Developpeurs</h2>

<form method="GET">
    <input type="text" name="name" placeholder="Nom du developpeur" value="<?= $name_filter ?>">
    <select name="project_id">
        <option value="">Tous les projets</option>
        <?php foreach($projets as $p): ?>
            <option value="<?= $p['id_projet'] ?>" <?= $project_filter == $p['id_projet'] ? 'selected' : '' ?>>
                <?= $p['nom_projet'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Filtrer</button>
</form>

<table border="1">
    <tr>
        <th>Nom</th>
        <th>Specialite</th>
        <th>Nb Projets</th>
        <th>Actions</th>
    </tr>
    <?php foreach($developers as $dev): ?>
    <tr>
        <td><?= $dev['nom_dev'] ?></td>
        <td><?= $dev['specialite'] ?></td>
        <td><?= $dev['nb_projets'] ?></td>
        <td>
            <a href="details_developpeurs.php?id=<?= $dev['id_dev'] ?>">Details</a>
            <a href="modifier_developpeur.php?id=<?= $dev['id_dev'] ?>">Modifier</a>
            <a href="supprimer_developpeur.php?id=<?= $dev['id_dev'] ?>" onclick="return confirm('Confirmer?')">Supprimer</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>