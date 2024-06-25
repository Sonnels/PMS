const inputs = document.querySelectorAll('#formulario input');

const expresiones = {
    nombre: /^[a-zA-ZÀ-ÿ\s\ ]{3,40}$/, // Letras y espacios, pueden llevar acentos.
    password: /^.{4,12}$/, // 4 a 12 digitos.
    correo: /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/,
    telefono: /^\d{1,14}$/, // 7 a 14 numeros.
    precio: /^[0-9]+([.][0-9]+)?$/,
    numeros: /^\d{1,15}$/,
    texto2: /^[a-zA-Z0-9\_\-\ ]{5,500}$/, // Letras
    texto: /^[a-zA-Z0-9-ZÀ-ÿ\_\-\ ]{4,40}$/, // Letras espacios acentos



}

const validarFormulario = (e) => {
    switch (e.target.name) {
        // ------consultorio
        case "nomConsul":
            validarCampo(expresiones.texto, e.target, 'nomConsul');

            break;
        case "nomConsuledit":
            validarCampo(expresiones.texto, e.target, 'nomConsuledit');

            break;
        case "nomEspecialidad":
            validarCampo(expresiones.texto, e.target, 'nomEspecialidad');

            break;
        case "nomEspecialidadedit":
            validarCampo(expresiones.texto, e.target, 'nomEspecialidadedit');

            break;
        case "desConsul":
            validarCampo(expresiones.nombre, e.target, 'desConsul');
            break;
        // ------Usuario-------------------------------------------------
        case "nombres":
            validarCampo(expresiones.texto, e.target, 'nombres');
            break;
        case "nombresedit":
            validarCampo(expresiones.texto, e.target, 'nombresedit');
            break; 
        case "numDocumento":
            validarCampo(expresiones.numeros, e.target, 'numDocumento');
            break;
        case "numDocumentoedit":
            validarCampo(expresiones.numeros, e.target, 'numDocumentoedit');
            break; 
         
        case "correo":
            validarCampo(expresiones.correo, e.target, 'email');
            break;
        case "emailedit":
            validarCampo(expresiones.correo, e.target, 'emailedit');
            break;
        //-----------paciente------------------------------------------------- 
        case "correo":
            validarCampo(expresiones.correo, e.target, 'correo');
            break;
        case "correoedit":
            validarCampo(expresiones.correo, e.target, 'correoedit');
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
    } else {
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

