<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=livreor;charset=utf8', 'root', '');

// Requête sans alias pour éviter toute confusion
$stmt = $pdo->query("SELECT commentaires.commentaire, commentaires.date, utilisateurs.login FROM commentaires JOIN utilisateurs ON commentaires.id_utilisateur = utilisateurs.id ORDER BY commentaires.date DESC");
$commentaires = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Livre d'or</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
    <a href="index.php">Accueil</a>
    <a href="livre-or.php">Livre d'or</a>
    <?php if (isset($_SESSION['login'])): ?>
        <a href="profil.php">Profil</a>
        <a href="logout.php">Déconnexion</a>
    <?php else: ?>
        <a href="connexion.php">Connexion</a>
        <a href="inscription.php">Inscription</a>
    <?php endif; ?>
</nav>
<div class="container">
    <h2>Livre d'or</h2>
    <?php if (isset($_SESSION['login'])): ?>
        <p><a href="commentaire.php">Ajouter un commentaire</a></p>
    <?php endif; ?>
    <?php foreach ($commentaires as $com): ?>
        <div class="commentaire">
            <p style="font-size:0.9em;color:#555;">
                Posté le <?= date('d/m/Y', strtotime($com['date'])) ?> par <?= htmlspecialchars($com['login']) ?>
            </p>
            <p><?= nl2br(htmlspecialchars($com['commentaire'])) ?></p>
            <hr>
        </div>
    <?php endforeach; ?>
    <?php if (empty($commentaires)): ?>
        <p>Aucun commentaire pour le moment.</p>
    <?php endif; ?>
</div>
</body>
</html>