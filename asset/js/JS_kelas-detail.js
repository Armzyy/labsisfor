const urllocation = window.location.search;
const urlParams = new URLSearchParams(urllocation);
const navigation = urlParams.get('nav')

if(navigation == "forum"){
  ClassicEditor
  .create(document.querySelector('#input-deskripsi-pengumuman'))
  .catch(error => {
      console.error(error)
  })

  var maxtagEpengumuman = document.getElementById("maxtageditpengumuman");
  var maxEP = maxtagEpengumuman.classList;

  for(var a = 1; a <= maxEP-1; a++){
    var ideditpengumuman = "#edit-deskripsi-pengumuman" + a;
    ClassicEditor
    .create(document.querySelector(ideditpengumuman))
    .catch(error => {
        console.error(error)
    })
  }
}else if(navigation == "tugas"){
  ClassicEditor
  .create(document.querySelector('#input-deskripsi-tugas'))
  .catch(error => {
      console.error(error)
  })

  var maxtagEtugas = document.getElementById("maxtagedittugas");
  var maxET = maxtagEtugas.classList;

  for(var b = 1; b <= maxET-1; b++){
    var idedittugas = "#edit-deskripsi-tugas" + b; 
    ClassicEditor
    .create(document.querySelector(idedittugas))
    .catch(error => {
        console.error(error)
    })
  }

  $(document).ready(function () {
    for(var b = 1; b <= maxET-1; b++){
      var idlihattugas = "#tablelihattugas" + b;
      $(idlihattugas).DataTable(); 
    }
  });
}else if(navigation == "nilai"){

  var maxtagInilai = document.getElementById("maxtaginputnilai");
  var maxIN = maxtagInilai.classList;

  $(document).ready(function () {
    for(var c = 1; c <= maxIN-1; c++){
      var idinputnilai = "#tableinputnilai" + c; 
      $(idinputnilai).DataTable(); 
    }
  });
  
  var judulexcelnilai = document.getElementById("judultablenilai");
  var juduleN = judulexcelnilai.classList;

  document.getElementById('downloadallnilai').addEventListener('click', function() {
      var table2excel = new Table2Excel();
      table2excel.export(document.querySelectorAll("#tabelsemuanilai"), "Data Nilai " + juduleN);
  });

  $(document).ready(function () {
    $("#tabelsemuanilai").DataTable(); 
  });
}else if(navigation == "peserta"){
  $(document).ready(function () {
    $("#tablepeserta").DataTable(); 
  });
}else if(navigation == "setmodul"){

}else if(navigation == "syarat"){

}

  
