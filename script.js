document.addEventListener("DOMContentLoaded", function () {

    // ===============================
    // TOGGLE PASSWORD (SEMUA BUTTON)
    // ===============================
    const toggleButtons = document.querySelectorAll(".password-toggle");

    toggleButtons.forEach(button => {
        button.addEventListener("click", function () {
            const input = this.parentElement.querySelector("input");
            if (input) {
                input.type = input.type === "password" ? "text" : "password";
            }
        });
    });

    // ===============================
    // SIGN IN FORM
    // ===============================
    const loginForm = document.getElementById("loginForm");

    if (loginForm) {
        const emailInput = document.getElementById("email");
        const passwordInput = document.getElementById("password");
        const loginBtn = document.querySelector(".login-btn");
        const btnText = loginBtn.querySelector(".btn-text");
        const btnLoader = loginBtn.querySelector(".btn-loader");
        const successMessage = document.getElementById("success-message");

        loginForm.addEventListener("submit", function (event) {
            event.preventDefault();

            let email = emailInput.value.trim();
            let password = passwordInput.value.trim();

            if (email === "") {
                showPopup("Email tidak boleh kosong!");
                return;
            }

            if (!email.includes("@")) {
                showPopup("Format email tidak valid!");
                return;
            }

            if (password === "") {
                showPopup("Password tidak boleh kosong!");
                return;
            }

            if (password.length < 6) {
                showPopup("Password harus minimal 6 karakter.");
                return;
            }

            // Loading
            btnText.style.display = "none";
            btnLoader.style.display = "inline-block";
            loginBtn.disabled = true;

            setTimeout(function () {
                btnLoader.style.display = "none";
                successMessage.style.display = "block";
                loginForm.style.display = "none";

                setTimeout(function () {
                    window.location.href = "dashboard.html";
                }, 2000);

            }, 1500);
        });
    }

    // ===============================
    // SIGN UP FORM
    // ===============================
    const signupForm = document.getElementById("signupForm");

    if (signupForm) {
        const nameInput = document.getElementById("name");
        const emailInput = document.getElementById("email");
        const passwordInput = document.getElementById("password");
        const repeatPasswordInput = document.getElementById("repeat-password");

        const signupBtn = document.querySelector(".signup-btn");
        const btnText = signupBtn.querySelector(".btn-text");
        const btnLoader = signupBtn.querySelector(".btn-loader");
        const successMessage = document.getElementById("success-message");

        signupForm.addEventListener("submit", function (event) {
            event.preventDefault();

            let name = nameInput.value.trim();
            let email = emailInput.value.trim();
            let password = passwordInput.value.trim();
            let repeatPassword = repeatPasswordInput.value.trim();

            if (name === "") {
                showPopup("Nama tidak boleh kosong!");
                return;
            }

            if (!email.includes("@")) {
                showPopup("Format email tidak valid!");
                return;
            }

            if (password.length < 6) {
                showPopup("Password minimal 6 karakter!");
                return;
            }

            if (password !== repeatPassword) {
                showPopup("Password tidak sama!");
                return;
            }

            // Loading
            btnText.style.display = "none";
            btnLoader.style.display = "inline-block";
            signupBtn.disabled = true;

            setTimeout(function () {
                btnLoader.style.display = "none";
                successMessage.style.display = "block";
                signupForm.style.display = "none";

                setTimeout(function () {
                    window.location.href = "dashboard.html";
                }, 2000);

            }, 1500);
        });
    }

    // ===============================
    // POPUP FUNCTION
    // ===============================
    function showPopup(message) {
        const popup = document.getElementById("errorPopup");
        const popupMessage = document.getElementById("popupMessage");

        if (popup && popupMessage) {
            popupMessage.textContent = message;
            popup.style.display = "flex";
        }
    }

    const closePopup = document.getElementById("closePopup");
    if (closePopup) {
        closePopup.addEventListener("click", function () {
            document.getElementById("errorPopup").style.display = "none";
        });
    }

});