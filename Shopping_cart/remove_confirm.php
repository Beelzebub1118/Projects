<?php
session_start();

// Initialize the cart if it's not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Function to find a product in the cart by ID (size removed)
function findProductInCart($productId) {
    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['id'] == $productId) {
            return ['product' => $item, 'index' => $index];
        }
    }
    return null; // Return null if product not found
}

// Check if a product is being removed from the cart via GET request (size removed)
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Find the product in the cart (size is not used)
    $productData = findProductInCart($productId);

    if ($productData) {
        $product = $productData['product'];
        $productIndex = $productData['index'];

        // Display confirmation page for product removal
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Confirm Removal - Shoeniverse</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <style>
                body {
                    background-color: #f0e5d6;
                }
                .product-container {
                    display: flex;
                    align-items: center;
                    margin-top: 50px;
                }
                .product-image {
                    width: 800; /* Increased width */
                    height: auto;
                    object-fit: cover;
                    margin-right: 30px; /* Increased space between image and text */
                }
                .product-details {
                    font-size: 1.5rem; /* Increased font size */
                    line-height: 1.6;
                }
                .product-details h3 {
                    font-size: 2rem; /* Larger title font */
                    margin-bottom: 15px;
                }
                .btn-danger {
                    font-size: 1.2rem; /* Bigger button text */
                }
                .btn-secondary {
                    font-size: 1.2rem; /* Bigger button text */
                }
            </style>
        </head>
        <body>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-2">
                        <img src="images/<?php echo str_replace(' ', '_', $product['name']); ?>.png" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid product-image">
                    </div>
                    <div class="col-md-6 product-details">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p><strong>Quantity:</strong> <?php echo htmlspecialchars($product['quantity']); ?></p>
                        <p><strong>Price:</strong> ₱ <?php echo number_format($product['price'], 2); ?></p>
                        <p><strong>Total:</strong> ₱ <?php echo number_format($product['price'] * $product['quantity'], 2); ?></p>
                        <form method="post" action="">
                            <input type="hidden" name="index" value="<?php echo $productIndex; ?>">
                            <button type="submit" name="confirm" class="btn btn-danger">Confirm Product Removal</button>
                            <a href="cart.php" class="btn btn-secondary ml-2">Cancel/Go Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Product not found in the cart.";
    }
} else {
    echo "Error: Invalid request. Product ID is missing.";
}

// Handle product removal confirmation when POST is received
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    if (isset($_POST['index']) && isset($_SESSION['cart'][$_POST['index']])) {
        $index = $_POST['index'];

        // Check if the index exists in the session before proceeding
        if (array_key_exists($index, $_SESSION['cart'])) {
            // Remove the product from the cart by using array_splice to remove the item at the given index
            unset($_SESSION['cart'][$index]); // Unset the item by index

            // Re-index the array after unsetting to maintain the integrity of the cart
            $_SESSION['cart'] = array_values($_SESSION['cart']);

            // Redirect back to the cart page
            header('Location: cart.php');
            exit();
        } else {
            echo "Invalid product selection. The item no longer exists in the cart.";
        }
    } else {
        echo "Invalid request. Please try again.";
    }
}
?>
