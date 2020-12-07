AOS.init();
function showImg(num){
    let modal = document.querySelector(`#modal${num}`)
    modal.style.display = "flex"
    // console.log("yyy")
}

function close_modal(num){
    let modal = document.querySelector(`#modal${num}`)
    modal.style.display = "none"
}