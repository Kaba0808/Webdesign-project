document.addEventListener('DOMContentLoaded', function() {
    const kosarSection = document.getElementById('kosarSection');
    const szelvenyForm = document.getElementById('szelvenyForm');
    const szelvenyCountInput = document.getElementById('szelvenyCount');
    const fizetesButton = document.getElementById('fizetes');
    const vegosszegParagraph = document.getElementById('vegosszeg');
    const kosarTartalom = document.getElementById('kosarTartalom');

    szelvenyForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Az űrlap alapértelmezett működésének megakadályozása

        const szelvenyCount = parseInt(szelvenyCountInput.value);
        if (szelvenyCount > 0) {
            kosarTartalom.innerHTML = ''; // Előző tartalom törlése
            let fizetendoOsszeg = 0;
            for (let i = 1; i <= szelvenyCount; i++) {
                const li = document.createElement('li');
                li.textContent = `Szelvény  `;
                const kukaIcon = document.createElement('span');
                kukaIcon.innerHTML = '🗑';
                kukaIcon.style.cursor = 'pointer';
                kukaIcon.addEventListener('click', function() {
                    kosarTartalom.removeChild(li);
                    szelvenyCountInput.value = parseInt(szelvenyCountInput.value) - 1; // Szelvény számának csökkentése
                    fizetendoOsszeg -= 1200;
                    vegosszegParagraph.textContent = `Végösszeg: ${fizetendoOsszeg} Ft`;
                });
                li.appendChild(kukaIcon);
                kosarTartalom.appendChild(li);
                fizetendoOsszeg += 1200;
            }
            
            vegosszegParagraph.textContent = `Végösszeg: ${fizetendoOsszeg} Ft`;
        } else {
            alert('Kérem adjon meg egy 0-nál nagyobb számot!');
        }
    });

    fizetesButton.addEventListener('click', function() {
        kosarTartalom.innerHTML = '';
        szelvenyCountInput.value = '0';
        vegosszegParagraph.textContent = 'Végösszeg: 0 Ft'; 
        alert('Fizetés végrehajtva!');
        window.location.href = 'kosar_bejelentkezéssel.php';
    });
});