document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    const currentPath = window.location.pathname.replace(/\/$/, "");
    navLinks.forEach(link => {
        // Create a temporary anchor to parse the href
        const temp = document.createElement('a');
        temp.href = link.href;
        const linkPath = temp.pathname.replace(/\/$/, "");
        if (linkPath === currentPath) {
            link.classList.add('active-nav');
        }
    });
});

// Interactive Barangays Reveal
function toggleBarangays() {
    const list = document.getElementById('about-barangays-list');
    const arrow = document.getElementById('barangays-arrow');
    list.classList.toggle('show');
    arrow.innerHTML = list.classList.contains('show') ? '&#9650;' : '&#9660;';
}

// Back to Top Button
const backToTopBtn = document.querySelector('.about-backtotop');
window.addEventListener('scroll', function () {
    if (window.scrollY > 300) {
        backToTopBtn.style.display = 'flex';
    } else {
        backToTopBtn.style.display = 'none';
    }
});



