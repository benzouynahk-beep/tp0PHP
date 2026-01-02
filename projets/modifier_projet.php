<?php
require_once "../Config/Database.php";
$db = new Database();
$conn = $db->connect();

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM projets WHERE id=?");
$stmt->execute([$id]);
$projet = $stmt->fetch();

$techs = $conn->query("SELECT * FROM technologies");

$stmt = $conn->prepare("SELECT technologie_id FROM projet_technologie WHERE projet_id=?");
$stmt->execute([$id]);
$selected = $stmt->fetchAll(PDO::FETCH_COLUMN);

if(isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE projets SET titre=?, type_projet=?, date_debut=?, date_fin=?, description=?, statut=? WHERE id=?");
    $stmt->execute([$_POST['titre'],$_POST['type'],$_POST['date_debut'],$_POST['date_fin'],$_POST['description'],$_POST['statut'],$id]);
    $conn->prepare("DELETE FROM projet_technologie WHERE projet_id=?")->execute([$id]);

    if(!empty($_POST['technologies'])) {
        foreach($_POST['technologies'] as $tech_id) {
            $conn->prepare("INSERT INTO projet_technologie (projet_id,technologie_id) VALUES (?,?)")->execute([$id,$tech_id]);
        }
    }

    header("Location: liste_projets.php");
}
?>



<h2>Modifier projet</h2>

<form method="POST">
    <input type="text" name="titre" value="<?= $projet['titre'] ?>" required><br>
    <input type="text" name="type" value="<?= $projet['type_projet'] ?>" required><br>
    <input type="date" name="date_debut" value="<?= $projet['date_debut'] ?>"><br>
    <input type="date" name="date_fin" value="<?= $projet['date_fin'] ?>"><br>
    <textarea name="description"><?= $projet['description'] ?></textarea><br>

    <select name="statut">
        <option value="en attente" <?= $projet['statut']=="en attente"?"selected":"" ?>>En attente</option>
        <option value="en cours" <?= $projet['statut']=="en cours"?"selected":"" ?>>En cours</option>
        <option value="termine" <?= $projet['statut']=="termine"?"selected":"" ?>>Termine</option>
    </select>

    <h4>Technologies</h4>
    <?php while($t = $techs->fetch()) { ?>
        <input type="checkbox" name="technologies[]" value="<?= $t['id'] ?>" <?= in_array($t['id'],$selected)?"checked":"" ?>>
        <?= $t['nom'] ?><br>
    <?php } ?>

    <button name="update">Modifier</button>
    <a href="liste_projets.php">Retour</a>
</form>