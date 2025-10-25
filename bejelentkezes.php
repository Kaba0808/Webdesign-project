<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="styles/bejelentkezes_regisztracio.css">
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
                <a href="regisztracio.php" class="link">Regisztráció</a>
                <a href="sorsolaslekerdezes.php" class="link">Számaid lekérdezése</a>
            </nav>
        </div>
        <div class="container">
            <h1 id="pageTitle">Bejelentkezés</h1>
        </div>
    </header>

    <main>
        <div id="loginPage">
            <h1>Bejelentkezés</h1>
            <form action="bejelentkezes.php" method="post" id="loginForm">
                <img src="img/avatar.png" alt="Példa">
                <label for="username">Felhasználónév *</label><br>
                <input type="text" id="username" name="username" placeholder="pékpeti30" maxlength="30" required><br>
                <label for="password">Jelszó*</label><br>
                <input type="password" id="password" name="password" placeholder="Jelszó" minlength="6" maxlength="30" required><br>
                <input type="submit" value="Bejelentkezés">
                <p>Ha még nincs fiókja, <a href="regisztracio.php">regisztráljon itt</a>!</p>
                <div id="result" style="text-align: center;"></div>
                <div id="countdown" style="text-align: center;"></div>
            </form>
        </div>
    </main>

    <footer>
        <p>© 2024 SZTE Játék Zrt. Minden jog fenntartva.</p>
    </footer>

    <script src="scripts/bejelentkezes.js"></script>

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
        // Felhasználó által megadott adatok fogadása a bejelentkezési űrlapról
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];
            // SQL lekérdezés a felhasználó adatainak ellenőrzésére
            $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if (password_verify($password, $row['password'])) {
                        // Sikeres bejelentkezés esetén tároljuk el a felhasználó adatait a munkamenetben
                        $_SESSION['user'] = $row;
                        // Ellenőrizzük, hogy admin-e a felhasználó
                        if ($row['role'] === 'admin') {
                            $_SESSION['admin'] = true;
                        } else {
                            $_SESSION['admin'] = false;
                        }
                        echo "<script>handleResult(true, " . json_encode($row) . ");</script>";
                    } else {
                        echo "<script>handleResult(false);</script>";
                    }
                }
            } else {
                echo "<script>handleResult(false);</script>";
            }
        }
        $conn->close();
    ?>
</body>
</html>