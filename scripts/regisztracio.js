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

function handleResult(success) {
var resultDiv = document.getElementById('result');
var countdownNumberEl = document.getElementById('countdown');
if (success) {
    resultDiv.innerHTML = '<p style="color:green;">Sikeres regisztráció!</p>';
    var countdown = 3;

    countdownNumberEl.textContent = 'Átirányítás a Bejelentkezés oldalra ' + countdown + ' másodperc múlva.';

    var intervalId = setInterval(function() {
        countdown--;

        countdownNumberEl.textContent = 'Átirányítás a Bejelentkezés oldalra ' + countdown + ' másodperc múlva.';

        if (countdown <= 0) {
            clearInterval(intervalId);
            window.location.href = "bejelentkezes.php";
        }
    }, 1000);
} else {
    resultDiv.innerHTML = '<p style="color:red;">Sikertelen regisztráció, a felhasználónév vagy az e-mail cím már foglalt!" .</p>';
}
window.scrollTo(0,document.body.scrollHeight);
}



document.getElementById('registerForm').addEventListener('submit', function(event) {
    var password = document.getElementsByName('password')[0].value;
    if (password.length < 8) {
        event.preventDefault();
        alert('A jelszónak legalább 8 karakter hosszúnak kell lennie!');
    }
});

function ellenorizKor() {
    var szuletesiDatumInput = document.getElementById("birthdate");
    var szuletesiDatum = new Date(szuletesiDatumInput.value);
    var maiDatum = new Date();
    var felhasznaloKora = maiDatum.getFullYear() - szuletesiDatum.getFullYear();
    
    if (felhasznaloKora < 18) {
        alert("Csak 18 év felett regisztrálhat!");
        return false;
    }
    return true;
    }
    function ellenorizJelszoEgyezes() {
    var jelszoInput = document.getElementById("password");
    var megerositoJelszoInput = document.getElementById("confirm_password");
    var jelszo = jelszoInput.value;
    var megerositoJelszo = megerositoJelszoInput.value;
    
    if (jelszo !== megerositoJelszo) {
        alert("A jelszavak nem egyeznek!");
        return false; 
    }
    return true;
}