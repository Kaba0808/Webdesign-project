<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

// Kapcsolat létrehozása és ellenőrzése
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['user'])) {
    header("Location: bejelentkezes.php");
    exit;
}

// Szelvény feladása gomb lenyomása esetén
if (isset($_POST['submit_lotto'])) {
    $isValid = true;
    for ($j = 1; $j <= 6; $j++) {
        $selected_numbers = isset($_POST['selected_numbers'.$j]) ? $_POST['selected_numbers'.$j] : array(); // A kiválasztott számok tömbje
        $username = $_SESSION['user']['username']; // A felhasználónév kinyerése a munkamenetből

        // pontosan 6 szám van kiválasztva
        if (count($selected_numbers) != 6) {
            $_SESSION['alertMessage'] = "Kérjük, válasszon ki pontosan 6 számot a ".$j.". táblázatban!";
            $isValid = false;
            break;
        }
    }

    if ($isValid) {
        for ($j = 1; $j <= 6; $j++) {
            $selected_numbers = $_POST['selected_numbers'.$j];
            $selected_numbers_str = implode(" ", $selected_numbers);

            $stmt = $conn->prepare("INSERT INTO szamok (username, selected_numbers, timestamp, is_validated) VALUES (?, ?, NOW(), 0)");
            $stmt->bind_param("ss", $username, $selected_numbers_str);

            if ($stmt->execute() !== TRUE) {
                $_SESSION['alertMessage'] = "Hiba történt a szelvénye feladása közben.";
                break;
            }
        }

        if (!isset($_SESSION['alertMessage'])) {
            $_SESSION['alertMessage'] = "A szelvénye sikeresen fel lett adva!";
            header("Location: kosar.php");
            exit;
        }
    }
}

if (isset($_SESSION['alertMessage'])) {
    echo '<script>alert("' . $_SESSION['alertMessage'] . '");</script>';
    unset($_SESSION['alertMessage']);  
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lottószelvény kitöltés</title>
    <link rel="stylesheet" href="styles/lottoszelveny.css">
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
            <a href="sorsolaslekerdezes.php" class="link">Számaid lekérdezése</a>
            <a href="kosar.php" class="link">Kosár</a>
            <a href="profil.php" class="link">Profil</a>
        </nav>
    </div>
</header>

<main>
    <h1>Töltse ki szelvényét!</h1>

    <form id="lottoForm" action="" method="post">
        <div class="table-container">
            <?php for ($j = 1; $j <= 3; $j++): ?>
                <table id="lotto<?php echo $j; ?>">
                    <tbody>
                    <?php for ($i = 1; $i <= 90; $i++): ?>
                        <?php if (($i - 1) % 10 == 0): ?>
                            <tr>
                        <?php endif; ?>
                        <td>
                            <label>
                                <input type="checkbox" name="selected_numbers<?php echo $j; ?>[]" value="<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </label>
                        </td>
                        <?php if ($i % 10 == 0): ?>
                            </tr>
                        <?php endif; ?>
                    <?php endfor; ?>
                    </tbody>
                </table>
            <?php endfor; ?>
        </div>

        <div class="table-container">
            <?php for ($j = 4; $j <= 6; $j++): ?>
                <table id="lotto<?php echo $j; ?>">
                    <tbody>
                    <?php for ($i = 1; $i <= 90; $i++): ?>
                        <?php if (($i - 1) % 10 == 0): ?>
                            <tr>
                        <?php endif; ?>
                        <td>
                            <label>
                                <input type="checkbox" name="selected_numbers<?php echo $j; ?>[]" value="<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </label>
                        </td>
                        <?php if ($i % 10 == 0): ?>
                            </tr>
                        <?php endif; ?>
                    <?php endfor; ?>
                    </tbody>
                </table>
            <?php endfor; ?>
        </div>

        <div class="submit-container">
            <input class="submit-button" type="submit" name="submit_lotto" value="Kosárba helyezés">
        </div>
    </form>
</main>

<footer>
    <p>&copy; 2024 SZTE Játék Zrt. Minden jog fenntartva.</p>
</footer>

<script src="scripts/bemutato.js"></script>
<script>
    document.getElementById('lottoForm').addEventListener('submit', function(event) {
        let isValid = true;
        for (let j = 1; j <= 6; j++) {
            let selectedNumbers = document.querySelectorAll(`input[name="selected_numbers${j}[]"]:checked`);
            if (selectedNumbers.length != 6) {
                alert(`Kérjük, válasszon ki pontosan 6 számot a ${j}. táblázatban!`);
                isValid = false;
                break;
            }
        }

        if (!isValid) {
            event.preventDefault(); // Megszakítjuk a formázási eseményt
        }
    });
</script>
</body>
</html>