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

function handleResult(success, user) {
    var resultDiv = document.getElementById('result');
    var countdownNumberEl = document.getElementById('countdown');
    var loginPage = document.getElementById('loginPage');
    var profilePage = document.getElementById('profilePage');
    var pageTitle = document.getElementById('pageTitle');
    if (success) {
        resultDiv.innerHTML = '<p style="color:green;">Sikeres bejelentkezés!</p>';
        var countdown = 3;

        countdownNumberEl.textContent = 'Átirányítás a Profil oldalra ' + countdown + ' másodperc múlva.';

        var intervalId = setInterval(function() {
            countdown--;

            countdownNumberEl.textContent = 'Átirányítás a Profil oldalra ' + countdown + ' másodperc múlva.';

            if (countdown <= 0) {
                clearInterval(intervalId);
                window.location.href = "profil.php";
            }
        }, 1000);
    } else {
        resultDiv.innerHTML = '<p style="color:red;">Sikertelen bejelentkezés!</p>';
    }
}