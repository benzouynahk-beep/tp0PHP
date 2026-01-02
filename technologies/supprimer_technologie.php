<?php
require_once "../Config/Database.php";
$db = new Database();
$conn = $db->connect();

$id = $_GET['id'];

if (isset($_POST['confirm'])) {
    $stmt = $conn->prepare("DELETE FROM technologies WHERE id=?");
    $stmt->execute([$id]);
    header("Location: Liste_Technologies.php");
}
?>
<h3>Voulez-vous vraiment supprimer cette technologie ?</h3>

<form method="POST">
    <button name="confirm">oui, supprimer</button>
    <a href="Liste_Technologies.php">Annuler</a>
</form>
