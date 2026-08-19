$(document).ready(function(){

    // auto logout

    let sess_out = new Date();
        sess_out.setSeconds(sess_out.getSeconds() + (60 * 30));
        sess_out = new Date(sess_out);

    let int_out = setInterval(function(){
        let timeNow = new Date();
        if(timeNow > sess_out){
            window.location.assign("index.php?page=logout");
            clearInterval(int_out);          
        }
    },5000);

    // deteksi aktivitas

    $('body').on('click', function(){
        sess_out = new Date();
        sess_out.setSeconds(sess_out.getSeconds() + (60 * 30));
        sess_out = new Date(sess_out);
        console.log("Tambahan waktu sesi 60 detik || sesi berakhir pada " + sess_out);
    });
});