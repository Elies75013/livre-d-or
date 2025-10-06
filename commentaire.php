<?php

session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

$pdo = new PDO('mysql:host=localhost;dbname=livreor;charset=utf8', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['commentaire'])) {
    $commentaire = trim($_POST['commentaire']);
    $stmt = $pdo->prepare("INSERT INTO commentaires (commentaire, id_utilisateur, date) VALUES (?, ?, NOW())");
    $stmt->execute([$commentaire, $_SESSION['id']]);
    header('Location: livre-or.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un commentaire</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
    <a href="index.php">Accueil</a>
    <a href="livre-or.php">Livre d'or</a>
    <a href="profil.php">Profil</a>
    <a href="logout.php">Déconnexion</a>
</nav>
<div class="container">
    <h2>Ajouter un commentaire</h2>
    <form method="post">
        <textarea name="commentaire" placeholder="Votre commentaire..." required></textarea>
        <br>
        <input type="submit" value="Poster">
    </form>
</div>
</body>
</html>