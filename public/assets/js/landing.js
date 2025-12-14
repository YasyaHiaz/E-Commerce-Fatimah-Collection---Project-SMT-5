const container = document.querySelector(".landing-container");

// Floating effect (gerak halus saat mouse move)
document.addEventListener("mousemove", (e) => {
    const x = (window.innerWidth / 2 - e.clientX) / 50;
    const y = (window.innerHeight / 2 - e.clientY) / 50;

    container.style.transform = `translate(${x}px, ${y}px) scale(1.01)`;
});

// Load animation
window.addEventListener("load", () => {
    container.style.opacity = "1";
});
