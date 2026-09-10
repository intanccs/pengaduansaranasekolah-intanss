document.addEventListener("DOMContentLoaded", function () {

    var button = document.getElementById("menuButton");
    var menu = document.getElementById("sideMenu");
    var overlay = document.getElementById("overlay");
    var close = document.getElementById("closeMenu");

    if (button) {
        button.onclick = function () {
            menu.classList.add("active");
            overlay.classList.add("active");
        };
    }

    if (close) {
        close.onclick = function () {
            menu.classList.remove("active");
            overlay.classList.remove("active");
        };
    }

    if (overlay) {
        overlay.onclick = function () {
            menu.classList.remove("active");
            overlay.classList.remove("active");
        };
    }

});