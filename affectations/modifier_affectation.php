<?php
require_once "../Config/Database.php";
$db = new Database();
$conn = $db->connect();

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM affections WHERE id=?");
$stmt->execute([$id]);
$aff = $stmt->fetch();

$devs = $conn->query("SELECT * FROM developpeurs");

$projets = $conn->query("SELECT * FROM projets WHERE statut='en cours'");

if(isset($_POST['update'])) {
    $dev_id = $_POST['developpeur_id'];
    $projet_id = $_POST['projet_id'];
    $role = $_POST['role'];
    $stmt_check = $conn->prepare("SELECT * FROM affections WHERE developpeur_id=? AND projet_id=? AND id<>?");
    $stmt_check->execute([$dev_id,$projet_id,$id]);
    if($stmt_check->rowCount() > 0) {
        $error = "Ce développeur est déjà affecté à ce projet !";
    } else {
        $stmt = $conn->prepare("UPDATE affections SET developpeur_id=?, projet_id=?, role=? WHERE id=?");
        $stmt->execute([$dev_id,$projet_id,$role,$id]);
        header("Location: liste_affectations.php");
    }
}
?>

<h2>Modifier affectation</h2>

<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">
    <label>Developpeur :</label>
    <select name="developpeur_id" required>
        <?php while($d = $devs->fetch()) { ?>
            <option value="<?= $d['id'] ?>" <?= $aff['developpeur_id']==$d['id']?"selected":"" ?>><?= $d['nom'] ?></option>
        <?php } ?>
    </select><br>

    <label>Projet (en cours) :</label>
    <select name="projet_id" required>
        <?php while($p = $projets->fetch()) { ?>
            <option value="<?= $p['id'] ?>" <?= $aff['projet_id']==$p['id']?"selected":"" ?>><?= $p['titre'] ?></option>
        <?php } ?>
    </select><br>

    <label>Role :</label>
    <input type="text" name="role" value="<?= $aff['role'] ?>" required><br><br>

    <button name="update">Modifier</button>
    <a href="liste_affectations.php">Retour</a>
</form>