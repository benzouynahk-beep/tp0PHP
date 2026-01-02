<?php
require_once "../Config/Database.php";
$db = new Database();
$conn = $db->connect();

$id = $_GET['id'];

if(isset($_POST['confirm'])) {
    $conn->prepare("DELETE FROM affections WHERE id=?")->execute([$id]);
    header("Location: liste_affectations.php");
}
?>
<h3>Voulez vous vraiment supprimer cette affectation ?</h3>

<form method="POST">
    <button name="confirm">oui, supprimer</button>
    <a href="liste_affectations.php">Annuler</a>
</form>