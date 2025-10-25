<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Bemutató</title>
    <link rel="stylesheet" href="styles/bemutato.css">
</head>
<body>
    <div id="menu-container">
        <div class="menu-icon" onclick="toggleMenu()">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <nav id="menu" class="menu-container">
            <a href="hetinyertesek.php" class="link">Heti Nyertesek</a>
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
        <div class="content">
            <button onclick="previousSection()" style="font-size: 24px; font-weight: bold;">←</button><br>
            <div id="szabalyzat" class="content-section">
                <h2>Szabályzat</h2>
                <div class="leftmargin">
                    <ul>
                        <li class="bold-italic">Szabályzatunk:</li>
                    </ul>
                    <ol>
                        <li>Minden résztvevőnek legalább 18 évesnek kell lennie a lottójátékban való részvételhez.</li>
                        <li>A lottózási platform aktívan monitorozza a gyanús tevékenységeket és csalási kísérleteket. Az ilyen tevékenységek észlelésekor az érintett fiókokat azonnal felfüggesztjük, és szükség esetén jogi lépéseket teszünk.</li>
                        <li>A lottójátékok eredményei teljesen véletlenszerűek, közjegyző jelenlétével biztosított.</li>
                    </ol>
                </div>
            </div>
            <div id="jatekmenet" class="content-section" style="display: none;">
                <h2>Játékmenet</h2>
                <div class="leftmargin">
                    <ul>
                        <li class="bold-italic">A lottózás menete a következő.</li>
                    </ul>
                    <ol>
                        <li>Elősször is, a játékosnak be kell jelentkeznie profiljában, vagy ha még nincsen profilja regisztrálnia kell.</li>
                        <li>Ezek után, a játékos már tud kitölteni lottószelvényt.</li>
                        <li>Ha ezzel is megvan, a játékosnak meg kell vásárolnia a lottószelvényt.</li>
                        <li>A feladás után minden héten a számokat véletlenszerűen sorsoljuk ki. Ha a játékosnak a szelvényén szereplő számok megegyeznek a kisorsolt számokkal, a játékos nyer.</li>
                        <li>A sorsolást követően a játékos ezt megtudja nézni a heti nyertesek oldalán.</li>
                    </ol>
                </div>
            </div>
            <div id="nyeremeny" class="content-section" style="display: none;">
                <h2>Találatok</h2>
                <div class="leftmargin">
                    <ul>
                        <li>A heti kisorsolt számokat megtudod nézni és összevetni a sajátjaiddal.</li>
                        <li>Láthatod, hogy hány találatosod van (1,2,3,4,5,6).</li>
                        <li>Ha be vagy jelentkezve ezt megtekintheted <a href="sorsolaslekerdezes.php">itt.</a></li>
                    </ul>
                </div>
            </div><br>
            <button onclick="nextSection()" style="font-size: 24px; font-weight: bold;">→</button>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 SZTE Játék Zrt. Minden jog fenntartva.</p>
    </footer>
    <script src="scripts/bemutato.js"></script>
</body>
</html>