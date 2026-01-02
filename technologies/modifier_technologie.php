<?php
require_once "../Config/Database.php";
$db = new Database();
$conn = $db->connect();

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM technologies WHERE id=?");
$stmt->execute([$id]);
$tech = $stmt->fetch();

if (isset($_POST['update'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];

    $stmt = $conn->prepare(
        "UPDATE technologies SET nom=?, description=? WHERE id=?"
    );
    $stmt->execute([$nom, $description, $id]);

    header("Location: Liste_Technologies.php");
}
?>
<h2>Modifier technologie</h2>

<form method="POST">
    <input type="text" name="nom" value="<?= $tech['nom'] ?>" required><br>
    <textarea name="description"><?= $tech['description'] ?></textarea><br><br>

    <button name="update">Modifier</button>
    <a href="Liste_Technologies.php">Retour</a>
</form>