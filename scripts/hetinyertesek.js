document.querySelector('.menu-icon').addEventListener('click', function() {
    var menu = document.querySelector('#menu');
    var menuContainer = document.querySelector('#menu-container');
    if (menu.style.display === 'none' || menu.style.display === '') {
        menu.style.display = 'block';
        menuContainer.classList.add('open');
    } else {
        menu.style.display = 'none';
        menuContainer.classList.remove('open');
    }
});

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function updateWinner(week) {
    // Ellenőrizzük, hogy már sorsoltunk-e ezen a héten
    if (localStorage.getItem('week' + week)) {
        alert('Ezen a héten már volt sorsolás!');
        return;
    }

    var names = ["Péter", "János", "Mária", "Judit", "Gábor", "Zsófia", "Bence", "Viktória", "Krisztián", "Ildikó", "Attila", "Szilvia", "Ferenc", "Anita", "László", "Erika", "Tamás", "Gabriella", "Zoltán", "Katalin", "István", "Rita", "György", "Ágnes", "Balázs"];
    var amounts = getRandomInt(1, 180) * 1000000;

    var winner = names[getRandomInt(0, names.length - 1)];
    var amount = amounts.toLocaleString('hu-HU') + " Ft";

    var numbers = [];
    for (var i = 0; i < 6; i++) {
        numbers.push(getRandomInt(1, 90));
    }

    // Az aktuális heti nyertes adatainak frissítése
    document.getElementById('winner').innerText = winner;
    document.getElementById('amount').innerText = amount;
    var currentNumbers = document.getElementById('numbers').getElementsByTagName('span');
    for (var i = 0; i < currentNumbers.length; i++) {
        currentNumbers[i].innerText = numbers[i];
    }

    // Az admin által sorsolt számok lekérése localStorage-ből
    if (localStorage.getItem('adminNumbers')) {
        var adminNumbers = JSON.parse(localStorage.getItem('adminNumbers'));
        numbers = adminNumbers.numbers;
        winner = adminNumbers.winner;
        amount = adminNumbers.amount;
    }

    // A heti nyertesek frissítése az aktuális héten
    var winnerElement = document.getElementById('week' + week + 'Winner');
    var amountElement = document.getElementById('week' + week + 'Amount');
    var numbersElement = document.getElementById('week' + week + 'Numbers');
    
    winnerElement.innerText = winner;
    amountElement.innerText = amount;
    var numbersSpans = numbersElement.getElementsByTagName('span');
    for (var i = 0; i < numbersSpans.length; i++) {
        numbersSpans[i].innerText = numbers[i];
    }

    // Adatok mentése localStorage-be az aktuális hétről
    var weekData = {
        winner: winner,
        amount: amount,
        numbers: numbers
    };
    localStorage.setItem('week' + week, JSON.stringify(weekData));
}

// Az admin által sorsolt számok beállítása localStorage-be
function setAdminNumbers(numbers) {
    var adminData = {
        winner: 'Admin',
        amount: 'Admin által sorsolt',
        numbers: numbers
    };
    localStorage.setItem('adminNumbers', JSON.stringify(adminData));
}