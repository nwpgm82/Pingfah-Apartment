$(document).ready(function () {
    $(".burger").click(function () {
        if (window.matchMedia('(max-width: 767px)').matches) {
            if ($("ul").css("display") == "none") {
                $("ul").fadeIn(400)
                $(".topbar ul a").delay(400).animate({
                    opacity: 1
                }, 400)
            } else {
                $("ul").fadeOut(400)
                $(".topbar ul a").animate({
                    opacity: 0
                }, 400)
            }
        } else {
            if ($("ul").css("display") == "none") {
                $("ul").css("display", "flex").fadeIn(400)
                $("ul").animate({
                    height: "120px"
                }, 400)
                $(".topbar ul a").delay(400).animate({
                    opacity: 1
                }, 400)
            } else {
                $(".topbar ul a").css("opacity", 0)
                $("ul").animate({
                    height: 0
                }, 400)
                $("ul").fadeOut(400)
            }
        }
    })
})