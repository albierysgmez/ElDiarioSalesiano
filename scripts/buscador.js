document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("searchInput");
    const cards = document.querySelectorAll(".card");

    input.addEventListener("input", () => {
        const query = input.value.toLowerCase().trim();

        cards.forEach(card => {
            let titulo = card.querySelector("h3").textContent.toLowerCase();
            let descripcion = card.querySelector(".descripcion").textContent.toLowerCase();
            let tema = card.querySelector(".tema").textContent.toLowerCase();

            const match =
                titulo.includes(query) ||
                descripcion.includes(query) ||
                tema.includes(query) ||
                compararPalabras(titulo, query) ||
                compararPalabras(descripcion, query);

            card.style.display = match ? "flex" : "none";
        });
    });
});

// Mejora coincidencias
function compararPalabras(texto, busqueda) {
    if (busqueda.length < 3) return false;

    const palabras = texto.split(" ");
    for (let palabra of palabras) {
        if (similaridad(palabra, busqueda) > 0.55) return true;
    }
    return false;
}

function similaridad(a, b) {
    if (a.length < 2 || b.length < 2) return 0;

    const bigramas = str =>
        Array.from({length: str.length - 1}, (_, i) => str.slice(i, i + 2));

    const bigA = bigramas(a);
    const bigB = bigramas(b);

    let inter = bigA.filter(bg => bigB.includes(bg)).length;
    return (2 * inter) / (bigA.length + bigB.length);
}
