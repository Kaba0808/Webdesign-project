var sections = ["szabalyzat", "jatekmenet", "nyeremeny"];
var currentSection = 0;

function toggleMenu() {
    var menuContainer = document.getElementById("menu-container");
    var menuIcon = document.querySelector(".menu-icon");
    menuContainer.classList.toggle("open");
    menuIcon.classList.toggle("open");
}

function nextSection() {
    document.getElementById(sections[currentSection]).style.display = "none";
    currentSection = (currentSection + 1) % sections.length;
    document.getElementById(sections[currentSection]).style.display = "block";
}

function previousSection() {
    document.getElementById(sections[currentSection]).style.display = "none";
    currentSection = (currentSection - 1 + sections.length) % sections.length;
    document.getElementById(sections[currentSection]).style.display = "block";
}

document.addEventListener('click', function(event) {
    var menuContainer = document.getElementById("menu-container");
    var menuIcon = document.querySelector(".menu-icon"); 
    if (menuContainer.classList.contains("open") && !menuContainer.contains(event.target) && !menuIcon.contains(event.target)) {
        menuContainer.classList.remove("open");
    }
});