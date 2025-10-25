document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('drawButton').style.display = 'block';
    document.getElementById('saveButton').style.display = 'none';

    function drawNumbers() {
        var numbers = [];
        while (numbers.length < 6) {
            var r = Math.floor(Math.random() * 90) + 1;
            if (numbers.indexOf(r) === -1) numbers.push(r);
        }
        document.getElementById('numbersInput').value = numbers.join(', ');
        document.getElementById('weekInput').value = new Date().getWeekNumber(); // Implement getWeekNumber function
        document.getElementById('numbersContainer').innerText = numbers.join(', '); // A generált számok megjelenítése
        document.getElementById('drawButton').style.display = 'none';
        document.getElementById('saveButton').style.display = 'block';
    }

    // A drawNumbers függvényt itt kell hozzárendelni a gombhoz
    document.getElementById('drawButton').onclick = drawNumbers;

    Date.prototype.getWeekNumber = function() {
        var d = new Date(Date.UTC(this.getFullYear(), this.getMonth(), this.getDate()));
        var dayNum = d.getUTCDay() || 7;
        d.setUTCDate(d.getUTCDate() + 4 - dayNum);
        var yearStart = new Date(Date.UTC(d.getUTCFullYear(),0,1));
        return Math.ceil((((d - yearStart) / 86400000) + 1)/7);
    };
});

function toggleMenu() {
    var menuContainer = document.getElementById("menu-container");
    var menuIcon = document.querySelector(".menu-icon");
    menuContainer.classList.toggle("open");
    menuIcon.classList.toggle("open");
}