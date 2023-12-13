function toggleMobileMenu() {
    var mobileMenu = document.querySelector('.mobile');
    if (mobileMenu.style.display === 'none' || mobileMenu.style.display === '') {
        mobileMenu.style.display = 'inline';
    } else {
        mobileMenu.style.display = 'none';
    }
}
