<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Bemutató</title>
    <link rel="stylesheet" href="styles/nyeroszam_sorsolas.css">
</head>
<body>
    <div id="menu-container">
        <div class="menu-icon" onclick="toggleMenu()">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <nav id="menu" class="menu-container">
            <a href="sorsolaslekerdezes.php" class="link">Számaid lekérdezése</a>
            <?php
                session_start();
                if(!isset($_SESSION['user'])) {
                ?>
                <a href="bejelentkezes.php" class="link">Bejelentkezés</a>
                <?php
                }
            ?>
            <a href="regisztracio.php" class="link">Regisztráció</a>
            <?php
                if(isset($_SESSION['user'])) {
                ?>
                    <a href="lottoszelveny.php" class="link">Szelvények</a>
                    <a href="kosar.php" class="link">Kosár</a>
                    <a href="profil.php" class="link">Profil</a>
                <?php
                }
            ?>
        </nav>
    </div>
    <header>
        <div id="header-content">
            <h1>SZTE Játék Zrt.</h1>
        </div>
    </header>
    <main>
        <div id="numbersContainer" class="number"></div>
        <form id="numbersForm" action="" method="post">
            <input type="hidden" id="numbersInput" name="numbers">
            <input type="hidden" id="weekInput" name="week">
            <button id="drawButton" type="button" onclick="drawNumbers()">Nyerőszám Sorsolás</button>
            <button id="saveButton" type="submit" >Mentés</button>
        </form>
    </main>

    <script src="scripts/sorsolas.js"></script>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "mydb";
    
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            echo "<script>document.getElementById('numbersContainer').innerText = 'Kapcsolódási hiba történt.';</script>";
            exit();
        }
    
        $numbers = $_POST['numbers'];
        $week = $_POST['week'];
    
        // Ellenőrizzük, hogy az adott hét számához már van-e tárolt nyerőszám
        $checkQuery = $conn->prepare("SELECT * FROM drawnumbers WHERE week = ?");
        $checkQuery->bind_param("s", $week);
        $checkQuery->execute();
        $result = $checkQuery->get_result();
        if ($result->num_rows > 0) {
            echo "<script>document.getElementById('numbersContainer').innerText = 'Ehhez a héthez már vannak nyerőszámok.';</script>";
            
        } else {
            // Ha nincs, akkor folytathatjuk a mentést
            $stmt = $conn->prepare("INSERT INTO drawnumbers (numbers, week) VALUES (?, ?)");
            $stmt->bind_param("ss", $numbers, $week);
        
            if ($stmt->execute()) {
                echo "<script>document.getElementById('numbersContainer').innerText = 'Sikeres hetinyerőszámok kisorsolása';</script>";
            } else {
                echo "<script>document.getElementById('numbersContainer').innerText = 'Sikertelen hetinyerőszámok sorsolása';</script>";
            }
        $stmt->close();
    }
    $conn->close();
}
?>
</body>
</html>