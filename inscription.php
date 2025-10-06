<?php 
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=livreor;charset=utf8', 'root', '');

if ($_POST) {
    $login = $_POST['login'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    
    // Vérifier si le login existe déjà
    $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE login = ?");
    $stmt->execute([$login]);
    if ($stmt->fetch()) {
        $erreur = "Ce login existe déjà.";
    } elseif ($password == $confirm) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO utilisateurs (login, prenom, nom, password) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$login, $prenom, $nom, $password_hash]);
        header("Location: connexion.php");
        exit;
    } else {
        $erreur = "Les mots de passe ne correspondent pas.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="connexion.php">Connexion</a>
    </nav>
    <div class="container">
        <h2>Inscription</h2>
        <form method="post">
            <input type="text" name="login" placeholder="Login" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="password" name="confirm" placeholder="Confirmer" required>
            <input type="submit" value="S'inscrire">
        </form>
        <?php if (isset($erreur)): ?>
            <p style="color: red;"><?= $erreur ?></p>
        <?php endif; ?>
    </div>
</body>
</html>