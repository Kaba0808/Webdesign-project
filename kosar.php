<?php
session_start();

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['user'])) {
    header("Location: bejelentkezes.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Sikertelen kapcsolódás: " . $conn->connect_error);
}

// A felhasználó által még nem validált szelvények lekérdezése
$username = $_SESSION['user']['username'];
$stmt = $conn->prepare("SELECT selected_numbers FROM szamok WHERE username = ? AND is_validated = 0");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$unvalidated_tickets = [];
while ($row = $result->fetch_assoc()) {
    $unvalidated_tickets[] = $row['selected_numbers'];
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vásárlás</title>
    <link rel="stylesheet" href="styles/kosar.css">
</head>
<body>
    <header>
        <div id="menu-container">
            <div class="menu-icon" onclick="toggleMenu()">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <nav id="menu" class="menu-container">
                <a href="index.php" class="link">Kezdőlap</a>
                <a href="lottoszelveny.php" class="link">Szelvények</a>
                <a href="hetinyertesek.php" class="link">Heti Nyertesek</a>
                <a href="profil.php" class="link">Profil</a>
            </nav>
        </div>
    </header>
    <main>
        <h1 class="header-content" id="pageTitle">Szelvények kifizetése</h1>
        <section id="kosarSection">
            <h2>Kosár tartalma</h2>
            <form id="szelvenyForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <ul id="kosarTartalom">
                    <?php 
                    if (count($unvalidated_tickets) == 0) {
                        echo 'Nincsen egy feladott szelvényed sem, <a href="lottoszelveny.php">itt</a> feladhatsz újat.';
                    } else {
                        $szelvenyekSzama = count($unvalidated_tickets);
                        if ($szelvenyekSzama > 6) {
                            $szelvenyekSzama = 6; // Maximum 6 szelvény jelenjen meg
                        }
                        for ($i = 0; $i < $szelvenyekSzama; $i++) { 
                            $ticket = $unvalidated_tickets[$i]; ?>
                            <li>Szelvény: <?php echo $ticket; ?></li>
                        <?php } 
                    } ?>
                </ul>
                <p id="total">Összesen: <?php echo min(count($unvalidated_tickets), 6) * 1200; ?> Ft</p>
                <input type="hidden" id="total_price" name="total_price" value="<?php echo min(count($unvalidated_tickets), 6) * 1200; ?>">
                <input type="submit" name="submit_payment" value="Fizetés" <?php echo count($unvalidated_tickets) == 0 ? 'disabled' : ''; ?>>
                <div id="result" style="text-align: center;"></div>
                <div id="countdown" style="text-align: center;"></div>
            </form>
        </section>
    </main>
    <footer>
        <p>© 2024 SZTE Játék Zrt. Minden jog fenntartva.</p>
    </footer>

    <script>
        function toggleMenu() {
            var menuContainer = document.getElementById("menu-container");
            var menuIcon = document.querySelector(".menu-icon");
            menuContainer.classList.toggle("open");
            menuIcon.classList.toggle("open");
        }
        document.addEventListener('click', function(event) {
            var menuContainer = document.getElementById("menu-container");
            var menuIcon = document.querySelector(".menu-icon"); 
            if (menuContainer.classList.contains("open") && !menuContainer.contains(event.target) && !menuIcon.contains(event.target)) {
                menuContainer.classList.remove("open");
            }
        });
        function handleTransactionResult(success) {
            let resultDiv = document.getElementById('result');
            let countdownElement = document.getElementById('countdown');
            if (success) {
                resultDiv.innerHTML = '<p style="color:green;">Sikeres tranzakció!</p>';
                let countdown = 3;
                countdownElement.textContent = 'Átirányítás a Korábbi rendelések oldalra ' + countdown + ' másodperc múlva.';
                let intervalId = setInterval(function() {
                    countdown--;
                    countdownElement.textContent = 'Átirányítás a Korábbi rendelések oldalra ' + countdown + ' másodperc múlva.';
                    if (countdown <= 0) {
                        clearInterval(intervalId);
                        window.location.href = "rendelesek.php";
                    }
                }, 1000);
            } else {
                resultDiv.innerHTML = '<p style="color:red;">Sikertelen tranzakció!</p>';
            }
        }
    </script>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_payment'])) {
            // A fizetés gomb lenyomásakor frissítjük az adatbázist és végrehajtjuk a tranzakciót
            $total_price = $_POST['total_price'];

            // Fizetés rögzítése az adatbázisban
            $stmt = $conn->prepare("INSERT INTO purchases (username, total_price) VALUES (?, ?)");
            $stmt->bind_param("si", $_SESSION['user']['username'], $total_price);

            if ($stmt->execute() === TRUE) {
                // Ha a tranzakció sikeres, frissítjük a szelvények állapotát
                $currentWeek = date('W');
                $stmt = $conn->prepare("UPDATE szamok SET is_validated = 1, week = ? WHERE username = ? AND is_validated = 0");
                $stmt->bind_param("is", $currentWeek, $_SESSION['user']['username']);
                $stmt->execute();

                echo "<script>handleTransactionResult(true);</script>";
            } else {
                echo "<script>handleTransactionResult(false);</script>";
            }
        }
    ?>
</body>
</html>