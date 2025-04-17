document.addEventListener("DOMContentLoaded", function() {
    //PARTES FORMS
    var form = document.querySelector('form'); 
    var reg_but = document.getElementById("reg_button");

    //DEFAULTS
    document.getElementById("mensaje_psw").style.display = "none";
    document.getElementById("mensaje_curp").style.display = "none";
    
    //VARS CONTRASEÑA
    var in_psw = document.getElementById("psw");
    var length = document.getElementById("length");
    var mayusc = document.getElementById("mayusc");
    var minusc = document.getElementById("minusc");
    var especial = document.getElementById("especial");

    //VARS FORMS
    var nom = document.getElementById("name");
    var cel = document.getElementById("cel");
    var cl_curp = document.getElementById("curp");
    var mail = document.getElementById("email");

    // FORMULARIO BLOQUEO
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        let validador = true;

        //RESET CLAVES VALID
        [nom, cel, cl_curp, mail].forEach(input => {
            input.classList.remove('is-invalid');
        });

        //VALID CAMPOS
        if (nom.value.trim() === '') {
            nom.classList.add('is-invalid');
            validador = false;
        }

        if (cel.value.trim() === '') {
            cel.classList.add('is-invalid');
            validador = false;
        }

        if (cl_curp.value.trim() === '') {
            cl_curp.classList.add('is-invalid');
            validador = false;
        }

        if (mail.value.trim() === '') {
            mail.classList.add('is-invalid');
            validador = false;
        }

        //VALID PSW
        const psw_valid = validate_psw();
        if (!psw_valid) validador = false;

        //MANDAR FORMS
        if (validador) {
            form.submit();
        }
    });

    // Función de validación de contraseña
    function validate_psw() {
        let validador = true;
        const password = in_psw.value;

        // MINUSCULAS
        var minusculas = /[a-z]/g;
        if(password.match(minusculas)) {
            minusc.classList.remove("invalid");
            minusc.classList.add("valid");
        } else {
            minusc.classList.remove("valid");
            minusc.classList.add("invalid");
            validador = false;
        }

        // MAYUSCULAS
        var mayusculas = /[A-Z]/g;
        if(password.match(mayusculas)) {
            mayusc.classList.remove("invalid");
            mayusc.classList.add("valid");
        } else {
            mayusc.classList.remove("valid");
            mayusc.classList.add("invalid");
            validador = false;
        }

        // CARACTERES ESPECIALES
        var especiales = /[!@#$%^&*(),.?":{}|<>]/g;
        if(password.match(especiales)) {
            especial.classList.remove("invalid");
            especial.classList.add("valid");
        } else {
            especial.classList.add("invalid");
            especial.classList.remove("valid");
            validador = false;
        }

        // LONGITUD
        if(password.length >= 12) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.add("invalid");
            length.classList.remove("valid");
            validador = false;
        }
        
        reg_but.disabled = !validador;
        return validador;
    }

    //BLOQUE REQUERIMIENTOS
    in_psw.onfocus = function() {
        document.getElementById("mensaje_psw").style.display = "block";
    }

    in_psw.onblur = function() {
        document.getElementById("mensaje_psw").style.display = "none";
    }

    var in_curp = document.getElementById("curp");
    in_curp.onfocus = function () {
        document.getElementById("mensaje_curp").style.display = "block";
    }

    in_curp.onblur = function() {
        document.getElementById("mensaje_curp").style.display = "none";
    }

    in_psw.onkeyup = validate_psw;
});