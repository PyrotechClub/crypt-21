
const authRoot = firebase.auth();
const btnRegis = document.getElementById('submit');
const emailRegis = document.getElementById('username');
const passRegis = document.getElementById('password');

$('#submitb').on('click', function(event){

    event.preventDefault();
    
    const mail = $('#username').val() + "@cryptatrix.com";
    const pass = $('#password').val();
    const promise = authRoot.createUserWithEmailAndPassword(mail, pass);
    promise.then(function (){
        $('form').submit();
    }).catch(function (e) {
        console.log(e);
        window.location.replace("/register");
    })

})

function refreshCaptcha(){
    var img = document.images['captchaimg'];
    img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}