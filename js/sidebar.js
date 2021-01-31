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
        employee.css("background-color", "rgba(131, 120, 47, 0.7)")
        employee.css("color", "#fff")
        header.html("ประวัติของพนักงาน")
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
        $("#dropdown").css("display","block")
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/roomList/index.php") {
        roomlist.css("background-color", "rgba(131, 120, 47, 0.7)")
        roomlist.css("color", "#fff")
        header.html("รายการห้องพัก")
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/roomList/roomHistory.php") {
        roomlist.css("background-color", "rgba(131, 120, 47, 0.7)")
        roomlist.css("color", "#fff")
        header.html("ประวัติการเข้าพัก")
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/roomList/room_id.php") {
        roomlist.css("background-color", "rgba(131, 120, 47, 0.7)")
        roomlist.css("color", "#fff")
        header.html("รายละเอียดข้อมูลผู้เข้าพัก")
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/daily/index.php" || localStorage.getItem("i") == "/Pingfah/pages/admin/daily/dailyDetail.php") {
        daily.css("background-color", "rgba(131, 120, 47, 0.7)")
        daily.css("color", "#fff")
        header.html("รายการเช่ารายวัน")
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/dailyCost/index.php" || localStorage.getItem("i") == "/Pingfah/pages/admin/dailyCost/dailyCostDetail.php") {
        dailycost.css("background-color", "rgba(131, 120, 47, 0.7)")
        dailycost.css("color", "#fff")
        header.html("รายการชำระเงินรายวัน")
        $("#dropdown2").css("display","block")
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/cost/index.php") {
        cost.css("background-color", "rgba(131, 120, 47, 0.7)")
        cost.css("color", "#fff")
        header.html("รายการชำระเงินรายเดือน")
        $("#dropdown2").css("display","block")
    } else if(localStorage.getItem("i") == "/Pingfah/pages/admin/cost/costDetail.php"){
        cost.css("background-color", "rgba(131, 120, 47, 0.7)")
        cost.css("color", "#fff")
        header.html("รายละเอียดการชำระเงิน")
        $("#dropdown2").css("display","block")
    } else if(localStorage.getItem("i") == "/Pingfah/pages/admin/cost/addcost.php"){
        cost.css("background-color", "rgba(131, 120, 47, 0.7)")
        cost.css("color", "#fff")
        header.html("เพิ่มข้อมูลการชำระเงิน")
        $("#dropdown2").css("display","block")
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/repair/repairReport.php") {
        repair_report.css("background-color", "rgba(131, 120, 47, 0.7)")
        repair_report.css("color", "#fff")
        header.html("รายการค่าใช้จ่ายจากการแจ้งซ่อม")
        $("#dropdown2").css("display","block")
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/repair/index.php") {
        repair.css("background-color", "rgba(131, 120, 47, 0.7)")
        repair.css("color", "#fff")
        header.html("รายการแจ้งซ่อม")
    } else if(localStorage.getItem("i") == "/Pingfah/pages/admin/repair/addRepair.php"){
        repair.css("background-color", "rgba(131, 120, 47, 0.7)")
        repair.css("color", "#fff")
        header.html("เพิ่มรายการแจ้งซ่อม")
    } else if(localStorage.getItem("i") == "/Pingfah/pages/admin/repair/repairDetail.php"){
        repair.css("background-color", "rgba(131, 120, 47, 0.7)")
        repair.css("color", "#fff")
        header.html("ข้อมูลการแจ้งซ่อม")
    }else if (localStorage.getItem("i") == "/Pingfah/pages/admin/package/index.php" || localStorage.getItem("i") == "/Pingfah/pages/admin/package/addPackage.php") {
        package.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        package.style.color = "#fff"
        header.innerHTML = "รายการพัสดุ"
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/rule/index.php") {
        rule.css("background-color", "rgba(131, 120, 47, 0.7)")
        rule.css("color", "#fff")
        header.html("กฎระเบียบหอพัก")
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
                $("#topbar-page").animate({
                    opacity : 0
                },400)
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
                $("#topbar-page").animate({
                    opacity : 1
                },400)
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
                $(".bg-close").fadeOut(400)
            }
        }
    })
    $(".bg-close").click(function () {
        if(window.matchMedia('(max-width: 767px)').matches){
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
            $("#topbar-page").animate({
                opacity : 1
            },400)
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
            $(".bg-close").fadeOut(400)
        }
        
    })
    $(".dropdown-btn").click(function(){
        $("#dropdown").toggle()
    })
    $(".dropdown-btn2").click(function(){
        $("#dropdown2").toggle()
    })
})