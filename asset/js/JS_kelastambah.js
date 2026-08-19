    $(document).ready(function () {
    $('#input-fullname-kelas').select2({
        placeholder: "Pilih Praktikum",
        allowClear: true
      });       
    $('#input-periode-kelas').select2({
        placeholder: "Pilih Periode",
        allowClear: true
      });
  });

  ClassicEditor
  .create(document.querySelector('#input-deskripsi-kelas'))
  .catch(error => {
      console.error(error)
  })