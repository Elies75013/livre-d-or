<?php
include 'config.php';
if (!isset($_SESSION['login']) || $_SESSION['login'] != 'admin') {
    header("Location: index.php");
    exit;
}

$users = $pdo->query("SELECT id, login, prenom, nom FROM utilisateurs")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Administration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="profil.php">Profil</a>
        <a href="logout.php">Déconnexion</a>
    </nav>
    <div class="container">
        <h2>Utilisateurs</h2>
        <table>
            <tr><th>ID</th><th>Login</th><th>Prénom</th><th>Nom</th></tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['login'] ?></td>
                    <td><?= $user['prenom'] ?></td>
                    <td><?= $user['nom'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>