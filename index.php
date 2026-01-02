<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}
?>
<nav>
    <a href="developpeurs/liste_developpeurs.php">Developpeurs</a>
    <a href="projets/liste_projets.php">Projets</a>
    <a href="Technologies/liste_technologies.php">Technologies</a>
    <a href="affectations/liste_affectations.php">Affectations</a>
    <a href="auth/logout.php">Deconnexion</a>
</nav>