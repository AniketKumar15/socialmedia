document.addEventListener("DOMContentLoaded", () => {
    const toggle = document.getElementById("theme");
    const root = document.documentElement;

    // Load saved theme
    const savedTheme = localStorage.getItem("theme");

    if (savedTheme === "light") {
        root.classList.add("light");
        toggle.checked = true;
    }

    // Toggle theme
    toggle?.addEventListener("change", () => {
        if (toggle.checked) {
            root.classList.add("light");
            localStorage.setItem("theme", "light");
        } else {
            root.classList.remove("light");
            localStorage.setItem("theme", "dark");
        }
    });
});
