
function arataReteta(str) {
var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("body").innerHTML = this.responseText;
                //alert('buna');
            }
        };
        //alert(str);
        xmlhttp.open("GET",'reteta_mea.php?cod='+str,true);
        xmlhttp.send();

};

/*
 Slideshow pentru fotografiile retetei
 */
let index = 1;
arataFoto(index);

function increment(n) {
    arataFoto(index += n);
}

function arataFoto(n) {
    var i;
    var x = document.getElementsByClassName("reteta_imagine");
    if (n > x.length) {index = 1}
    if (n < 1) {index = x.length} ;
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    x[index-1].style.display = "block";
}



