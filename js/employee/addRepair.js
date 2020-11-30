var electric = ["หลอดไฟ","พัดลม","แอร์"]
var furniture = ["ตู้เสื้อผ้า","เตียงนอน","โต๊ะ","ประตู","หน้าต่าง"]
var bathroom = ["เครื่องทำน้ำอุ่น","ชักโครก","สายชำระ","อ่างล้างหน้า","ก๊อกน้ำ"]
var html = ''

function categoryList(){
    var select = document.getElementById("select").value 
    var mydiv = document.getElementById('list')
    while (mydiv.firstChild) {
        mydiv.removeChild(mydiv.firstChild)
    }
    if(select == "เครื่องใช้ไฟฟ้า"){
        for(var i = 0;i< electric.length;i++){
            html = `<option value="${electric[i]}">${electric[i]}</option>`
            document.getElementById('list').innerHTML += html
        }
        console.log(select)
    }else if(select == "เฟอร์นิเจอร์"){
        for(var i = 0;i< furniture.length;i++){
            html = `<option value="${furniture[i]}">${furniture[i]}</option>`
            document.getElementById('list').innerHTML += html
        }
        console.log(select)
    }else if(select == "สุขภัณฑ์"){
        for(var i = 0;i< bathroom.length;i++){
            html = `<option value="${bathroom[i]}">${bathroom[i]}</option>`
            document.getElementById('list').innerHTML += html
        }
        console.log(select)
    }else{

    }
    console.log(html)
}