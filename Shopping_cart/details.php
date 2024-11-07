<?php
session_start();

$products = [
    1 => ['name' => 'AF1 Black', 'price' => 3000, 'image' => 'AF1_Black.png', 'description' => 'Stylish and comfortable AF1 Black shoes.'],
    2 => ['name' => 'Dunk Low', 'price' => 3500, 'image' => 'Dunk_Low.png', 'description' => 'Casual Dunk Low sneakers.'],
    3 => ['name' => 'Air Max 270', 'price' => 4500, 'image' => 'Air_Max270_2.png', 'description' => 'Trendy and cushioned Air Max 270 shoes.'],
    4 => ['name' => 'Air Max Black', 'price' => 6500, 'image' => 'Air_Max_Black.png', 'description' => 'Classic Air Max Black for a sleek look.'],
    5 => ['name' => 'Air Max White', 'price' => 6000, 'image' => 'Air_Max_White.png', 'description' => 'Clean and stylish Air Max White.'],
    6 => ['name' => 'Blazer Mid', 'price' => 4200, 'image' => 'Blazer_Mid.png', 'description' => 'Retro-inspired Blazer Mid shoes.'],
    7 => ['name' => 'AF1 White', 'price' => 5000, 'image' => 'AF1_White.png', 'description' => 'Timeless AF1 White sneakers.'],
  
    8 => ['name' => 'Zoom Vomero 5', 'price' => 5000, 'image' => 'Zoom_Vomero.png', 'description' => 'High-performance Zoom Vomero 5 running shoes.'],
];

// Get the product ID from the URL
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($productId < 1 || !isset($products[$productId])) {
    header('Location: index.php');
    exit();
}

$product = $products[$productId];

// Handle adding product to the cart
if (isset($_POST['quantity'])) {
    $quantity = intval($_POST['quantity']);
    $size = $_POST['size'];
    if ($quantity > 0 && $quantity <= 100) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $productId && $item['size'] == $size) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $productId,
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'size' => $size
            ];
        }
        $_SESSION['cart_quantity'] = array_sum(array_column($_SESSION['cart'], 'quantity'));

        header('Location: confirm.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> - Shoeniverse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        body {
            background-color: #f0e5d6; 
        }
        .product-container {
            display: flex;
            align-items: center;
        }
        .product-image {
            width: 300px; /* Fixed width for the image */
            height: auto;
            object-fit: cover;
            margin-right: 20px; /* Space between image and text */
        }
        .description {
            font-size: 1rem;
            margin-bottom: 20px;
        }
        .btn-confirm {
            background-color: black;
            color: white;
        }
        .btn-confirm:hover {
            background-color: darkgray;
            color: white;
        }
        .btn-cancel {
            background-color: red;
            color: white;
        }
        .btn-cancel:hover {
            background-color: darkred;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <span class="shop-logo"><i class="bi bi-cart-fill"></i></span>
                Shoeniverse
            </h2>
            <a href="cart.php" class="btn btn-primary">
                <i class="fas fa-shopping-cart"></i> Cart <span class="badge bg-light text-dark"><?php echo array_sum(array_column($_SESSION['cart'] ?? [], 'quantity')); ?></span>
            </a>
        </div>

        <div class="card">
            <div class="product-container">
                <img src="images/<?php echo $product['image']; ?>" class="product-image" alt="<?php echo $product['name']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $product['name']; ?> - ₱ <?php echo number_format($product['price'], 2); ?></h5>
                    <p class="description"><?php echo $product['description']; ?></p>
                    <form method="post" onsubmit="return confirmPurchase(event);">
                        <label for="size">Select Size:</label><br>
                        <?php foreach ([40, 41, 42, 43, 44, 45] as $sizeOption): ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="size" value="<?php echo $sizeOption; ?>" id="size<?php echo $sizeOption; ?>" required>
                                <label class="form-check-label" for="size<?php echo $sizeOption; ?>"><?php echo $sizeOption; ?></label>
                            </div>
                        <?php endforeach; ?>
                        <br><label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" class="form-control quantity" min="1" max="100" value="1" required>
                        <button type="submit" class="btn btn-confirm mt-3">Add to Cart</button>
                    </form>
                    <a href="shopping_cart.php" class="btn btn-cancel mt-2">Cancel</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmPurchase(event) {
            event.preventDefault();
            var quantity = document.querySelector('.quantity').value;
            quantity = parseInt(quantity, 10);

            if (quantity < 1 || quantity > 100) {
                alert('Minimum purchase is 1 and maximum is 100');
                return false;
            }

            event.target.submit();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
