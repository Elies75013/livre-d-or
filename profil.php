<?php
session_start();
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=livreor;charset=utf8', 'root', '');

if (!isset($_SESSION['login']) || !isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
$stmt->execute([$_SESSION['id']]);
$user = $stmt->fetch();

if (!$user) {
    // Utilisateur non trouvé, déconnexion de sécurité
    session_destroy();
    header("Location: connexion.php");
    exit;
}

if ($_POST) {
    $new_login = $_POST['login'];
    $new_prenom = $_POST['prenom'];
    $new_nom = $_POST['nom'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérifier si le login existe déjà pour un autre utilisateur
    $check = $pdo->prepare("SELECT id FROM utilisateurs WHERE login = ? AND id != ?");
    $check->execute([$new_login, $_SESSION['id']]);
    if ($check->fetch()) {
        $message = "Ce login est déjà utilisé.";
    } else {
        // Mise à jour du login, prénom et nom
        $update = $pdo->prepare("UPDATE utilisateurs SET login = ?, prenom = ?, nom = ? WHERE id = ?");
        $update->execute([$new_login, $new_prenom, $new_nom, $_SESSION['id']]);
        $_SESSION['login'] = $new_login;
        $_SESSION['prenom'] = $new_prenom;
        $_SESSION['nom'] = $new_nom;

        // Mise à jour du mot de passe si renseigné et confirmé
        if (!empty($new_password) || !empty($confirm_password)) {
            if ($new_password === $confirm_password) {
                $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $updatePwd = $pdo->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
                $updatePwd->execute([$password_hash, $_SESSION['id']]);
                $message = "Profil et mot de passe mis à jour !";
            } else {
                $message = "Les mots de passe ne correspondent pas.";
            }
        } else {
            $message = "Profil mis à jour !";
        }
    }
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
        <?php if (isset($_SESSION['login']) && $_SESSION['login'] === 'admin'): ?>
            <a href="admin.php">Admin</a>
        <?php endif; ?>
    </nav>
    <div class="container">
        <h2>Mon Profil</h2> 
        <form method="post">
            <input type="text" name="login" value="<?= htmlspecialchars($user['login']) ?>" required>
            <input type="text" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required>
            <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
            <input type="password" name="password" placeholder="Nouveau mot de passe">
            <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe">
            <input type="submit" value="Mettre à jour">
        </form>
        <?php if (isset($message)): ?>
            <p style="color: green;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>