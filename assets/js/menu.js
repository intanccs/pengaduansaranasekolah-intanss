document.addEventListener("DOMContentLoaded", function () {

    const menuButton = document.getElementById("menuButton");
    const sideMenu = document.getElementById("sideMenu");
    const overlay = document.getElementById("overlay");
    const closeMenu = document.getElementById("closeMenu");


    // BUKA MENU
    menuButton.addEventListener("click", function () {

        sideMenu.classList.add("active");
        overlay.classList.add("active");

    });


    // TUTUP DENGAN X
    closeMenu.addEventListener("click", function () {

        sideMenu.classList.remove("active");
        overlay.classList.remove("active");

    });


    // TUTUP DENGAN MENEKAN AREA LUAR
    overlay.addEventListener("click", function () {

        sideMenu.classList.remove("active");
        overlay.classList.remove("active");

    });

});