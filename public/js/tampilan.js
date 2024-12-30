function toggleSearchBox() {
    const searchBox = document.querySelector('.searching');
    const searchIcon = document.querySelector('.search-icon');

    if (!searchBox.classList.contains('active')) {
        searchBox.classList.add('active');
        searchBox.focus(); 
        searchIcon.style.display = 'none'; 
    } else {
        resetSearchBox();
    }
}

function resetSearchBox() {
    const searchBox = document.querySelector('.searching');
    const searchIcon = document.querySelector('.search-icon');
    searchBox.classList.remove('active');
    searchBox.value = ''; 
    searchIcon.style.display = 'block'; 
}

function handleKeyPress(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        const searchBox = event.target.value;
        window.location.href = `/beranda?search=${encodeURIComponent(searchBox)}`;
    }
}

document.addEventListener('click', function(event) {
    const searchBox = document.querySelector('.searching');
    const searchIcon = document.querySelector('.search-icon');

    if (!searchBox.contains(event.target) && !searchIcon.contains(event.target)) {
        resetSearchBox();
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const hamburgerMenu = document.querySelector('.hamburger-menu'); 
    const mobileMenu = document.querySelector('.mobile-menu');

    hamburgerMenu.addEventListener('click', () => {
        mobileMenu.classList.toggle('active');
        hamburgerMenu.classList.toggle('active'); 
    });

    document.addEventListener('click', (event) => {
        if (!hamburgerMenu.contains(event.target) && !mobileMenu.contains(event.target)) {
            mobileMenu.classList.remove('active');
            hamburgerMenu.classList.remove('active');
        }
    });
});
