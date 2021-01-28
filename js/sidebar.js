var dropdown = document.getElementsByClassName("dropdown-btn");
var dropdown2 = document.getElementsByClassName("dropdown-btn2");
console.log(window.location.pathname);
for (let i = 0; i < dropdown.length; i++) {
    dropdown[i].addEventListener("click", function () {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
            document.getElementById("arrow-up").style.display = "none"
            document.getElementById("arrow-down").style.display = "block"
        } else {
            dropdownContent.style.display = "block";
            document.getElementById("arrow-up").style.display = "block"
            document.getElementById("arrow-down").style.display = "none"
        }
    });
}

for (let j = 0; j < dropdown2.length; j++) {
    dropdown2[j].addEventListener("click", function () {
        this.classList.toggle("active");
        var dropdownContent2 = this.nextElementSibling;
        if (dropdownContent2.style.display === "block") {
            dropdownContent2.style.display = "none";
            document.getElementById("arrow-up2").style.display = "none"
            document.getElementById("arrow-down2").style.display = "block"
        } else {
            dropdownContent2.style.display = "block";
            document.getElementById("arrow-up2").style.display = "block"
            document.getElementById("arrow-down2").style.display = "none"
        }
    });
}

function menubar() {
    // localStorage.removeItem("i");
    let main = document.querySelector("#main")
    let employee = document.querySelector("#employee")
    let roomdetail = document.querySelector("#roomdetail")
    let gallery = document.querySelector("#gallery")
    let roomlist = document.querySelector("#roomlist")
    let daily = document.querySelector("#daily")
    let dailycost = document.querySelector("#dailycost")
    let cost = document.querySelector("#cost")
    let repair_report = document.querySelector("#repair_report")
    let repair = document.querySelector("#repair")
    let package = document.querySelector("#package")
    let rule = document.querySelector("#rule")
    let appeal = document.querySelector("#appeal")

    let header = document.querySelector("#topbar-page")

    localStorage.setItem("i", window.location.pathname)
    localStorage.getItem("i")
    console.log(localStorage.getItem("i"))
    
}

