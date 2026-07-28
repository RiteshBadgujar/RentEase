window.addEventListener("scroll", () => {

    let nav = document.getElementById("mainNavbar");

    if(window.scrollY > 50){

        nav.classList.add("shadow");

    }else{

        nav.classList.remove("shadow");
    }

});