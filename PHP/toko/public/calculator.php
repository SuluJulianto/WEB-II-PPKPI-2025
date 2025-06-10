<?php
// Set initial values for price and discount
$harga = 0;
$diskon = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Harga</title>
</head>

<body>
    <h1>Kalkulator Harga Barang Toko</h1>
    <div>
        <label id="labelharga" for="harga">Harga:</label>
        <input id="harga" type="number" value="<?= $harga ?>"/>
        <p>Harga: <span id="price"><?= $harga ?></span></p>
    </div>
    <div>
        <label for="diskon">Diskon (%):</label>
        <input id="diskon" type="number" value="<?= $diskon ?>"/>
    </div>
    <button id="btn_calculate">Hitung</button>
    <p>Total harga setelah diskon: Rp  <span id="total_price"><?= $harga - ($harga * $diskon / 100) ?></span></p>

    <script>
        const button = document.getElementById('btn_calculate');
        const harga = document.getElementById('harga');
        const diskon = document.getElementById('diskon');
        const total_price = document.getElementById('total_price');
        
        button.addEventListener('click', function() {
            // Calculate the new price after applying the discount
            const price = parseFloat(harga.value);
            const discount = parseFloat(diskon.value);
            
            if (!isNaN(price) && !isNaN(discount)) {
                const discountedPrice = price - (price * discount / 100);
                total_price.textContent = discountedPrice.toFixed(2); // Update the total price
            } else {
                total_price.textContent = "Invalid input!";
            }
        });
    </script>
</body>
</html>
