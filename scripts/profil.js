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

function handleResult(user) {
    document.getElementById('name').textContent = "Név: " + user.firstname + " " + user.surname;
    document.getElementById('usernameProfile').textContent = "Felhasználónév: " + user.username;
    document.getElementById('email').textContent = "Email: " + user.email;
    document.getElementById('birthdate').textContent = "Születési dátum: " + user.birthdate;
}

function showDeleteAccountForm() {
    var form = document.getElementById('deleteAccountForm');
    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}

function editUsername() {
    document.getElementById('usernameFormContainer').style.display = 'block';
    document.getElementById('usernameProfile').style.display = 'none';
}

function editEmail() {
    document.getElementById('emailFormContainer').style.display = 'block';
    document.getElementById('email').style.display = 'none';
}

function saveUsername() {
    document.getElementById('usernameForm').submit();
}

function saveEmail() {
    document.getElementById('emailForm').submit();
}

function logout() {
    var xhr = new XMLHttpRequest();
                xhr.open("POST", "logout.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            window.location.href = "bejelentkezes.php";
        }
    };
    xhr.send();
}