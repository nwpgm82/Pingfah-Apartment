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
    let repair = document.querySelector("#repair")
    let package = document.querySelector("#package")
    let rule = document.querySelector("#rule")
    let appeal = document.querySelector("#appeal")

    let header = document.querySelector("#topbar-page")

    localStorage.setItem("i", window.location.pathname)
    localStorage.getItem("i")
    console.log(localStorage.getItem("i"))
    if (localStorage.getItem("i") == "/Pingfah/pages/admin/index.php") {
        main.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        main.style.color = "#fff"
        header.innerHTML = "หน้าหลัก"
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/employee/index.php" || localStorage.getItem("i") == "/Pingfah/pages/admin/employee/emDetail.php" || localStorage.getItem("i") == "/Pingfah/pages/admin/employee/addemployee.php") {
        employee.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        employee.style.color = "#fff"
        header.innerHTML = "จัดการพนักงาน"
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/roomDetail/index.php" || localStorage.getItem("i") == "/Pingfah/pages/admin/roomDetail/detail.php") {
        roomdetail.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        roomdetail.style.color = "#fff"
        header.innerHTML = "ประเภทห้องพัก"
        document.querySelector("#dropdown").style.display = "block"
    }else if (localStorage.getItem("i") == "/Pingfah/pages/admin/gallery/index.php") {
        gallery.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        gallery.style.color = "#fff"
        header.innerHTML = "แกลลอรี่"
        document.querySelector("#dropdown").style.display = "block"
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/roomList/index.php" || localStorage.getItem("i") == "/Pingfah/pages/admin/roomList/room_id.php") {
        roomlist.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        roomlist.style.color = "#fff"
        header.innerHTML = "รายการห้องพัก"
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
    } else if (localStorage.getItem("i") == "/Pingfah/pages/admin/repair/repair_report.php") {
        cost.style.backgroundColor = "rgba(131, 120, 47, 0.7)"
        cost.style.color = "#fff"
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
}