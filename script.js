document.addEventListener("DOMContentLoaded", function() {

    const form = document.getElementById("loginForm");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const passwordToggle = document.getElementById("passwordToggle");
    const loginBtn = document.querySelector(".login-btn");
    const btnText = document.querySelector(".btn-text");
    const btnLoader = document.querySelector(".btn-loader");
    const successMessage = document.getElementById("success-message");

    // Toggle password
    passwordToggle.addEventListener("click", function() {
        passwordInput.type = passwordInput.type === "password" ? "text" : "password";
    });

    // Submit form
    form.addEventListener("submit", function(event) {
        event.preventDefault();

        let email = emailInput.value.trim();
        let password = passwordInput.value.trim();

        // Validasi
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

        // Loading animation
        btnText.style.display = "none";
        btnLoader.style.display = "inline-block";
        loginBtn.disabled = true;

        setTimeout(function() {
            btnLoader.style.display = "none";
            successMessage.style.display = "block";
            form.style.display = "none";

            setTimeout(function() {
                window.location.href = "dashboard.html";
            }, 2000);

        }, 1500);
    });

    // Popup function
    function showPopup(message) {
        const popup = document.getElementById("errorPopup");
        const popupMessage = document.getElementById("popupMessage");

        popupMessage.textContent = message;
        popup.style.display = "flex";
    }

    document.getElementById("closePopup").addEventListener("click", function () {
        document.getElementById("errorPopup").style.display = "none";
    });

});