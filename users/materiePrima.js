let plus1 = document.getElementsByClassName("plus")[0];
let tabelMateriiPrime = document.getElementById("rows");//variabila pt tabel

/*
adaugă în tabel linie pentru ingredient
 */
plus1.onclick = function adaugaMaterie() {
    let row = tabelMateriiPrime.insertRow(-1);
    let cell1 = row.insertCell(0);
    let cell2 = row.insertCell(1);
    let cell3 = row.insertCell(2);
    let cell4 = row.insertCell(3);
    let cell5 = row.insertCell(4);
    cell1.innerHTML = "<input type=\"text\" name=\"materiePrima[]\"  required/>";
    cell2.innerHTML = "<select id=\"um\" name=\"um[]\">\n" +
        "                                <option value=\"kg\">kg</option>\n" +
        "                                <option value=\"g\">g</option>\n" +
        "                                <option value=\"l\">l</option>\n" +
        "                                <option value=\"ml\">ml</option>\n" +
        "                                <option value=\"lingura\">lingură</option>\n" +
        "                                <option value=\"lingurita\">linguriță</option>\n" +
        "                                <option value=\"cana\">cană</option>\n" +
        "                                <option value=\"ceasca\">ceașcă</option>\n" +
        "                                <option value=\"buc\">buc</option>\n" +
        "                            </select>";
    cell3.innerHTML = " <input type=\"text\" name=\"cantitate[]\"  required/>";
    cell4.innerHTML = "<input type=\"text\"   name=\"observatii[]\">";
    cell5.innerHTML = "<div class=\"minus\" >\n" +
        "                               <i class=\"fas fa-minus-circle\"   onclick =\"stergeMateriePrima(this)\"></i>\n" +
        "                           </div>";
}

/*
sterge din tabel linie pentru ingredient
 */
function stergeMateriePrima(r) {
    let i = r.parentNode.parentNode.parentNode.rowIndex;
    tabelMateriiPrime.deleteRow(i-1);
}

/*
adauga fotografie
 */
let plus2 = document.getElementsByClassName("plus")[1];
let nrFotografii = 1;
let tabelFotografii = document.getElementById("fotografii");
let plusFoto = document.getElementById("schimbaClasa");
plus2.onclick = function adaugaFotografie() {
    nrFotografii++;
    if (nrFotografii <= 5) {
        let row = tabelFotografii.insertRow(-1);
        let altaFotografie = document.createElement("input");
        let cell1 = row.insertCell(0);
        let cell2 = row.insertCell(1);
        cell1.innerHTML = "<input type=\"file\" class=\"fotografie\" name=\"foto[]\"/>";
        cell2.innerHTML = "<div class=\"minus\">\n" +
            "                           <i class=\"fas fa-minus-circle\" onclick=\"stergeFotografie(this)\"></i>\n" +
            "                       </div>";
         }
    else {
            plusFoto.classList.toggle("hidden");
        }
}

/*
sterge fotografie
 */
function stergeFotografie(r) {
    let i = r.parentNode.rowIndex;
    tabelFotografii.deleteRow(i);
    plusFoto.classList.remove("hidden");
    nrFotografii--;
}
//de setat name pt fiecare fotografie unic
let fotografie = document.getElementsByClassName("fotografie");
for(let i=0;i<fotografie.length-1;i++){
    fotografie[i].setAttribute("name","foto"+i);
    alert(fotografie[i]);
}

//de implementat facilitatea de previzualizare înainte de salvare
let previzualizareButton = document.getElementsByTagName("button")[0];
previzualizareButton.onclick = function ataseaza(){
    let previzualizare = document.getElementsByClassName("previzualizare")[0];
    let paragraph = document.createElement('p');
    let text = document.createTextNode("under construction")
    paragraph.appendChild(text);
    previzualizare.appendChild(paragraph);
}




