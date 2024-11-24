function imgSlider(anything){
    document.querySelector('.starbucks').src=anything;
}

// Toggle navbar menu
function toggleMenu() {
    const menu = document.querySelector('.navbar ul');
    menu.classList.toggle('active');
}

// Open the sidenav
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

// Close the sidenav
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
}

/* Set the width of the side navigation to 250px */
function toggleNav() {
    var sidenav = document.getElementById("mySidenav");
    // Toggle the width of the sidenav (0 means closed, 250px means open)
    if (sidenav.style.width === "0px" || sidenav.style.width === "") {
        sidenav.style.width = "250px";  // Open the sidenav
    } else {
        sidenav.style.width = "0";  // Close the sidenav
    }
}