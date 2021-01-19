$(document).ready(function () {
    AOS.init();


})

function showImg(num) {
    let modal = document.querySelector(`#modal${num}`)
    modal.style.display = "flex"
    // console.log("yyy")
}

function close_modal(num) {
    let modal = document.querySelector(`#modal${num}`)
    modal.style.display = "none"
}

$(window).scroll(function () {
    if (window.pageYOffset > 180) {
        $(".clickTotop").show()
    } else {
        $(".clickTotop").hide()
    }
})
$(".clickTotop").click(function () {
    $("html, body").animate({
        scrollTop: 0,
    }, 1000)
})