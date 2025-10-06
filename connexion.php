<?php
session_start();
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=livreor;charset=utf8', 'root', ''); 

if ($_POST) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['login'] = $user['login'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['nom'] = $user['nom'];
        header("Location: index.php");
        exit;
    } else {
        $erreur = "Login ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="inscription.php">Inscription</a>
        
    </nav>
    <div class="container">
        <h2>Connexion</h2>
        <form method="post">
            <input type="text" name="login" placeholder="Login" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="submit" value="Se connecter">
        </form>
        <?php if (isset($erreur)): ?>
            <p style="color: red;"><?= $erreur ?></p>
        <?php endif; ?>
    </div>
</body>
</html>