var slideIndex1 = 1;
var slideIndex2 = 1;
showSlides1(slideIndex1);
showSlides2(slideIndex2);

function plusSlides1(n) {
    showSlides1(slideIndex1 += n);
    document.querySelector("#row1").scrollLeft = document.querySelector("#row1").querySelector(".active").offsetLeft
}

function currentSlide1(n) {
    showSlides1(slideIndex1 = n);
}

function plusSlides2(n) {
    showSlides2(slideIndex2 += n);
    document.querySelector("#row2").scrollLeft = document.querySelector("#row2").querySelector(".active").offsetLeft
}

function currentSlide2(n) {
    showSlides2(slideIndex2 = n);
}

document.getElementById('row1').addEventListener('mousewheel', function (e) {
    this.scrollLeft -= (e.wheelDelta)*4;
    e.preventDefault();
}, false);

document.getElementById('row2').addEventListener('mousewheel', function (e) {
    this.scrollLeft -= (e.wheelDelta)*4;
    e.preventDefault();
}, false);

function showSlides1(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides1");
    let dots = document.getElementsByClassName("demo1");
    //   var captionText = document.getElementById("caption");
    if (n > slides.length) {
        slideIndex1 = 1
    }
    if (n < 1) {
        slideIndex1 = slides.length
    }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex1 - 1].style.display = "block";
    dots[slideIndex1 - 1].className += " active";
    //   captionText.innerHTML = dots[slideIndex-1].alt;
}

function showSlides2(m) {
    let j;
    let slides = document.getElementsByClassName("mySlides2");
    let dots = document.getElementsByClassName("demo2");
    //   var captionText = document.getElementById("caption");
    if (m > slides.length) {
        slideIndex2 = 1
    }
    if (m < 1) {
        slideIndex2 = slides.length
    }
    for (j = 0; j < slides.length; j++) {
        slides[j].style.display = "none";
    }
    for (j = 0; j < dots.length; j++) {
        dots[j].className = dots[j].className.replace(" active", "");
    }
    slides[slideIndex2 - 1].style.display = "block";
    dots[slideIndex2 - 1].className += " active";
    //   captionText.innerHTML = dots[slideIndex-1].alt;
}