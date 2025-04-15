document.addEventListener("DOMContentLoaded", function() {
    var in_psw = document.getElementById("psw");
    var length = document.getElementById("length");
    var mayusc = document.getElementById("mayusc");
    var minusc = document.getElementById("minusc");
    var especial = document.getElementById("especial");

    in_psw.onfocus = function() {
        document.getElementById("mensaje").style.display = "block";
    }

    in_psw.onblur = function() {
        document.getElementById("mensaje").style.display = "none";
    }

    in_psw.onkeyup = function() {
        // MINUSCULAS
        var minusculas = /[a-z]/g;
        if(in_psw.value.match(minusculas)) {
            minusc.classList.remove("invalid");
            minusc.classList.add("valid");
        } else {
            minusc.classList.remove("valid");
            minusc.classList.add("invalid");
        }

        //MAYUSCULAS
        var mayusculas = /[A-Z]/g;
        if(in_psw.value.match(mayusculas)) {
            mayusc.classList.remove("invalid");
            mayusc.classList.add("valid");
        } else {
            mayusc.classList.remove("valid");
            mayusc.classList.add("invalid");
        }

        var especiales = /[!@#$%^&*(),.?":{}|<>]/g;
        if(in_psw.value.match(especiales)) {
            especial.classList.remove("invalid");
            especial.classList.add("valid");
        } else {
            especial.classList.add("invalid");
            especial.classList.remove("valid");
        }

        //LONGITUD
        if(in_psw.value.length >= 12) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.add("invalid");
            length.classList.remove("valid");
        }
    }

});
