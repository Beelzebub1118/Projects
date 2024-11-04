<!DOCTYPE html>
<html>
<head>
    <title>Vendo Machine</title>
</head>
<body>
    <h1>Vendo Machine</h1>
    
    <form method="POST" action="">
        <fieldset>
            <legend>Products:</legend>
            <label><input type="checkbox" name="products[]" value="Coke-15"> Coke - ₱15</label><br>
            <label><input type="checkbox" name="products[]" value="Sprite-20"> Sprite - ₱20</label><br>
            <label><input type="checkbox" name="products[]" value="Royal-20"> Royal - ₱20</label><br>
            <label><input type="checkbox" name="products[]" value="Pepsi-15"> Pepsi - ₱15</label><br>
            <label><input type="checkbox" name="products[]" value="Mountain Dew-20"> Mountain Dew - ₱20</label><br>
        </fieldset>
        
        <fieldset>
            <legend>Options:</legend>
            <label for="size">Size:</label>
            <select name="size" id="size">
                <option value="Regular">Regular</option>
                <option value="Up-Size">Up-Size (+₱20)</option>
                <option value="Jumbo">Jumbo (+₱15)</option>
            </select>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" min="1" value="1">
            <button type="submit" name="checkout">Check Out</button>
        </fieldset>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
        $products = $_POST['products'] ?? [];
        $size = $_POST['size'] ?? 'Regular';
        $quantity = intval($_POST['quantity'] ?? 1);

        $totalAmount = 0;
        $totalItems = 0;

        echo "<h2>Purchase Summary:</h2><ul>";

        foreach ($products as $product) {
            [$name, $basePrice] = explode('-', $product);
            $basePrice = (int)$basePrice;

            switch ($size) {
                case 'Up-Size':
                    $price = $basePrice + 20;
                    break;
                case 'Jumbo':
                    $price = $basePrice + 15;
                    break;
                default:
                    $price = $basePrice;
            }

            $itemTotal = $price * $quantity;
            $totalAmount += $itemTotal;
            $totalItems += $quantity;

            echo "<li>$quantity pieces of $size $name amounting to ₱$itemTotal</li>";
        }

        echo "</ul>";
        echo "<p>Total Number of Items: $totalItems</p>";
        echo "<p>Total Amount: ₱$totalAmount</p>";
    }
    ?>
</body>
</html>