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