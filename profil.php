    <?php
include 'config.php';

if (!isset($_SESSION['login'])) {
    header("Location: connexion.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
$stmt->execute([$_SESSION['id']]);
$user = $stmt->fetch();

if ($_POST) {
    $new_login = $_POST['login'];
    $new_prenom = $_POST['prenom'];
    $new_nom = $_POST['nom'];

    $update = $pdo->prepare("UPDATE utilisateurs SET login = ?, prenom = ?, nom = ? WHERE id = ?");
    $update->execute([$new_login, $new_prenom, $new_nom, $_SESSION['id']]);

    $_SESSION['login'] = $new_login;
    $_SESSION['prenom'] = $new_prenom;
    $_SESSION['nom'] = $new_nom;

    $message = "Profil mis à jour !";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="logout.php">Déconnexion</a>
        <?php if ($_SESSION['login'] === 'admin'): ?>
            <a href="admin.php">Admin</a>
        <?php endif; ?>
    </nav>
    <div class="container">
        <h2>Mon Profil</h2> 
        <form method="post">
            <input type="text" name="login" value="<?= $user['login'] ?>" required>
            <input type="text" name="prenom" value="<?= $user['prenom'] ?>" required>
            <input type="text" name="nom" value="<?= $user['nom'] ?>" required>
            <input type="submit" value="Mettre à jour">
        </form>
        <?php if (isset($message)): ?>
            <p style="color: green;"><?= $message ?></p>
        <?php endif; ?>
    </div>
</body>
</html>