<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Accueil - Livre d'or</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
    <a href="index.php">Accueil</a>
    <a href="livre-or.php">Livre d'or</a>
    <?php if (isset($_SESSION['login'])): ?>
        <a href="profil.php">Profil</a>
        
    <?php else: ?>
        <a href="connexion.php">Connexion</a>
        <a href="inscription.php">Inscription</a>
        <a href="logout.php">Déconnexion</a>
    <?php endif; ?>
</nav>
<div class="container">
    <h1>Bienvenue sur le Livre d'or !</h1>
    <p>
        Ce site vous permet de laisser un message dans le livre d'or.<br>
        Inscrivez-vous, connectez-vous, et partagez vos impressions avec la communauté !
    </p>
    <p>
        Consultez les <a href="livre-or.php">commentaires</a> ou <a href="inscription.php">rejoignez-nous</a> pour participer.
    </p>
</div>
</body>
</html>