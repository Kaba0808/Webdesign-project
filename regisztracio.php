<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztrációs oldal</title>
    <link rel="stylesheet" href="styles/bejelentkezes_regisztracio.css">
</head>
<body>
    <div id="menu-container">
        <div class="menu-icon" onclick="toggleMenu()">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <nav id="menu" class="menu-container">
            <a href="index.php" class="link">Kezdőlap</a>
            <a href="bejelentkezes.php" class="link">Bejelentkezés</a>
            <a href="sorsolaslekerdezes.php" class="link">Számaid lekérdezése</a>
        </nav>
    </div>

    <main>
        <h1>Adja meg adatait a regisztrációhoz!</h1>
        <form action="" method="post" onsubmit="return ellenorizKor() && ellenorizJelszoEgyezes();">
            <img src="img/avatar.png" alt="avatar">

            <label for="firstname">Keresztnév*</label>
            <input type="text" id="username1" name="firstname"  placeholder="Péter"  maxlength="50" required><br>

            <label for="surname">Vezetéknév*</label>
            <input type="text" id="username2" name="surname" placeholder="Pék" maxlength="50" required><br>

            <label for="birthdate">Születési dátum*</label>
            <input type="date" id="birthdate" name="birthdate" required><br><br><br>

            <label for="username">Felhasználónév*</label>
            <input type="text" id="username3" name="username" placeholder="pékpeti30" maxlength="30" required><br>

            <label for="email">E-mail cím*</label>
            <input type="email" id="email" name="email"  placeholder="pekpetya@gmail.com"  maxlength="50" required><br>

            <label for="telnumber">Telefonszám*</label>
            <input type="text" id="telnumber" name="telnumber"  placeholder="06301234567"  maxlength="15" required><br>

            <label for="password">Jelszó*</label>
            <input type="password" id="password" name="password" placeholder="Mindig használjon erős jelszót, és sose ossza meg mással!" minlength="6" maxlength="30" required><br>

            <label for="confirm_password">Jelszó megerősítése*</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Mindig használjon erős jelszót, és sose ossza meg mással!" minlength="6" maxlength="30" required><br>

            <input type="checkbox" id="nyilatkozat1" name="nyilatkozat1" required>
            <label for="nyilatkozat1">Kijelentem, hogy saját nevemben regisztrálok és elfogadom a Részvételi szabályzatot.</label><br>

            <input type="checkbox" id="nyilatkozat2" name="nyilatkozat2" required>
            <label for="nyilatkozat2">Kijelentem, hogy a szolgáltatáshoz kapcsolódó adatkezelési tájékoztató tartalmát megismertem, az abban foglaltakat megértettem, személyes adataimat annak ismeretében bocsátom a SZTE Játék Zrt. rendelkezésére.</label><br>
            <input type="submit" value="Regisztráció" onclick="return ellenorizMezokKitoltese() && ellenorizJelszoEgyezes() && window.location.href == 'index.php' ">

            <div id="result" style="text-align: center;"></div>
            <div id="countdown" style="text-align: center;"></div>
        </form>
    </main>

    <footer>
        <p>© 2024 SZTE Játék Zrt. Minden jog fenntartva.</p>
    </footer>

    <script src="scripts/regisztracio.js"></script>
    <?php
    session_start();
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mydb";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Kapcsolódási hiba: " . $conn->connect_error);
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstname = $_POST['firstname'];
        $surname = $_POST['surname'];
        $birthdate = $_POST['birthdate'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $telnumber = $_POST['telnumber'];
    
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            echo "<script>handleResult(false);</script>";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (firstname, surname, birthdate, username, password, email, telnumber) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $firstname, $surname, $birthdate, $username, $password, $email, $telnumber);
    
            if ($stmt->execute() === TRUE) {
                echo "<script>handleResult(true);</script>";
            } else {
                echo "<script>handleResult(false);</script>";
            }
        }
    }
    
    $conn->close();
    ?>    
</body>
</html>