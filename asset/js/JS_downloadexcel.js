var counttables = document.getElementById('counttables');
var counttablesclassList = counttables.classList;

var judul = document.getElementById('judul');
var judulclassList = judul.classList;

if(counttablesclassList != 0){
    var tables = [];
    for (var i = 0; i < counttablesclassList; i++) {
        tables[i] = document.getElementById("table" + i);
    }

    var ws = [];
    for (let j = 0; j < counttablesclassList; j++) {
        ws[j] = XLSX.utils.table_to_sheet(tables[j]);
    }

    var wb = XLSX.utils.book_new();

    var sheet = [];
    var countsheet = [];
    for (var l = 0; l < counttablesclassList; l++) {
        sheet[l] = document.getElementById("sheet" + l);
        countsheet[l] = sheet[l].classList;
    }

    for (let k = 0; k < counttablesclassList; k++) {
        XLSX.utils.book_append_sheet(wb, ws[k], countsheet[k].value)
    }

    XLSX.writeFile(wb, judulclassList+".xlsx");
}else{
    var table0 = document.getElementById("table0");

    var ws0 = XLSX.utils.table_to_sheet(table0);

    var wb = XLSX.utils.book_new();

    XLSX.utils.book_append_sheet(wb, ws0, "Sheet1");

    XLSX.writeFile(wb, judulclassList+".xlsx");
}

setTimeout(function() {
    var rollback = document.getElementById('rollback');
    var rollbackclassList = rollback.classList;

    var linkback = document.getElementById('linkback');
    var linkbackclassList = linkback.classList;

    if(rollbackclassList == "yes"){
        window.location=linkbackclassList;
    }
}, 0,1);
