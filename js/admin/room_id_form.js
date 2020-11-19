function preview_image(event, pic) {
    console.log(pic)
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById(`output_image${pic}`);
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

function delImg(type, pictype, num) {
    if (confirm('คุณต้องการลบรูปภาพนี้ใช่หรือไม่ ?')) {
        location.href = `/Pingfah/pages/admin/roomlist/function/delImg.php?room_id=${type}&pic=${pictype}&num=${num}`
    }
}

function navigation() {
    var first = document.getElementById("first")
    var second = document.getElementById("second")
    if (first.style.display == 'none') {
        first.style.display = 'block'
        second.style.display = 'none'
    } else if (second.style.display == 'none') {
        first.style.display = 'none'
        second.style.display = 'block'
    }
}

function delData(room) {
    if (confirm(`คุณต้องการลบข้อมูลของห้อง ${room} ใช่หรือไม่`)) {
        location.assign(`/Pingfah/pages/admin/roomList/function/delRoom_data.php?ID=${room}`);
    }
}

function editData(num) {
    if (num == 1) {
        let btn = document.getElementById("btn-1")
        let edit = document.getElementById("edit-1")
        btn.style.display = "flex"
        edit.style.display = "none"
        document.getElementById("name_title").disabled = false
        document.getElementById("firstname").disabled = false
        document.getElementById("lastname").disabled = false
        document.getElementById("nickname").disabled = false
        document.getElementById("id_card").disabled = false
        document.getElementById("phone").disabled = false
        document.getElementById("email").disabled = false
        document.getElementById("line").disabled = false
        document.getElementById("birthday").disabled = false
        document.getElementById("age").disabled = false
        document.getElementById("race").disabled = false
        document.getElementById("nationality").disabled = false
        document.getElementById("job").disabled = false
        document.getElementById("address").disabled = false
        document.getElementById("pic_idcard1").disabled = false
        document.getElementById("pic_home1").disabled = false
        for (let i = 1; i <= 2; i++) {
            let del_btn = document.getElementById(`del-btn${i}`)
            if (del_btn) {
                del_btn.style.display = 'block'
            }
        }
    } else if (num == 2) {
        let btn = document.getElementById("btn-2")
        let edit = document.getElementById("edit-2")
        btn.style.display = "flex"
        edit.style.display = "none"
        document.getElementById("name_title2").disabled = false
        document.getElementById("firstname2").disabled = false
        document.getElementById("lastname2").disabled = false
        document.getElementById("nickname2").disabled = false
        document.getElementById("id_card2").disabled = false
        document.getElementById("phone2").disabled = false
        document.getElementById("email2").disabled = false
        document.getElementById("line2").disabled = false
        document.getElementById("birthday2").disabled = false
        document.getElementById("age2").disabled = false
        document.getElementById("race2").disabled = false
        document.getElementById("nationality2").disabled = false
        document.getElementById("job2").disabled = false
        document.getElementById("address2").disabled = false
        document.getElementById("pic_idcard2").disabled = false
        document.getElementById("pic_home2").disabled = false
        for (let i = 3; i <= 4; i++) {
            let del_btn = document.getElementById(`del-btn${i}`)
            if (del_btn) {
                del_btn.style.display = 'block'
            }
        }
    }
}

function cancelEditData(num) {
    if (num == 1) {
        let btn = document.getElementById("btn-1")
        let edit = document.getElementById("edit-1")
        btn.style.display = "none"
        edit.style.display = "flex"
        document.getElementById("name_title").disabled = true
        document.getElementById("firstname").disabled = true
        document.getElementById("lastname").disabled = true
        document.getElementById("nickname").disabled = true
        document.getElementById("id_card").disabled = true
        document.getElementById("phone").disabled = true
        document.getElementById("email").disabled = true
        document.getElementById("line").disabled = true
        document.getElementById("birthday").disabled = true
        document.getElementById("age").disabled = true
        document.getElementById("race").disabled = true
        document.getElementById("nationality").disabled = true
        document.getElementById("job").disabled = true
        document.getElementById("address").disabled = true
        document.getElementById("pic_idcard1").disabled = true
        document.getElementById("pic_home1").disabled = true
        for (let i = 1; i <= 2; i++) {
            let del_btn = document.getElementById(`del-btn${i}`)
            if (del_btn) {
                del_btn.style.display = 'none'
            }
        }
    } else if (num == 2) {
        let btn = document.getElementById("btn-2")
        let edit = document.getElementById("edit-2")
        btn.style.display = "none"
        edit.style.display = "flex"
        document.getElementById("name_title2").disabled = true
        document.getElementById("firstname2").disabled = true
        document.getElementById("lastname2").disabled = true
        document.getElementById("nickname2").disabled = true
        document.getElementById("id_card2").disabled = true
        document.getElementById("phone2").disabled = true
        document.getElementById("email2").disabled = true
        document.getElementById("line2").disabled = true
        document.getElementById("birthday2").disabled = true
        document.getElementById("age2").disabled = true
        document.getElementById("race2").disabled = true
        document.getElementById("nationalit2y").disabled = true
        document.getElementById("job2").disabled = true
        document.getElementById("address2").disabled = true
        document.getElementById("pic_idcard2").disabled = true
        document.getElementById("pic_home2").disabled = true
        for (let i = 3; i <= 4; i++) {
            let del_btn = document.getElementById(`del-btn${i}`)
            if (del_btn) {
                del_btn.style.display = 'none'
            }
        }
    }
}

// var fileUpload = document.getElementById('pic_idcard');
// var fileUpload2 = document.getElementById('pic_home');
// var fileUpload3 = document.getElementById('pic_idcard2');
// var fileUpload4 = document.getElementById('pic_home2');
// var idcard_img = document.getElementById('idcard_img');
// var home_img = document.getElementById('home_img');
// var idcard_img2 = document.getElementById('idcard_img2');
// var home_img2 = document.getElementById('home_img2');
// var canvas = document.getElementById('canvas');
// var canvas2 = document.getElementById('canvas2');
// var canvas3 = document.getElementById('canvas3');
// var canvas4 = document.getElementById('canvas4');



// function readImage() {
//     var ctx = canvas.getContext("2d");
//     if (idcard_img) {
//         console.log("x")
//         idcard_img.style.display = 'none'
//         canvas.style.display = 'block'
//         if (this.files && this.files[0]) {
//             console.log(this.files)
//             var FR = new FileReader();
//             FR.onload = function (e) {
//                 var img = new Image();
//                 img.src = e.target.result;
//                 img.onload = function () {
//                     ctx.drawImage(img, 0, 0, 762, 400);
//                 };
//             };
//             FR.readAsDataURL(this.files[0]);
//         }
//     } else {
//         console.log("y")
//         if (this.files && this.files[0]) {
//             console.log(this.files)
//             var FR = new FileReader();
//             FR.onload = function (e) {
//                 var img = new Image();
//                 img.src = e.target.result;
//                 img.onload = function () {
//                     ctx.drawImage(img, 0, 0, 762, 400);
//                 };
//             };
//             FR.readAsDataURL(this.files[0]);
//         }
//     }

// }

// function readImage2() {
//     var ctx2 = canvas2.getContext("2d");
//     if (home_img) {
//         home_img.style.display = 'none'
//         canvas2.style.display = 'block'
//         if (this.files && this.files[0]) {
//             console.log(this.files)
//             var FR = new FileReader();
//             FR.onload = function (e) {
//                 var img = new Image();
//                 img.src = e.target.result;
//                 img.onload = function () {
//                     ctx2.drawImage(img, 0, 0, 762, 400);
//                 };
//             };
//             FR.readAsDataURL(this.files[0]);
//         }
//     } else {
//         if (this.files && this.files[0]) {
//             console.log(this.files)
//             var FR = new FileReader();
//             FR.onload = function (e) {
//                 var img = new Image();
//                 img.src = e.target.result;
//                 img.onload = function () {
//                     ctx2.drawImage(img, 0, 0, 762, 400);
//                 };
//             };
//             FR.readAsDataURL(this.files[0]);
//         }
//     }

// }

// function readImage3() {
//     var ctx3 = canvas3.getContext("2d");
//     if (idcard_img2) {
//         idcard_img2.style.display = 'none'
//         canvas3.style.display = 'block'
//         if (this.files && this.files[0]) {
//             console.log(this.files)
//             var FR = new FileReader();
//             FR.onload = function (e) {
//                 var img = new Image();
//                 img.src = e.target.result;
//                 img.onload = function () {
//                     ctx3.drawImage(img, 0, 0, 762, 400);
//                 };
//             };
//             FR.readAsDataURL(this.files[0]);
//         }
//     } else {
//         if (this.files && this.files[0]) {
//             console.log(this.files)
//             var FR = new FileReader();
//             FR.onload = function (e) {
//                 var img = new Image();
//                 img.src = e.target.result;
//                 img.onload = function () {
//                     ctx3.drawImage(img, 0, 0, 762, 400);
//                 };
//             };
//             FR.readAsDataURL(this.files[0]);
//         }
//     }


// }

// function readImage4() {
//     var ctx4 = canvas4.getContext("2d");
//     if (home_img2) {
//         home_img2.style.display = 'none'
//         canvas2.style.display = 'block'
//         if (this.files && this.files[0]) {
//             console.log(this.files)
//             var FR = new FileReader();
//             FR.onload = function (e) {
//                 var img = new Image();
//                 img.src = e.target.result;
//                 img.onload = function () {
//                     ctx4.drawImage(img, 0, 0, 762, 400);
//                 };
//             };
//             FR.readAsDataURL(this.files[0]);
//         }
//     } else {
//         if (this.files && this.files[0]) {
//             console.log(this.files)
//             var FR = new FileReader();
//             FR.onload = function (e) {
//                 var img = new Image();
//                 img.src = e.target.result;
//                 img.onload = function () {
//                     ctx4.drawImage(img, 0, 0, 762, 400);
//                 };
//             };
//             FR.readAsDataURL(this.files[0]);
//         }
//     }

// }

// fileUpload.onchange = readImage;
// fileUpload2.onchange = readImage2;
// fileUpload3.onchange = readImage3;
// fileUpload4.onchange = readImage4;