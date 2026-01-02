<?php
require_once "../Config/Database.php";
$db = new Database();
$conn = $db->connect();

if (isset($_POST['submit'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];

    $stmt = $conn->prepare(
        "INSERT INTO technologies (nom,description) VALUES (?,?)"
    );
    $stmt->execute([$nom,$description]);

    header("Location: Liste_Technologies.php");
}
?>

<h2>Ajouter technologie</h2>

<form method="POST">
    <input type="text" name="nom" placeholder="Nom" required><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <button name="submit">Ajouter</button>
</form>

