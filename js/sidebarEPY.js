var app = new Vue({
    el: '#app',
    data: {
        topic: '',
        menuList: [{
            link: '/Pingfah/pages/employee/index.php',
            // icon: 'home',
            text: 'หน้าหลัก',
            id: 'home'
        },{
            link: '/Pingfah/pages/employee/roomDetail/index.php',
            // icon: 'home',
            text: 'ข้อมูลหอพัก',
            id: 'roomDetail'
        }, {
            link: '/Pingfah/pages/employee/roomList/index.php',
            // icon: 'home',
            text: 'รายการห้องพัก',
            id: 'roomList'
        }, {
            link: '/Pingfah/pages/employee/cost/index.php',
            // icon: 'home',
            text: 'ค่าใช้จ่าย',
            id: 'cost'
        }, {
            link: '/Pingfah/#',
            // icon: 'home',
            text: 'รายการแจ้งซ่อม',
        }, {
            link: '/Pingfah/#',
            // icon: 'home',
            text: 'รายการร้องเรียน',
        }, {
            link: '/Pingfah/pages/employee/package/index.php',
            // icon: 'home',
            text: 'รายการพัสดุ',
            id:"package"
        }, {
            link: '/Pingfah/#',
            // icon: 'home',
            text: 'กฏเกณฑ์หอพัก',
        }]
    },
    mounted() {
        if (window.location.pathname == "/Pingfah/pages/employee/home.php") {
            document.getElementById("home").style.backgroundColor = 'rgba(131, 120, 47, 0.7)'
            document.getElementById("home").style.color = 'white'
            document.getElementById("topbar-page").innerHTML = 'หน้าหลัก'
            localStorage.setItem("i", window.location.pathname)
        } else if (window.location.pathname == "/Pingfah/pages/employee/roomDetail.php") {
            document.getElementById("roomDetail").style.backgroundColor = 'rgba(131, 120, 47, 0.7)'
            document.getElementById("roomDetail").style.color = 'white'
            document.getElementById("topbar-page").innerHTML = 'ข้อมูลหอพัก'
            localStorage.setItem("i", window.location.pathname)
        } else if (window.location.pathname == "/Pingfah/pages/employee/roomList/index.php") {
            document.getElementById("roomList").style.backgroundColor = 'rgba(131, 120, 47, 0.7)'
            document.getElementById("roomList").style.color = 'white'
            document.getElementById("topbar-page").innerHTML = 'รายการห้องพัก'
            localStorage.setItem("i", window.location.pathname)
        } else if (window.location.pathname == "/Pingfah/pages/employee/package/index.php") {
            document.getElementById("package").style.backgroundColor = 'rgba(131, 120, 47, 0.7)'
            document.getElementById("package").style.color = 'white'
            document.getElementById("topbar-page").innerHTML = 'รายการพัสดุ'
            localStorage.setItem("i", window.location.pathname)
        } else if (window.location.pathname == "/Pingfah/pages/employee/cost/index.php") {
            document.getElementById("cost").style.backgroundColor = 'rgba(131, 120, 47, 0.7)'
            document.getElementById("cost").style.color = 'white'
            document.getElementById("topbar-page").innerHTML = 'ค่าใช้จ่าย'
            localStorage.setItem("i", window.location.pathname)
        } else {
            if (localStorage.getItem("i") == "/Pingfah/pages/employee/roomList/index.php") {
                document.getElementById("roomList").style.backgroundColor = 'rgba(131, 120, 47, 0.7)'
                document.getElementById("roomList").style.color = 'white'
                document.getElementById("topbar-page").innerHTML = 'รายการห้องพัก'
            }
        }
    }
})