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

$user = array('firstname' => '', 'surname' => '', 'username' => '', 'email' => '', 'birthdate' => '', 'telnumber' => '');

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    header("Location: bejelentkezes.php");
    exit;
}

$isAdmin = false;

if (!empty($user['role']) && $user['role'] === 'admin') {
    $isAdmin = true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['new_username'])) {
        $new_username = $_POST['new_username'];

        // Ellenőrizd, hogy az új felhasználónév egyedi-e
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $new_username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Ha már létezik ilyen felhasználónév, ne hajtsd végre az update-et
            echo "Ez a felhasználónév már foglalt!";
        } else {
            // Ha egyedi, végezd el az update-et
            $stmt = $conn->prepare("UPDATE users SET username=? WHERE username=?");
            $stmt->bind_param("ss", $new_username, $user['username']);
            $stmt->execute();
            $user['username'] = $new_username;
            $_SESSION['user'] = $user;
        }
    }

    if (isset($_POST['new_email'])) {
        $new_email = $_POST['new_email'];

        // Ellenőrizd, hogy az új e-mail cím egyedi-e
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $new_email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Ha már létezik ilyen e-mail cím, ne hajtsd végre az update-et
            echo "Ez az e-mail cím már foglalt!";
        } else {
            // Ha egyedi, végezd el az update-et
            $stmt = $conn->prepare("UPDATE users SET email=? WHERE username=?");
            $stmt->bind_param("ss", $new_email, $user['username']);
            $stmt->execute();
            $user['email'] = $new_email;
            $_SESSION['user'] = $user;
        }
    }

    if (isset($_FILES["profile-pic"]) && $_FILES["profile-pic"]["error"] == UPLOAD_ERR_OK) {
        $uploadFile = $_FILES["profile-pic"];
        
        $fajlnev = $uploadFile["name"];
        $darabok = explode(".", $fajlnev);
        $kiterjesztes = strtolower(end($darabok));
        
        $cel_utvonal = "profkep/" . $fajlnev;

        if (move_uploaded_file($uploadFile["tmp_name"], $cel_utvonal)) {
            $profile_picture_path = $cel_utvonal;
            $_SESSION['user']['profile_picture'] = $profile_picture_path;
            echo "A fájl sikeresen átmozgatásra került!";
        } else {
            echo "Hiba történt a fájl átmozgatása során!";
        }
    }
    header('Location: profil.php');
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil oldal</title>
    <link rel="stylesheet" href="styles/profil.css">
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
                <a href="index.php" class="link">Kezdőlap</a>
                <a href="lottoszelveny.php" class="link">Szelvények</a>
                <a href="sorsolaslekerdezes.php" class="link">Számaid lekérdezése</a>
                <?php
                if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
                    echo '<a href="nyeroszam_sorsolas.php" class="link">Nyerőszám Sorsolás</a>';
                }
                ?>
            </nav>
        </div>

        <div class="container">
            <h1 id="pageTitle">Profilom</h1>
        </div>
    </header>

  <main>
  <div id="profilePictureUpload" class="grid-container">
        <h2><?php if (isset($_SESSION['user']['profile_picture'])) : ?>
            <img src="<?php echo htmlspecialchars($_SESSION['user']['profile_picture']); ?>" alt="Profilkép">
		    <?php endif; ?>
        </h2>
        <form action="profil.php" method="POST" enctype="multipart/form-data">
            <label for="file-upload" class="custom-file-upload">Válasszon fájlt</label>
            <input type="file" id="file-upload" name="profile-pic" accept="image/*" required/><br/>
            <input type="submit" id="upload-btn" name="upload-btn" value="Feltöltés"/>
        </form>
    </div>

    <div id="profilePage" class="grid-container">
    <p class="styled-paragraph" id="name">Név: <?php echo htmlspecialchars($user['firstname'] . ' ' . $user['surname']); ?></p>
    <div id="usernameFormContainer" style="display: none;">
        <form action="profil.php" method="POST" id="usernameForm">
            <input type="text" name="new_username" value="<?php echo htmlspecialchars($user['username']); ?>">
            <input style="width: 30px; height: 30px" type="submit" value="OK">
        </form>
    </div>
    <p class="styled-paragraph" id="usernameProfile" style="display: block;" >
        Felhasználónév:
        <span id="usernameText"><?php echo htmlspecialchars($user['username']); ?></span>
        <button style="width: 30px; height: 30px" id="editUsernameButton" onclick="editUsername()">🖉</button>
    </p>
    <div id="emailFormContainer" style="display: none;">
        <form action="profil.php" method="POST" id="emailForm">
            <input type="text" name="new_email" value="<?php echo htmlspecialchars($user['email']); ?>">
            <input style="width: 30px; height: 30px" type="submit" value="OK">
        </form>
    </div>
    <p class="styled-paragraph" id="email" style="display: block;">
        Email:
        <span id="emailText"><?php echo htmlspecialchars($user['email']); ?></span>
        <button style="width: 30px; height: 30px" id="editEmailButton" onclick="editEmail()">🖉</button>
    </p>
    <p class="styled-paragraph" id="birthdate">Születési dátum: <?php echo htmlspecialchars($user['birthdate']); ?></p>
    <p class="styled-paragraph" id="telnumber">Telefonszám: <?php echo htmlspecialchars($user['telnumber']); ?></p>
    <a href="rendelesek.php" class="styled-paragraph">Korábbi rendeléseim</a>
    <?php
    if ($isAdmin) {
        echo '<p class="styled-paragraph" id="adminStatus">Admin: Igen</p>';
    } else {
        echo '<p class="styled-paragraph" id="adminStatus">Admin: Nem</p>';
    }
    ?>
    <button onclick="logout()" class="styled-paragraph">Kijelentkezés</button>
    <button onclick="showDeleteAccountForm()" class="styled-paragraph">Fiók törlése</button>
</div>

    <div id="deleteAccountForm" style="display: none;">
        <h2>Biztosan szeretné törölni a fiókja adatait?</h2>
        <form action="deleteAccount.php" method="post">
            <label for="password">Jelszó megerősítés:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Fiókadataim törlése">
        </form>
    </div>
</main>

    <footer>
        <p>© 2024 SZTE Játék Zrt. Minden jog fenntartva.</p>
    </footer>
    
    <script src="scripts/profil.js"></script>
</body>
</html>