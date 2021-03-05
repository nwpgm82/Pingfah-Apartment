$(document).ready(function () {
    let come = $("#come_date")
    let title_name = $("#title_name")
    let firstname = $("#firstname")
    let lastname = $("#lastname")
    let nickname = $("#nickname")
    let id_card = $("#id_card")
    let birthday = $("#birthday")
    let age = $("#age")
    let tel = $("#tel")
    let email = $("#email")
    let race = $("#race")
    let nation = $("#nation")
    let job = $("#job")
    let address = $("#address")
    let id_img = $("#id_img")
    let home_img = $("#home_img")

    function BasicDate(date) {
        let year = date.getFullYear()
        let month = date.getMonth() + 1
        let day = date.getDate()
        if (day < 10) {
            day = "0" + day.toString()
        }
        if (month < 10) {
            month = "0" + month.toString()
        }
        return year + "-" + month + "-" + day
    }

    function get_age(born, now) {
        let birthday = new Date(now.getFullYear(), born.getMonth(), born.getDate());
        if (now >= birthday) {
            return now.getFullYear() - born.getFullYear();
        } else {
            return now.getFullYear() - born.getFullYear() - 1;
        }
    }

    function getExtension(filename) {
        var parts = filename.split('.');
        return parts[parts.length - 1];
    }

    function isImage(filename) {
        var ext = getExtension(filename);
        switch (ext.toLowerCase()) {
            case 'jpg':
            // case 'pdf':
            case 'png':
                //etc
                return true;
        }
        return false;
    }
    $("#add-btn").click(function () {
        $(".new_customer").remove()
        $("#form-box").show()
    })
    come.dateDropper({
        format: "d M Y",
        lang: "th",
        theme: "my-style",
        large: true,
        largeDefault: true,
        largeOnly: true,
        lock: "to"
    });
    birthday.dateDropper({
        format: "d M Y",
        lang: "th",
        theme: "my-style",
        large: true,
        largeDefault: true,
        largeOnly: true,
        lock: "to"
    })
    come.change(function () {
        if (come.val() == "") {
            come.css("border-color", "red")
            come.css("background-image", "url('../../../img/tool/calendar-error.png')")
            come.addClass("placeholder-error")
            $("#come_error").html("โปรดระบุวันที่เริ่มเข้าพักของผู้เข้าพัก")
        } else {
            come.css("border-color", "")
            come.css("background-image", "")
            come.removeClass("placeholder-error")
            $("#come_error").html("")
        }
    })
    firstname.keyup(function () {
        if (firstname.val() == "") {
            firstname.css("border-color", "red")
            firstname.addClass("placeholder-error")
            $("#fs_error").html("โปรดระบุชื่อของผู้เข้าพัก")
        } else {
            firstname.css("border-color", "")
            firstname.removeClass("placeholder-error")
            $("#fs_error").html("")
        }
    })
    lastname.keyup(function () {
        if (lastname.val() == "") {
            lastname.css("border-color", "red")
            lastname.addClass("placeholder-error")
            $("#ls_error").html("โปรดระบุนามสกุลของผู้เข้าพัก")
        } else {
            lastname.css("border-color", "")
            lastname.removeClass("placeholder-error")
            $("#ls_error").html("")
        }
    })
    nickname.keyup(function () {
        if (nickname.val() == "") {
            nickname.css("border-color", "red")
            nickname.addClass("placeholder-error")
            $("#nk_error").html("โปรดระบุชื่อเล่นของผู้เข้าพัก")
        } else {
            nickname.css("border-color", "")
            nickname.removeClass("placeholder-error")
            $("#nk_error").html("")
        }
    })
    id_card.keyup(function () {
        $(this).val($(this).val().replace(/[^\w\s]+/g, ''));
        if (id_card.val() == "") {
            id_card.css("border-color", "red")
            id_card.addClass("placeholder-error")
            $("#id_error").html("โปรดระบุเลขบัตรประชาชน หรือ Passport No.")
        } else if(id_card.val().length != 7 && id_card.val().length != 8 && id_card.val().length != 9 && id_card.val().length != 13){
            id_card.css("border-color", "red")
            id_card.addClass("placeholder-error")
            $("#id_error").html("รูปแบบเลขบัตรประชาชน หรือ Passport No. ไม่ตรงกัน")
        }else {
            id_card.css("border-color", "")
            id_card.removeClass("placeholder-error")
            $("#id_error").html("")
        }
    });
    birthday.change(function () {
        if (birthday.val() == "") {
            birthday.css("border-color", "red")
            birthday.css("background-image", "url('../../../img/tool/calendar-error.png')")
            birthday.addClass("placeholder-error")
            $("#bd_error").html("โปรดระบุวันเกิดของผู้เข้าพัก")
        } else {
            birthday.css("border-color", "")
            birthday.css("background-image", "")
            birthday.removeClass("placeholder-error")
            $("#bd_error").html("")
            const search = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
            const replace = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            let birth = birthday.val()
            birth = birth.split(" ")
            birth[1] = search.findIndex(el => el === birth[1])
            birth[1] = replace[birth[1]]
            birth = birth.join(" ")
            birth = BasicDate(new Date(birth))
            let now = new Date()
            let birthdate = birth.split("-")
            let born = new Date(birthdate[0], birthdate[1] - 1, birthdate[2])
            age.val(get_age(born, now))
            if (age.val() == "" || age.val() == "0") {
                age.css("border-color", "red")
                age.css("color", "red")
                age.addClass("placeholder-error")
                $("#ag_error").html("โปรดระบุวันเกิดของผู้เข้าพัก")
            } else {
                age.css("border-color", "")
                age.css("color", "")
                age.removeClass("placeholder-error")
                $("#ag_error").html("")
            }
        }
    })
    tel.keyup(function (event) {
        if (event.which !== 8 && event.which !== 0 && event.which < 48 || event.which > 57) {
            $(this).val(function (index, value) {
                return value.replace(/\D/g, "");
            });
        }
        if (tel.val() == "") {
            tel.css("border-color", "red")
            tel.addClass("placeholder-error")
            $("#tel_error").html("โปรดระบุเบอร์โทรศัพท์ของผู้เข้าพัก")
        } else {
            tel.css("border-color", "")
            tel.removeClass("placeholder-error")
            $("#tel_error").html("")
        }
    })
    email.keyup(function () {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (email.val() == "") {
            email.css("border-color", "red")
            email.addClass("placeholder-error")
            $("#em_error").html("โปรดระบุอีเมล")
        } else {
            if (re.test(String(email.val()))) {
                email.css("border-color", "")
                email.removeClass("placeholder-error")
                $("#em_error").html("")
            } else {
                email.css("border-color", "red")
                email.addClass("placeholder-error")
                $("#em_error").html("รูปแบบไม่ตรงกัน")
            }
        }
    })
    race.keyup(function () {
        if (race.val() == "") {
            race.css("border-color", "red")
            race.addClass("placeholder-error")
            $("#rc_error").html("โปรดระบุเชื้อชาติของผู้เข้าพัก")
        } else {
            race.css("border-color", "")
            race.removeClass("placeholder-error")
            $("#rc_error").html("")
        }
    })
    nation.keyup(function () {
        if (nation.val() == "") {
            nation.css("border-color", "red")
            nation.addClass("placeholder-error")
            $("#na_error").html("โปรดระบุสัญชาติของผู้เข้าพัก")
        } else {
            nation.css("border-color", "")
            nation.removeClass("placeholder-error")
            $("#na_error").html("")
        }
    })
    job.keyup(function () {
        if (job.val() == "") {
            job.css("border-color", "red")
            job.addClass("placeholder-error")
            $("#job_error").html("โปรดระบุอาชีพของผู้เข้าพัก")
        } else {
            job.css("border-color", "")
            job.removeClass("placeholder-error")
            $("#job_error").html("")
        }
    })
    address.keyup(function () {
        if (address.val() == "") {
            address.css("border-color", "red")
            address.addClass("placeholder-error")
            $("#ad_error").html("โปรดระบุที่อยู่ของผู้เข้าพัก")
        } else {
            address.css("border-color", "")
            address.removeClass("placeholder-error")
            $("#ad_error").html("")
        }
    })
    id_img.change(function () {
        if (isImage(id_img.val()) == false) {
            $("#id_box").css("border-color", "red")
            $("#idimg_error").html("รองรับไฟล์ประเภท jpg, png ขนาดไม่เกิน 5 MB เท่านั้น")
            id_img.val("")
            $('#img_id').attr('src', "");
            $("#img_id").hide()
        } else {
            if (this.files && this.files[0]) {
                if (this.files[0].size < 5242880) {
                    $("#img_id").show()
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#img_id').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]); // convert to base64 string
                    $("#id_box").css("border-color", "")
                    $("#idimg_error").html("")
                } else {
                    $("#id_box").css("border-color", "red")
                    $("#idimg_error").html("ขนาดรูปภาพใหญ่เกินไป (ไม่เกิน 5 MB)")
                    id_img.val("")
                    $('#img_id').attr('src', "");
                    $("#img_id").hide()
                }
            }
        }
    })
    home_img.change(function () {
        if (isImage(home_img.val()) == false) {
            $("#home_box").css("border-color", "red")
            $("#homeimg_error").html("รองรับไฟล์ประเภท jpg, png ขนาดไม่เกิน 5 MB เท่านั้น")
            home_img.val("")
            $('#img_home').attr('src', "");
            $("#img_home").hide()
        } else {
            if (this.files && this.files[0]) {
                if (this.files[0].size < 5242880) {
                    $("#img_home").show()
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#img_home').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]); // convert to base64 string
                    $("#home_box").css("border-color", "")
                    $("#homeimg_error").html("")
                } else {
                    $("#home_box").css("border-color", "red")
                    $("#homeimg_error").html("ขนาดรูปภาพใหญ่เกินไป (ไม่เกิน 5 MB)")
                    home_img.val("")
                    $('#img_home').attr('src', "");
                    $("#img_home").hide()
                }
            }
        }
    })
    $("#addData-btn").click(function (event) {
        let inputs = $("input");
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        inputs.each(function () {
            if ($(this).val() == "" || $(this).val() == 0) {
                if ($(this).attr("id") == "come_date") {
                    $(this).css("border-color", "red")
                    $(this).css("background-image", "url('../../../img/tool/calendar-error.png')")
                    $(this).addClass("placeholder-error")
                    $("#come_error").html("โปรดระบุวันที่เริ่มเข้าพักของผู้เข้าพัก")
                } else if ($(this).attr("id") == "birthday") {
                    $(this).css("border-color", "red")
                    $(this).css("background-image", "url('../../../img/tool/calendar-error.png')")
                    $(this).addClass("placeholder-error")
                    $("#bd_error").html("โปรดระบุวันเกิดของผู้เข้าพัก")
                } else if ($(this).attr("id") == "id_img") {
                    $("#id_box").css("border-color", "red")
                    $("#idimg_error").html("โปรดเพิ่มรูปภาพสำเนาบัตรประชาชน")
                } else if ($(this).attr("id") == "home_img") {
                    $("#home_box").css("border-color", "red")
                    $("#homeimg_error").html("โปรดเพิ่มรูปภาพสำเนาทะเบียนบ้าน")
                } else {
                    $(this).css("border-color", "red")
                    $(this).addClass("placeholder-error")
                    if ($(this).attr("id") == "firstname") {
                        $("#fs_error").html("โปรดระบุชื่อของผู้เข้าพัก")
                    } else if ($(this).attr("id") == "lastname") {
                        $("#ls_error").html("โปรดระบุนามสกุลของผู้เข้าพัก")
                    } else if ($(this).attr("id") == "nickname") {
                        $("#nk_error").html("โปรดระบุชื่อเล่นของผู้เข้าพัก")
                    } else if ($(this).attr("id") == "id_card") {
                        $("#id_error").html("โปรดระบุเลขบัตรประชาชน หรือ Passport No.")
                    } else if ($(this).attr("id") == "age") {
                        $("#ag_error").html("โปรดระบุอายุของผู้เข้าพัก")
                        age.css("color", "red")
                    } else if ($(this).attr("id") == "tel") {
                        $("#tel_error").html("โปรดระบุเบอร์โทรศัพท์ของผู้เข้าพัก")
                    } else if ($(this).attr("id") == "email") {
                        $("#em_error").html("โปรดระบุอีเมล")
                    } else if ($(this).attr("id") == "race") {
                        $("#rc_error").html("โปรดระบุเชื้อชาติของผู้เข้าพัก")
                    } else if ($(this).attr("id") == "nation") {
                        $("#na_error").html("โปรดระบุสัญชาติของผู้เข้าพัก")
                    } else if ($(this).attr("id") == "job") {
                        $("#job_error").html("โปรดระบุอาชีพของผู้เข้าพัก")
                    }
                }
                event.preventDefault()
            }
        })
        if (email.val() != "") {
            if (!re.test(String(email.val()))) {
                $("#em_error").html("รูปแบบไม่ตรงกัน")
                event.preventDefault()
            }
        }
        if (id_card.val().length != 7 && id_card.val().length != 8 && id_card.val().length != 9 && id_card.val().length != 13) {
            id_card.css("border-color", "red")
            id_card.addClass("placeholder-error")
            $("#id_error").html("รูปแบบเลขบัตรประชาชน หรือ Passport No. ไม่ตรงกัน")
            event.preventDefault()
        }
        if (address.val() == "") {
            address.css("border-color", "red")
            address.addClass("placeholder-error")
            $("#ad_error").html("โปรดระบุที่อยู่ของผู้เข้าพัก")
            event.preventDefault()
        }
    })
    $("#edit").click(function () {
        $("#option-btn").hide()
        $("#title_name").prop("disabled", false)
        let inputs = $("input")
        inputs.each(function (i) {
            if (i == 0 || i == 1) {
                return true
            } else if ($(this).attr("id") == "age") {
                $(this).prop("disabled", false)
                $(this).prop("readonly", true)
            } else {
                $(this).prop("disabled", false)
            }
        })
        address.prop("disabled", false)
        $("#edit-option").css("display", "flex")
        $("#del-idimg").show()
        $("#del-homeimg").show()
    })
    $("#accept-edit").click(function (event) {
        if (confirm("คุณต้องการบันทึกการแก้ไขนี้ใช่หรือไม่")) {
            let inputs = $("input");
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            inputs.each(function (i) {
                if (i == 0 || i == 1 || i == 13 || i == 14) {
                    return true;
                } else {
                    if ($(this).val() == "" || $(this).val() == 0) {
                        if ($(this).attr("id") == "birthday") {
                            $(this).css("border-color", "red")
                            $(this).css("background-image", "url('../../../img/tool/calendar-error.png')")
                            $(this).addClass("placeholder-error")
                            $("#bd_error").html("โปรดระบุวันเกิดของผู้เข้าพัก")
                        } else {
                            $(this).css("border-color", "red")
                            $(this).addClass("placeholder-error")
                            if ($(this).attr("id") == "firstname") {
                                $("#fs_error").html("โปรดระบุชื่อของผู้เข้าพัก")
                            } else if ($(this).attr("id") == "lastname") {
                                $("#ls_error").html("โปรดระบุนามสกุลของผู้เข้าพัก")
                            } else if ($(this).attr("id") == "nickname") {
                                $("#nk_error").html("โปรดระบุชื่อเล่นของผู้เข้าพัก")
                            } else if ($(this).attr("id") == "id_card") {
                                $("#id_error").html("โปรดระบุเลขบัตรประชาชน หรือ Passport No.")
                            } else if ($(this).attr("id") == "age") {
                                $("#ag_error").html("โปรดระบุอายุของผู้เข้าพัก")
                                age.css("color", "red")
                            } else if ($(this).attr("id") == "tel") {
                                $("#tel_error").html("โปรดระบุเบอร์โทรศัพท์ของผู้เข้าพัก")
                            } else if ($(this).attr("id") == "email") {
                                $("#em_error").html("โปรดระบุอีเมล")
                            } else if ($(this).attr("id") == "race") {
                                $("#rc_error").html("โปรดระบุเชื้อชาติของผู้เข้าพัก")
                            } else if ($(this).attr("id") == "nation") {
                                $("#na_error").html("โปรดระบุสัญชาติของผู้เข้าพัก")
                            } else if ($(this).attr("id") == "job") {
                                $("#job_error").html("โปรดระบุอาชีพของผู้เข้าพัก")
                            }
                        }
                        event.preventDefault()
                    }
                }
            })
            if (email.val() != "") {
                if (!re.test(String(email.val()))) {
                    $("#em_error").html("รูปแบบไม่ตรงกัน")
                    event.preventDefault()
                }
            }
            if (address.val() == "") {
                address.css("border-color", "red")
                address.addClass("placeholder-error")
                $("#ad_error").html("โปรดระบุที่อยู่ของผู้เข้าพัก")
                event.preventDefault()
            }
        } else {
            event.preventDefault()
        }
    })
    $("#cancel-edit").click(function () {
        $("#option-btn").show()
        $("#title_name").prop("disabled", true)
        let inputs = $("input")
        inputs.each(function (i) {
            if (i == 0) {
                return 0
            } else if ($(this).attr("id") == "age") {
                $(this).prop("disabled", true)
                $(this).prop("readonly", false)
            } else {
                $(this).prop("disabled", true)
            }
        })
        address.prop("disabled", true)
        $("#edit-option").hide()
        $("#del-idimg").hide()
        $("#del-homeimg").hide()
        document.location.reload()
    })
    // $("#del-idimg").click(function (event) {
    //     if (confirm("คุณต้องการลบรูปภาพใช่หรือไม่ ?")) {
    //         $("#form-box").submit()
    //     } else {
    //         event.preventDefault()
    //     }
    // })
    // $("#del-homeimg").click(function (event) {
    //     if (confirm("คุณต้องการลบรูปภาพใช่หรือไม่ ?")) {
    //         $("#form-box").submit()
    //     } else {
    //         event.preventDefault()
    //     }
    // })
    $("#del_data").click(function (event) {
        if (confirm("คุณต้องการลบข้อมูลใช่หรือไม่")) {
            $("#form-box").submit()
        } else {
            event.preventDefault()
        }
    })
    // $("#quit").click(function (event) {
    //     if (confirm("คุณต้องการแจ้งออกใช่หรือไม่")) {
    //         $("#form-box").submit()
    //     } else {
    //         event.preventDefault()
    //     }
    // })
})