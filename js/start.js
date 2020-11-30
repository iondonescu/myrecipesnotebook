// let image = document.getElementsByClassName("food-image");
// for(let i=0;i<=3;i++){
//     document.write("<button class='submit_button'> Acesta este un buton</button>")
// }
// let picture = document.getElementsByClassName("food-images");
// picture[0].onmouseover = function(){
//     let right_button = document.getElementsByClassName("right-button");
//     right_button[0].style.visibility = "visible";
//     let left_button = document.getElementsByClassName("left-button");
//     left_button[0].style.visibility = "visible";
//
//     right_button[0].addEventListener("click", function(){
//         let img = document.getElementsByClassName("food-image");
//         img[0].classList.remove("food-image-display-block");
//         img[0].classList.add("food-image-display-none");
//         img[1].classList.remove("food-image-display-none");
//         img[1].classList.add("food-image-display-block");
//         // let img = document.createElement("img");
//         // img.src = "./images/friptura_de_porc_2.jpg";
//         // let images = document.getElementsByClassName("food-images");
//         // images[0].appendChild(img);
//     })
// }
//
// picture[0].onmouseout = function(){
//     let right_button = document.getElementsByClassName("right-button");
//     right_button[0].style.visibility = "hidden";
//     let left_button = document.getElementsByClassName("left-button");
//     left_button[0].style.visibility = "hidden";
// }
// let list = $('.item');
// list.css('color','red');
let text = document.getElementById("text");
let btn = document.getElementById("btn");

btn.addEventListener("click",changeText);
function changeText() {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            text.innerHTML = xmlhttp.responseText;
        }
    }
        xmlhttp.open("GET", "file.php", true); //Change file.php to the location of your php file
        xmlhttp.send();
 }
