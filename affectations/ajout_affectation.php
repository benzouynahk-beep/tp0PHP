<?php
require_once "../Config/Database.php";
$db = new Database();
$conn = $db->connect();

$devs = $conn->query("SELECT * FROM developpeurs");

$projets = $conn->query("SELECT * FROM projets WHERE statut='en cours'");

if(isset($_POST['submit'])) {
    $dev_id = $_POST['developpeur_id'];
    $projet_id = $_POST['projet_id'];
    $role = $_POST['role'];
    $stmt = $conn->prepare("SELECT * FROM affections WHERE developpeur_id=? AND projet_id=?");
    $stmt->execute([$dev_id,$projet_id]);
    if($stmt->rowCount() > 0) {
        $error = "Ce developpeur est deja affecte ce projet !";
    } else {
        $stmt = $conn->prepare("INSERT INTO affections (developpeur_id, projet_id, role) VALUES (?,?,?)");
        $stmt->execute([$dev_id,$projet_id,$role]);
        header("Location: liste_affectations.php");
    }
}
?>
<h2>Ajouter affectation</h2>

<?php if(isset($error)) echo "<p>$error</p>"; ?>

<form method="POST">
    <label>Developpeur :</label>
    <select name="developpeur_id" required>
        <?php while($d = $devs->fetch()) { ?>
            <option value="<?= $d['id'] ?>"><?= $d['nom'] ?></option>
        <?php } ?>
    </select><br>

    <label>Projet (en cours) :</label>
    <select name="projet_id" required>
        <?php while($p = $projets->fetch()) { ?>
            <option value="<?= $p['id'] ?>"><?= $p['titre'] ?></option>
        <?php } ?>
    </select><br>

    <label>Role :</label>
    <input type="text" name="role" required><br><br>

    <button name="submit">Ajouter</button>
    <a href="liste_affectations.php">Annuler</a>
</form>



