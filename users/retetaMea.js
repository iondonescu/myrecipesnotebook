
function arataReteta(str) {
var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("body").innerHTML = this.responseText;
                //alert('buna');
            }
        };
        //alert(str);
        xmlhttp.open("GET",'retetaMea.php?cod='+str,true);
        xmlhttp.send();

};

