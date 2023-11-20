// Inisialisasi Swiper
var swiper = new Swiper(".slide-container", {
slidesPerView: 6,
spaceBetween: 15,
sliderPerGroup: 6,
loop: true,
centerSlide: "true",
fade: "true",
grabCursor: "true",
pagination: {
    el: ".swiper-pagination",
    clickable: true,
    dynamicBullets: true,
},
navigation: {
    nextEl: ".swipernext",
    prevEl: ".swiperprev",
},
breakpoints: {
    0: {
    slidesPerView: 1,
    },
    520: {
    slidesPerView: 2,
    },
    768: {
    slidesPerView: 3,
    },
    1000: {
    slidesPerView: 6,
    },
},
});

// Mengubah ukuran elemen card1 swiper-slide setelah inisialisasi Swiper
var cardElement = document.querySelector('.card1.swiper-slide');
cardElement.style.width = '100px'; // Ganti dengan ukuran yang diinginkan

