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

document.addEventListener('DOMContentLoaded', () => {
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');

    function changeSlide() {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
    }

    setInterval(changeSlide, 5000); // Cambia cada 5 segundos
});

