document.addEventListener("DOMContentLoaded", function () {
    const toggleButtons = document.querySelectorAll(".password-toggle");

    toggleButtons.forEach(button => {
        button.addEventListener("click", function () {
            const input = this.parentElement.querySelector("input");

            if (input) {
                if (input.type === "password") {
                    input.type = "text";
                    this.querySelector(".eye-icon").style.backgroundImage =
                        "url('https://cdn.jsdelivr.net/gh/tabler/tabler-icons/icons/outline/eye-off.svg')";
                } else {
                    input.type = "password";
                    this.querySelector(".eye-icon").style.backgroundImage =
                        "url('https://cdn.jsdelivr.net/gh/tabler/tabler-icons/icons/outline/eye.svg')";
                }
            }
        });
    });

    console.log("Auth System Ready - No Dashboard dependency.");
});