$(document).ready(function () {
    let main = $("#main")
    let employee = $("#employee")
    let roomdetail = $("#roomdetail")
    let gallery = $("#gallery")
    let roomlist = $("#roomlist")
    let daily = $("#daily")
    let dailycost = $("#dailycost")
    let cost = $("#cost")
    let repair_report = $("#repair_report")
    let repair = $("#repair")
    let package = $("#package")
    let rule = $("#rule")
    let appeal = $("#appeal")
    let header = $("#topbar-page")
    localStorage.setItem("i", window.location.pathname)
    if (localStorage.getItem("i") == "/Pingfah/pages/admin/index.php") {
        main.css("background-color", "rgba(131, 120, 47, 0.7)")
        main.css("color", "#fff")
        header.html("หน้าหลัก")
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/employee/index.php") {
        employee.css("background-color", "rgba(131, 120, 47, 0.7)")
        employee.css("color", "#fff")
        header.html("จัดการพนักงาน")
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/employee/addemployee.php") {
        employee.css("background-color", "rgba(131, 120, 47, 0.7)")
        employee.css("color", "#fff")
        header.html("เพิ่มพนักงาน")
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/employee/emHistory.php") {
        employee.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        employee.style.color = "#fff"
        header.innerHTML = "ประวัติการเข้าทำงานของพนักงาน"
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/employee/emDetail.php") {
        employee.css("background-color", "rgba(131, 120, 47, 0.7)")
        employee.css("color", "#fff")
        header.html("รายละเอียดข้อมูลพนักงาน")
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/roomDetail/index.php" || localStorage.getItem("i") == "/Pingfah/pages/admin/roomDetail/detail.php") {
        roomdetail.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        roomdetail.style.color = "#fff"
        header.innerHTML = "ประเภทห้องพัก"
        document.querySelector("#dropdown").style.display = "block"
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/gallery/index.php") {
        gallery.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        gallery.style.color = "#fff"
        header.innerHTML = "แกลลอรี่"
        document.querySelector("#dropdown").style.display = "block"
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/roomList/index.php") {
        roomlist.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        roomlist.style.color = "#fff"
        header.innerHTML = "รายการห้องพัก"
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/roomList/roomHistory.php") {
        roomlist.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        roomlist.style.color = "#fff"
        header.innerHTML = "ประวัติการเข้าพัก"
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/roomList/room_id.php") {
        roomlist.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        roomlist.style.color = "#fff"
        header.innerHTML = "รายละเอียดข้อมูลผู้เข้าพัก"
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/daily/index.php" || localStorage.getItem("i") == "/Pingfah/pages/admin/daily/dailyDetail.php") {
        daily.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        daily.style.color = "#fff"
        header.innerHTML = "รายการเช่ารายวัน"
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/dailyCost/index.php" || localStorage.getItem("i") == "/Pingfah/pages/admin/dailyCost/dailyCostDetail.php") {
        dailycost.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        dailycost.style.color = "#fff"
        header.innerHTML = "รายการชำระเงินรายวัน"
        document.querySelector("#dropdown2").style.display = "block"
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/cost/index.php" || localStorage.getItem("i") == "/Pingfah/pages/admin/cost/addcost.php") {
        cost.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        cost.style.color = "#fff"
        header.innerHTML = "รายการชำระเงินรายเดือน"
        document.querySelector("#dropdown2").style.display = "block"
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/repair/repairReport.php") {
        repair_report.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        repair_report.style.color = "#fff"
        header.innerHTML = "รายการค่าใช้จ่ายจากการแจ้งซ่อม"
        document.querySelector("#dropdown2").style.display = "block"
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/repair/index.php" || localStorage.getItem("i") == "/Pingfah/pages/admin/repair/addRepair.php" || localStorage.getItem("i") == "/Pingfah/pages/admin/repair/repairDetail.php") {
        repair.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        repair.style.color = "#fff"
        header.innerHTML = "รายการแจ้งซ่อม"
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/package/index.php" || localStorage.getItem("i") == "/Pingfah/pages/admin/package/addPackage.php") {
        package.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        package.style.color = "#fff"
        header.innerHTML = "รายการพัสดุ"
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/rule/index.php") {
        rule.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        rule.style.color = "#fff"
        header.innerHTML = "กฎระเบียบหอพัก"
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/appeal/index.php" || localStorage.getItem("i") == "/Pingfah/pages/admin/appeal/appealDetail.php") {
        appeal.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        appeal.style.color = "#fff"
        header.innerHTML = "รายการร้องเรียน"
    }
    $(".burger").click(function () {
        if(window.matchMedia('(max-width: 767px)').matches){
            if ($(".sidebar").css("left") == "-230px") {
                $(".topbar").animate({
                    left: "80%",
                }, 400)
                $(".sidebar").animate({
                    left: 0,
                    width: "80%"
                }, 400)
                // $(".sidebar img").css("width","244px")
                // $(".sidebar img").css("height","80px")
                $("#topbar-page").fadeOut(400)
                $(".profile").fadeOut(400)
                $(".bg-close").fadeIn(400)
            } else {
                $(".topbar").animate({
                    left: 0,
                }, 400)
                $(".sidebar").animate({
                    left: -230,
                    width: 230
                }, 400)
                $(".box").animate({
                    paddingLeft: 0
                }, 400)
                // $(".sidebar img").css("width","")
                // $(".sidebar img").css("height","")
                $("#topbar-page").fadeIn(400)
                $(".profile").fadeIn(400)
                $(".bg-close").fadeOut(400)
            }
        }else{
            if ($(".sidebar").css("left") == "-230px") {
                $(".topbar").animate({
                    paddingLeft: 230,
                }, 400)
                $(".sidebar").animate({
                    left: 0
                }, 400)
                // $(".sidebar img").css("width","244px")
                // $(".sidebar img").css("height","80px")
                $(".bg-close").fadeIn(400)
            } else {
                $(".topbar").animate({
                    paddingLeft: 0,
                }, 400)
                $(".sidebar").animate({
                    left: -230
                }, 400)
                $(".box").animate({
                    paddingLeft: 0
                }, 400)
                // $(".sidebar img").css("width","")
                // $(".sidebar img").css("height","")
                $(".bg-close").fadeOut(400)
            }
        }
    })
    $(".bg-close").click(function () {
        if(window.matchMedia('(max-width: 767px)').matches){
            $(".topbar").animate({
                paddingLeft: 0,
            }, 400)
            $(".sidebar").animate({
                left: -230,
                width: 0
            }, 400)
            $(".box").animate({
                paddingLeft: 0
            }, 400)
            // $(".sidebar img").css("width","")
            // $(".sidebar img").css("height","")
            $("#topbar-page").fadeIn(400)
            $(".profile").fadeIn(400)
            $(".bg-close").fadeOut(400)
        }else{
            $(".topbar").animate({
                paddingLeft: 0,
            }, 400)
            $(".sidebar").animate({
                left: -230
            }, 400)
            $(".box").animate({
                paddingLeft: 0
            }, 400)
            // $(".sidebar img").css("width","")
            // $(".sidebar img").css("height","")
            $(".bg-close").fadeOut(400)
        }
        
    })
})