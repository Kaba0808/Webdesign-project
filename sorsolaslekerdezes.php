<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendelesek</title>
    <link rel="stylesheet" href="styles/rendelesek.css">
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
                        <th colspan="4">Összes szelvényed</th>
                    </tr>
                    <tr>
                        <th>Számaid</th>
                        <th>Ennyi találatot értél el</th>
                        <th>A heti kisorsolt számok</th>
                        <th>Mostani hét</th>
                    </tr>
                </thead>
                <tbody style="background-color: white;">
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

                    $currentWeek = date('W');
                    $drawQuery = "SELECT numbers FROM drawnumbers WHERE week = ?";
                    $stmt = $conn->prepare($drawQuery);
                    $stmt->bind_param("i", $currentWeek);
                    $stmt->execute();
                    $drawResult = $stmt->get_result();
                    $drawRow = $drawResult->fetch_assoc();
                    $drawNumbers = array_map('trim', explode(',', $drawRow['numbers']));

                    $user = $_SESSION['user']['username']; // A felhasználónév a session-ből
                    $ticketQuery = "SELECT selected_numbers, week FROM szamok WHERE username = ? AND is_validated = 1 AND week = ?";
                    $stmt = $conn->prepare($ticketQuery);
                    $stmt->bind_param("si", $user, $currentWeek);
                    $stmt->execute();
                    $ticketResult = $stmt->get_result();

                    while ($ticketRow = $ticketResult->fetch_assoc()) {
                        $ticketNumbers = array_map('trim', explode(' ', $ticketRow['selected_numbers']));
                        $ticketWeek = $ticketRow['week'];
                        $matchCount = 0;

                        if ($ticketWeek == $currentWeek) {
                            foreach ($ticketNumbers as $ticketNumber) {
                                if (in_array($ticketNumber, $drawNumbers)) {
                                    $matchCount++;
                                }
                            }

                            echo "<tr><td>" . implode(', ', $ticketNumbers) . "</td><td>" . $matchCount . "</td><td>" . implode(', ', $drawNumbers) . "</td><td>" . $currentWeek . ".</td></tr>";
                        }
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <p>© 2024 SZTE Játék Zrt. Minden jog fenntartva.</p>
    </footer>

    <script src="scripts/bemutato.js"></script>
</body>
</html>