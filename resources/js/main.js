const hydrate = function () {
    let mobileButton = document.querySelector(".menu-bar");
    let mobileCloseButton = document.querySelector(".menu-bar-close");
    let navMobileOverlay = document.querySelector(".nav-overlay");
    let loginButton = document.querySelector(".login-section");

    mobileButton.addEventListener("click", function (e) {
        e.preventDefault();
        document.body.classList.add("active-menu-mobile");
    })
    mobileCloseButton.addEventListener("click", function (e) {
        e.preventDefault();
        document.body.classList.remove("active-menu-mobile");
    })
    navMobileOverlay.addEventListener("click", function (e) {
        e.preventDefault();
        document.body.classList.remove("active-menu-mobile");
    })

    let btnSubs = document.querySelectorAll(".btn-sub");
    btnSubs.forEach((btn) => {
        btn.addEventListener("click", function (e) {
            this.classList.toggle("active");
            let parent = this.parentNode;
            let ul = parent.nextElementSibling;
            ul.classList.toggle("active");
        })
    })

    let loginPopup = document.querySelector(".login-popup");
    loginButton.addEventListener("click", function (e) {
        e.stopPropagation();
        if (loginButton.classList.contains("logged-in")) {
            return
        }
        loginPopup.classList.toggle('active');
    })
    let loginOverlay = document.querySelector(".auth-overlay");
    loginOverlay.addEventListener("click", function (e) {
        e.stopPropagation();
        loginPopup.classList.remove('active');
    })
}
export {hydrate}
