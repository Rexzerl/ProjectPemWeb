document.addEventListener("DOMContentLoaded", function () {
    // Hanya sisihkan fitur interaksi UI
    const toggleButtons = document.querySelectorAll(".password-toggle");
    toggleButtons.forEach(button => {
        button.addEventListener("click", function () {
            const input = this.parentElement.querySelector("input");
            if (input) {
                input.type = input.type === "password" ? "text" : "password";
            }
        });
    });

    console.log("Auth System Ready - No Dashboard dependency.");
});