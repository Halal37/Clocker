let openMenuBtn = document.getElementById("openMenuBtn");
let closeMenuBtn = document.getElementById("close-menu-btn");
let mobileMenu = document.getElementById("mobile-menu");

openMenuBtn.addEventListener("click", () => {
    mobileMenu.style.display = "flex";
});

closeMenuBtn.addEventListener("click", () => {
    mobileMenu.style.display = "none";
});