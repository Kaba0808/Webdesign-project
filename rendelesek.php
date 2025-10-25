<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myDB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

$user = array('firstname' => '', 'surname' => '', 'username' => '', 'email' => '', 'birthdate' => '');

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    header("Location: bejelentkezes.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $user = $row;
                break;
            }
        }
    }
}

$stmt = $conn->prepare("SELECT quantity, total_price FROM purchases WHERE username=?");
$stmt->bind_param("s", $user['username']);
$stmt->execute();
$result = $stmt->get_result();

$purchases = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $purchases[] = $row;
    }
}

$stmt = $conn->prepare("SELECT selected_numbers FROM szamok WHERE is_validated = 1 AND username=?");
$stmt->bind_param("s", $user['username']);
$stmt->execute();
$result = $stmt->get_result();

$is_validated = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $is_validated[] = $row['selected_numbers'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendelesek</title>
    <link rel="stylesheet" href="styles/rendelesek.css">
</head>
<body>
    <div id="menu-container">
        <div class="menu-icon" onclick="toggleMenu()">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <nav id="menu" class="menu-container">
            <a href="kosar.php" class="link">Kosár</a>
            <a href="lottoszelveny.php" class="link">Szelvények</a>
            <a href="sorsolaslekerdezes.php" class="link">Számaid lekérdezése</a>
            <a href="profil.php" class="link">Profil</a>
        </nav>
    </div>

    <main>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th colspan="4">Kifizetett szelvényeim</th>
                    </tr>
                    <tr>
                        <th>Szelvények</th>
                        <th>Ára</th>
                        <th>Számok</th>
                        <th>Hét</th>
                    </tr>
                </thead>
                <tbody style="background-color: white;">
                    <?php $i = 1; foreach ($is_validated as $selected_numbers):
                        $currentWeek = date('W');
                    ?>
                        <tr>
                            <td><?php echo $i . "."; ?></td>
                            <td>1200 Ft</td>
                            <td>
                                <?php echo $selected_numbers; ?>
                            </td>
                            <td>
                                <?php echo $currentWeek . '.'; ?>
                            </td>
                        </tr>
                    <?php $i++; endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 SZTE Játék Zrt. Minden jog fenntartva.</p>
    </footer>

    <script src="scripts/bemutato.js"></script>
</body>
</html>