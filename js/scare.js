var amb = document.getElementById("ambience");
var freddy_jmp = document.getElementById("freddy-jmp");
var foxy_jmp = document.getElementById("foxy-jmp");
var bonnie_jmp = document.getElementById("bonnie-jmp");
var chica_jmp = document.getElementById("chica-jmp");
var jmp_time;

function fnaf_scare() {
    document.getElementById("load").style.display = "none";
    amb.pause();
    $('.mainBod').addClass('scare');
    scareVar = Math.floor(Math.random() * 4);
    if (scareVar == 0) {
        $('.mainBod').addClass('freddy');
        jmp_time = setTimeout(ref, 6000)
        freddy_jmp.play();
    } else if (scareVar == 1) {
        $('.mainBod').addClass('foxy');
        jmp_time = setTimeout(ref, 2500)
        foxy_jmp.play();
    } else if (scareVar == 2) {
        $('.mainBod').addClass('bonnie');
        jmp_time = setTimeout(ref, 5000)
        bonnie_jmp.play();
    } else if (scareVar == 3) {
        $('.mainBod').addClass('chica');
        jmp_time = setTimeout(ref, 2500)
        chica_jmp.play();
    }
}

function ref() {
    location.reload()
}

