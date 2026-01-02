<?php
require_once "../Config/Database.php";
$db = new Database();
$conn = $db->connect();

$id = $_GET['id'];

if (isset($_POST['confirm'])) {
    $stmt = $conn->prepare("DELETE FROM developpeurs WHERE id=?");
    $stmt->execute([$id]);
    header("Location: Liste_Developpeurs.php");
}
?>
<h3> Voulez-vous vraiment supprimer ce developpeur ?</h3>

<form method="POST">
    <button name="confirm">oui, supprimer</button>
    <a href="Liste_Developpeurs.php">Annuler</a>
</form>

