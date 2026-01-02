<?php
require_once "../Config/Database.php";
$db = new Database();
$conn = $db->connect();

$id = $_GET['id'];

if(isset($_POST['confirm'])) {
    $conn->prepare("DELETE FROM projets WHERE id=?")->execute([$id]);
    header("Location: liste_projets.php");
}
?>
<h3> Voulez vous vraiment supprimer ce projet ?</h3>

<form method="POST">
    <button name="confirm">oui, supprimer</button>
    <a href="liste_projets.php">Annuler</a>
</form>