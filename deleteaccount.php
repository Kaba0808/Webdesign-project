<?php

session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

// Adatbázis kapcsolat létrehozása
$conn = new mysqli($servername, $username, $password, $dbname);

// Kapcsolódás ellenőrzése
if ($conn->connect_error) {
    die("Kapcsolódásihiba: " . $conn->connect_error);
}

// Felhasználó törlése és kijelentkeztetés, ha a felhasználó be van jelentkezve és meg lett adva a jelszó
if (isset($_SESSION['user']) && isset($_POST['password'])) {
    // Felhasználó jelszavának lekérése az adatbázisból
    $stmt = $conn->prepare('SELECT password FROM users WHERE username = ?');
    $stmt->bind_param('s', $_SESSION['user']['username']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Jelszó ellenőrzése
    if (password_verify($_POST['password'], $user['password'])) {
        // Felhasználó törlése az adatbázisból
        $stmt = $conn->prepare('DELETE FROM users WHERE username = ?');
        $stmt->bind_param('s', $_SESSION['user']['username']);
        $stmt->execute();

        // PHP munkamenet törlése és bezárása
        session_unset();
        session_destroy();
    }
}


$conn->close();

// Visszairányítás a regisztráció oldalra
header("Location: regisztracio.php");
exit;
?>