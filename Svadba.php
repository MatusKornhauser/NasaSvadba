<?php
// Tu môžeš spracovať POST, ak chceš (momentálne necháme prázdne)
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Svadba Mária a Matúš</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #fef9f4;
            color: #333;
            text-align: center;
            padding: 40px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h1 {
            color: #b85c38;
        }
        .rsvp-button {
            background-color: #b85c38;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Mária a Matúš</h1>
    <p>Srdečne vás pozývame na našu svadbu!</p>
    <p><strong>Dátum:</strong> 03. októbra 2026</p>
    <p><strong>Sobáš:</strong> Kostol Božského Srdca Ježišovho v Oravskej Polhore</p>
    <p><strong>Miesto:</strong> Oravská Polhora</p>
    <p><strong>Začiatok:</strong> 15:00</p>
    <h2>Potvrdenie účasti</h2>
    <p>Radi by sme vedeli, koľko z vás príde osláviť náš veľký deň po našom boku. Prosíme vás preto, aby ste nám dali
        vedieť, koľko osôb plánuje prísť, a zároveň uviedli ich celé mená (meno a priezvisko), aby sme sa mohli na
        každého pripraviť a nič nezabudnúť. Ďakujeme, že nám pomáhate pripraviť svadobný deň, na ktorý nikdy nezabudneme.</p>
    <form id="rsvp-form">
        <label for="count">Koľko osôb príde?</label><br>
        <input type="number" id="count" name="count" min="1" max="20" required><br><br>

        <div id="guests"></div>

        <button type="submit">Odoslať</button>
    </form>
    <!-- Potvrdenie -->
    <div id="confirmation" style="display:none; margin-top: 20px; padding: 15px; border: 2px solid #b85c38; background-color: #fde4db; border-radius: 8px; color: #b85c38;"></div>

    <script>
        document.getElementById('count').addEventListener('input', function () {
            const numberOfGuests = parseInt(this.value);
            const guestsDiv = document.getElementById('guests');
            guestsDiv.innerHTML = '';

            if (!isNaN(numberOfGuests) && numberOfGuests > 0 && numberOfGuests <= 20) {
                for (let i = 1; i <= numberOfGuests; i++) {
                    const label = document.createElement('label');
                    label.textContent = `Meno a priezvisko osoby ${i}:`;
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.name = `guest-${i}`;
                    input.required = true;

                    guestsDiv.appendChild(label);
                    guestsDiv.appendChild(document.createElement('br'));
                    guestsDiv.appendChild(input);
                    guestsDiv.appendChild(document.createElement('br'));
                    guestsDiv.appendChild(document.createElement('br'));
                }
            }
        });

        document.getElementById('rsvp-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            const data = {};

            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }

            // Poslať na Google Sheet (ponecháme fetch, nech je to stále funkčné)
            fetch('https://script.google.com/macros/s/AKfycbzwLLT2fW-W-6goNWGGzdIKfsn_iTI2WNibh5F4kIsSAfELNTD_ee8YPcy1m3Ig8Hda/exec', {
                method: 'POST',
                mode: 'no-cors',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(data).toString()
            });

            // Zobraziť potvrdenie
            let summary = `<strong>Ďakujeme za potvrdenie!</strong><br>`;
            summary += `Počet hostí: <strong>${formData.get("count")}</strong><br><ul>`;

            for (let [key, value] of formData.entries()) {
                if (key.startsWith("guest-")) {
                    summary += `<li>${value}</li>`;
                }
            }

            summary += `</ul>`;

            const confirmationDiv = document.getElementById('confirmation');
            confirmationDiv.innerHTML = summary;
            confirmationDiv.style.display = 'block';

            form.reset();
            document.getElementById('guests').innerHTML = '';
        });
    </script>

</div>
</body>
</html>
