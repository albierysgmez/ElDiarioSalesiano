document.addEventListener("DOMContentLoaded", () => {


const userRol = window.userRol || "";
const ctrl = document.getElementById("panel_ctrl");

if (userRol === "admin") {
    ctrl.style.display = "block";
} else {
    ctrl.style.display = "none";
}



    console.log(userRol);

    /* --- MENU RESPONSIVE --- */
    function toggleMenu() {
        document.getElementById('navLinks').classList.toggle('show');
    }
    window.toggleMenu = toggleMenu;

    document.addEventListener('click', function(e) {
        const links = document.getElementById('navLinks');
        const hamburger = document.querySelector('.hamburger');
        if (!links.contains(e.target) && !hamburger.contains(e.target)) {
            links.classList.remove('show');
        }
    });

    /* --- SLIDER FIJO --- */
    let index = 0;
    const slider = document.querySelector(".slider");
    const slides = document.querySelectorAll(".slide");
    const total = slides.length;

    if (total > 0) {

        function showSlide(i) {
            index = (i + total) % total;
            slider.style.transform = "translateX(" + (-index * 100) + "%)";
        }



        setInterval(() => showSlide(index + 1), 4000);
    }
});

