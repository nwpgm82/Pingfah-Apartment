var app = new Vue({
    el: '#app',
    data: {
        topic: '',
        menuList: [{
            link: '/Pingfah/pages/admin/index.php',
            // icon: 'home',
            text: 'หน้าหลัก',
            id: 'home'
        }, {
            link: '/Pingfah/pages/admin/employee/index.php',
            text: 'จัดการพนักงาน',
            id: 'employee'
        }, {
            link: '/Pingfah/pages/admin/roomDetail/index.php',
            // icon: 'home',
            text: 'ข้อมูลหอพัก',
            id: 'roomDetail'
        },{
            link: '/Pingfah/pages/admin/roomList/index.php',
            // icon: 'home',
            text: 'รายการห้องพัก',
            id: 'roomList'
        },
        // {
        //     link: '/Pingfah/pages/admin/roomDailyList/index.php',
        //     // icon: 'home',
        //     text: 'รายการห้องพักรายวัน',
        //     id: 'roomDailyList'
        // }, 
        {
            link: '/Pingfah/pages/admin/daily/index.php',
            // icon: 'home',
            text: 'รายการเช่าห้องพักรายวัน',
            id: 'daily'
        },{
            link: '/Pingfah/pages/admin/dailyCost/index.php',
            // icon: 'home',
            text: 'รายการชำระเงินรายวัน',
            id: 'dailycost'
        }, {
            link: '/Pingfah/pages/admin/cost/index.php',
            // icon: 'home',
            text: 'รายการชำระเงินรายเดือน',
            id: 'cost'
        }, {
            link: '/Pingfah/pages/admin/repair/index.php',
            // icon: 'home',
            text: 'รายการแจ้งซ่อม',
            id: 'repair'
        }, {
            link: '/Pingfah/pages/admin/package/index.php',
            // icon: 'home',
            text: 'รายการพัสดุ',
            id: 'package'
        }, {
            link: '/Pingfah/pages/admin/rule/index.php',
            // icon: 'home',
            text: 'กฏระเบียบหอพัก',
            id: 'rule'
        },{
            link: '/Pingfah/pages/admin/appeal/index.php',
            // icon: 'home',
            text: 'รายการร้องเรียน',
            id: 'appeal'
        }]
    },
    mounted() {
        if (window.location.pathname == "/Pingfah/pages/admin/home.php") {
            document.getElementById("home").style.backgroundColor = 'rgba(131, 120, 47, 0.7)'
            document.getElementById("home").style.color = 'white'
            document.getElementById("topbar-page").innerHTML = 'หน้าหลัก'
            localStorage.setItem("i", window.location.pathname)
        } else if (window.location.pathname == "/Pingfah/pages/admin/roomDetail/index.php") {
            document.getElementById("roomDetail").style.backgroundColor = 'rgba(131, 120, 47, 0.7)'
            document.getElementById("roomDetail").style.color = 'white'
            document.getElementById("topbar-page").innerHTML = 'ข้อมูลหอพัก'
            localStorage.setItem("i", window.location.pathname)
        }else if (window.location.pathname == "/Pingfah/pages/admin/daily/index.php") {
            document.getElementById("daily").style.backgroundColor = 'rgba(131, 120, 47, 0.7)'
            document.getElementById("daily").style.color = 'white'
            document.getElementById("topbar-page").innerHTML = 'รายการเช่าห้องพักรายวัน'
            localStorage.setItem("i", window.location.pathname)
        } else if (window.location.pathname == "/Pingfah/pages/admin/roomList/index.php") {
            document.getElementById("roomList").style.backgroundColor = 'rgba(131, 120, 47, 0.7)'
            document.getElementById("roomList").style.color = 'white'
            document.getElementById("topbar-page").innerHTML = 'รายการห้องพัก'
            localStorage.setItem("i", window.location.pathname)
        } else if (window.location.pathname == "/Pingfah/pages/admin/dailyCost/index.php"){
            document.getElementById("dailycost").style.backgroundColor = 'rgba(131, 120, 47, 0.7)'
            document.getElementById("dailycost").style.color = 'white'
            document.getElementById("topbar-page").innerHTML = 'รายการชำระเงินรายวัน'
            localStorage.setItem("i", window.location.pathname)

        } else if (window.location.pathname == "/Pingfah/pages/admin/cost/index.php"){
            document.getElementById("cost").style.backgroundColor = 'rgba(131, 120, 47, 0.7)'
            document.getElementById("cost").style.color = 'white'
            document.getElementById("topbar-page").innerHTML = 'รายการชำระเงินรายเดือน'
            localStorage.setItem("i", window.location.pathname)

        }else if(window.location.pathname == "/Pingfah/pages/admin/repair/index.php"){
            document.getElementById("repair").style.backgroundColor = 'rgba(131, 120, 47, 0.7)'
            document.getElementById("repair").style.color = 'white'
            document.getElementById("topbar-page").innerHTML = 'รายการแจ้งซ่อม'
            localStorage.setItem("i", window.location.pathname)
        }else if(window.location.pathname == "/Pingfah/pages/admin/appeal/index.php"){
            document.getElementById("appeal").style.backgroundColor = 'rgba(131, 120, 47, 0.7)'
            document.getElementById("appeal").style.color = 'white'
            document.getElementById("topbar-page").innerHTML = 'รายการร้องเรียน'
            localStorage.setItem("i", window.location.pathname)
        } else if (window.location.pathname == "/Pingfah/pages/admin/package/index.php") {
            document.getElementById("package").style.backgroundColor = 'rgba(131, 120, 47, 0.7)'
            document.getElementById("package").style.color = 'white'
            document.getElementById("topbar-page").innerHTML = 'รายการพัสดุ'
            localStorage.setItem("i", window.location.pathname)
        } else if (window.location.pathname == "/Pingfah/pages/admin/rule/index.php") {
            document.getElementById("rule").style.backgroundColor = 'rgba(131, 120, 47, 0.7)'
            document.getElementById("rule").style.color = 'white'
            document.getElementById("topbar-page").innerHTML = 'กฏระเบียบหอพัก'
            localStorage.setItem("i", window.location.pathname)
        } else if (window.location.pathname == "/Pingfah/pages/admin/employee/index.php") {
            document.getElementById("employee").style.backgroundColor = 'rgba(131, 120, 47, 0.7)'
            document.getElementById("employee").style.color = 'white'
            document.getElementById("topbar-page").innerHTML = 'จัดการพนักงาน'
            localStorage.setItem("i", window.location.pathname)
        } else {
            if (localStorage.getItem("i") == "/Pingfah/pages/admin/roomList/index.php") {
                document.getElementById("roomList").style.backgroundColor = 'rgba(131, 120, 47, 0.7)'
                document.getElementById("roomList").style.color = 'white'
                document.getElementById("topbar-page").innerHTML = 'รายการห้องพัก'
            }
        }
    }
})