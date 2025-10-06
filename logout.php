<?php
// filepath: c:\laragon\www\runtrack2\livre d'or\logout.php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: connexion.php');
    exit;
}
session_unset();
session_destroy();
header('Location: connexion.php');
exit;