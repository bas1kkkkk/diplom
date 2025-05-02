document.addEventListener("DOMContentLoaded", () => {
    const selector = document.getElementById("currency-selector");
    const usdPrices = Array.from(document.querySelectorAll(".price-usd")).map(el => parseFloat(el.dataset.price));
    const priceElements = document.querySelectorAll(".price-usd");
    const symbolElements = document.querySelectorAll(".price-symbol");

    selector.addEventListener("change", async () => {
        const currency = selector.value;

        if (currency === "USD") {
            priceElements.forEach((el, i) => {
                el.textContent = usdPrices[i].toFixed(2);
            });
            symbolElements.forEach(el => {
                el.textContent = "$";
            });
            return;
        }

        const response = await fetch(`convert.php?to=${currency}`);
        const data = await response.json();

        if (data.rate) {
            priceElements.forEach((el, i) => {
                const converted = usdPrices[i] * data.rate;
                el.textContent = converted.toFixed(2);
            });

            symbolElements.forEach(el => {
                el.textContent = currency === "UAH" ? "₴" : "€";
            });
        }
    });
});
