<?php
require_once "../Config/Database.php";
$db = new Database();
$conn = $db->connect();
$techs = $conn->query("SELECT * FROM technologies");
if(isset($_POST['submit'])) {
    $titre = $_POST['titre'];
    $type = $_POST['type'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $description = $_POST['description'];
    $stmt = $conn->prepare("INSERT INTO projets (titre,type_projet,date_debut,date_fin,description) VALUES (?,?,?,?,?)");
    $stmt->execute([$titre,$type,$date_debut,$date_fin,$description]);

    $projet_id = $conn->lastInsertId();
    if(!empty($_POST['technologies'])) {
        foreach($_POST['technologies'] as $tech_id) {
            $conn->prepare("INSERT INTO projet_technologie (projet_id,technologie_id) VALUES (?,?)")
                 ->execute([$projet_id,$tech_id]);
        }
    }

    header("Location: liste_projets.php");
}
?>

<h2>Ajouter projet</h2>

<form method="POST">
    <input type="text" name="titre" placeholder="Titre" required><br>
    <input type="text" name="type" placeholder="Type du projet" required><br>
    <input type="date" name="date_debut"><br>
    <input type="date" name="date_fin"><br>
    <textarea name="description" placeholder="Description"></textarea><br>

    <h4>Technologies utilisees</h4>
    <?php while($t = $techs->fetch()) { ?>
        <input type="checkbox" name="technologies[]" value="<?= $t['id'] ?>"> <?= $t['nom'] ?><br>
    <?php } ?>

    <br>
    <button name="submit">Enregistrer</button>
    <a href="liste_projets.php">Annuler</a>
</form>