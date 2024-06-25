const inputs = document.querySelectorAll('#formulario input');

const expresiones = {
	texto: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
	nombre: /^[a-zA-ZÀ-ÿ\s]{3,40}$/, // Letras y espacios, pueden llevar acentos.
	password: /^.{4,12}$/, // 4 a 12 digitos.
	correo: /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
    telefono: /^\d{8}$/, // 7 a 14 numeros.
    telefono1: /^\d{9}$/, // 7 a 14 numeros.
    precio: /^[0-9]+([.][0-9]+)?$/,
    numeros: /^[1-9]{0,20}$/,
    texto2: /^[a-zA-Z0-9\_\-]{5,500}$/, // Letras
   

}

const validarFormulario = (e) => {
    switch (e.target.name) {
        case "titulo":
            validarCampo(expresiones.nombre, e.target, 'titulo');
        break; 
        case "autor":
            validarCampo(expresiones.nombre, e.target, 'autor');
        break; 
        case "coautor":
            validarCampo(expresiones.nombre, e.target, 'coautor');
        break; 
        case "resumen":
            validarCampo(expresiones.texto2, e.target, 'resumen');
        break;
        // */-------------------------------------------------------------/
        case "nombres":
            validarCampo(expresiones.nombre, e.target, 'nombres');
        break; 
        case "nacionalidad":
            validarCampo(expresiones.nombre, e.target, 'nacionalidad');
        break; 
        // ---------------------------------------------------------------/
        case "nombre":
            validarCampo(expresiones.texto, e.target, 'nombre');
        break; 
        case "dni":
            validarCampo(expresiones.telefono, e.target, 'dni');
        break; 
        case "telefono":
            validarCampo(expresiones.telefono1, e.target, 'telefono');
        break; 
        // case "direccionCompleta":
        //     validarCampo(expresiones.correo, e.target, 'direccionCompleta');
        // break; 
        // case "nombres":
        //     validarCampo(expresiones.nombre, e.target, 'nombres');
        // break; 
        case "correo":
            validarCampo(expresiones.correo, e.target, 'correo');
        break; 
        
    }
}

const validarCampo = (expresion, input, campo) => {
    if (expresion.test(input.value)) {
        document.getElementById(`grupo__${campo}`).classList.remove('fg-incorrecto');
        document.getElementById(`grupo__${campo}`).classList.add('fg-correcto');
        // Eliminar icono
        document.querySelector(`#grupo__${campo} i`).classList.remove('fa-times-circle');
        document.querySelector(`#grupo__${campo} i`).classList.add('fa-check-circle');
        document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo');
    }else {
        document.getElementById(`grupo__${campo}`).classList.remove('fg-correcto');
        document.getElementById(`grupo__${campo}`).classList.add('fg-incorrecto');
        // Eliminar icono   
        document.querySelector(`#grupo__${campo} i`).classList.remove('fa-check-circle');
        document.querySelector(`#grupo__${campo} i`).classList.add('fa-times-circle');
        document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');

    }
}

inputs.forEach((input) => {
    input.addEventListener('keyup', validarFormulario);
    
});
// PROBAR alert("HOLA GUDY");