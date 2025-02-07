const btnSingIn = document.getElementById("sign-in"),
    btnSingUp = document.getElementById("sign-up"),
    formRegister = document.querySelector(".register"),
    formLogin = document.querySelector(".login");

btnSingIn.addEventListener("click", e => {
    formRegister.classList.add("hide");
    formLogin.classList.remove("hide");
})

btnSingUp.addEventListener("click", e => {
    formLogin.classList.add("hide");
    formRegister.classList.remove("hide");
})

// Funcionalidad para mostrar/ocultar contraseña
document.addEventListener('DOMContentLoaded', () => {
    const togglePasswordElements = [
        { toggleId: 'togglePasswordRegister', inputId: 'passwordRegister' },
        { toggleId: 'togglePasswordLogin', inputId: 'passwordLogin' }
    ];

    togglePasswordElements.forEach(element => {
        const togglePassword = document.getElementById(element.toggleId);
        const passwordInput = document.getElementById(element.inputId);

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function () {
                // Alternar el atributo type
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Alternar las clases del ícono
                this.classList.toggle('bx-hide');
                this.classList.toggle('bx-show');
            });
        }
    });
});

// para empleados 
document.addEventListener("DOMContentLoaded", () => {
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("passwordInput");

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener("click", function () {
            // Cambiar el tipo de input entre password y text
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                this.classList.remove("bx-hide");
                this.classList.add("bx-show");
            } else {
                passwordInput.type = "password";
                this.classList.remove("bx-show");
                this.classList.add("bx-hide");
            }
        });
    } else {
        console.error("No se encontraron los elementos necesarios.");
    }
});
