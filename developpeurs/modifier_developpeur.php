<?php
require_once "../Config/Database.php";
$db = new Database();
$conn = $db->connect();

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM developpeurs WHERE id=?");
$stmt->execute([$id]);
$dev = $stmt->fetch();

if (isset($_POST['update'])) {
    $nom = $_POST['nom'];
    $specialite = $_POST['specialite'];

    $stmt = $conn->prepare(
        "UPDATE developpeurs SET nom=?, specialite=? WHERE id=?"
    );
    $stmt->execute([$nom,$specialite,$id]);

    header("Location: Liste_Developpeurs.php");
}
?>

<h2>Modifier developpeur</h2>

<form method="POST">
    <input type="text" name="nom" value="<?= $dev['nom'] ?>" required><br>
    <input type="text" name="specialite" value="<?= $dev['specialite'] ?>"><br><br>

    <button name="update">Modifier</button>
    <a href="Liste_Developpeurs.php">Retour</a>
</form>
