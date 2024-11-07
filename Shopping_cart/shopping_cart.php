<?php
session_start();

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // Store each product as an associative array
}

// Check if an item is added to the cart
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $productID = $_GET['id'];
    
    // Sample product data (could be moved to a separate file)
    $products = [
        1 => ['name' => 'AF1 Black', 'price' => 3000],
        2 => ['name' => 'Dunk Low', 'price' => 5000],
        3 => ['name' => 'Air Max 270', 'price' => 4500],
        4 => ['name' => 'Air Max Black', 'price' => 6500],
        5 => ['name' => 'Air Max White', 'price' => 6000],
        6 => ['name' => 'Blazer Mid', 'price' => 4200],
        7 => ['name' => 'Dunk Low', 'price' => 3500],
        8 => ['name' => 'Zoom Vomero 5', 'price' => 4000],
    ];

    // Ensure the product exists in the products array
    if (isset($products[$productID])) {
        // Add product to the cart, incrementing quantity if it exists
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $productID) {
                $item['quantity']++;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $productID,
                'name' => $products[$productID]['name'],
                'price' => $products[$productID]['price'],
                'quantity' => 1
            ];
        }
    }
    
}
?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Learn IT Easy Online Shop</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome and Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
        <!-- Google Material Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <style>
            body {
                background-color: #f0e5d6; /* A soft beige color for a stylish look */
            }
            /* Styles for product cards */
            .product-card {
                transition: transform 0.3s;
                overflow: hidden;
                position: relative;
            }
            .product-card:hover {
                transform: scale(1.05);
            }
            .product-image {
                width: 100%;
                height: 300px;
                object-fit: cover;
                transition: opacity 0.3s;
            }
            .product-image-hover {
                position: absolute;
                top: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                opacity: 0;
                transition: opacity 0.3s;
            }
            .product-card:hover .product-image-hover {
                opacity: 1;
            }
            .overlay {
                position: absolute;
                bottom: 0;
                width: 100%;
                background: rgba(0, 0, 0, 0.7);
                color: white;
                opacity: 0;
                transition: opacity 0.3s;
                display: flex;
                justify-content: space-between; /* Change to space-between for the two buttons */
                align-items: center;
                height: 60px;
                padding: 0 10px; /* Add some padding */
                cursor: pointer;
            }
            .product-card:hover .overlay {
                opacity: 1;
            }
            .add-to-cart-btn, .view-details-btn {
                color: white;
                text-decoration: none;
                padding: 8px 12px; /* Add some padding for the buttons */
                border-radius: 5px; /* Rounded corners */
            }
            .add-to-cart-btn:hover, .view-details-btn:hover {
                background-color: black;
                color: white;
            }
            .shop-logo {
                font-size: 1.5rem;
                margin-right: 10px;
            }
            .price-badge {
                background-color: #333;
                color: white;
                padding: 2px 6px;
                border-radius: 4px;
                font-size: 0.9rem;
                margin-left: 8px;
            }
        </style>
    </head>
    <body>
        <!-- Main container -->
        <div class="container mt-5">
            <!-- Header with Shop Name and Cart Button -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>
                    <span class="shop-logo"><i class="bi bi-cart-fill"></i></span>
                    Shoeniverse
                </h2>
                <a href="cart.php" class="btn btn-primary">
                    <i class="fas fa-shopping-cart"></i> Cart <<span class="badge bg-light text-dark"><?php echo array_sum(array_column($_SESSION['cart'], 'quantity')); ?></span>

                </a>
            </div>

            <!-- Products Grid -->
            <div class="row">
                <?php
                // Sample product data
                $products = [
                    ['id' => 1, 'name' => 'AF1 Black', 'price' => 3000, 'image' => 'AF1_Black.png', 'hover_image' => 'AF1_Black_2.png'],
                    ['id' => 2, 'name' => 'Dunk Low', 'price' => 3500, 'image' => 'Dunk_Low.png', 'hover_image' => 'Dunk_Low_2.png'],
                    ['id' => 3, 'name' => 'Air Max 270', 'price' => 4500, 'image' => 'Air_Max270_2.png', 'hover_image' => 'Air_Max_270.png'],
                    ['id' => 4, 'name' => 'Air Max Black', 'price' => 6500, 'image' => 'Air_Max_Black.png', 'hover_image' => 'Air_Max_Black_2.png'],
                    ['id' => 5, 'name' => 'Air Max White', 'price' => 6000, 'image' => 'Air_Max_White.png', 'hover_image' => 'Air_Max_White_2.png'],
                    ['id' => 6, 'name' => 'Blazer Mid', 'price' => 4200, 'image' => 'Blazer_Mid.png', 'hover_image' => 'Blazer_Mid_2.png'],
                    ['id' => 7, 'name' => 'AF1 White', 'price' => 5000, 'image' => 'AF1_White.png', 'hover_image' => 'AF1_White_2.png'],
                  
                    ['id' => 8, 'name' => 'Zoom Vomero', 'price' => 4000, 'image' => 'Zoom_Vomero.png', 'hover_image' => 'Zoom_Vomero_2.png'],
                ];

                foreach ($products as $product) {
                    echo '
                    <div class="col-md-3 mb-4">
                        <div class="card product-card position-relative">
                            <!-- Main product image -->
                            <a href="details.php?id=' . $product['id'] . '">
                                <img src="images/' . $product['image'] . '" class="product-image" alt="' . $product['name'] . '">
                            </a>
                            <!-- Hover product image -->
                            <img src="images/' . $product['hover_image'] . '" class="product-image-hover" alt="' . $product['name'] . '">
                            <!-- Overlay for Add to Cart -->
                            <div class="overlay">
                                <a href="shopping_cart.php?action=add&id=' . $product['id'] . '" class="add-to-cart-btn">Add to Cart</a>
                                <a href="details.php?id=' . $product['id'] . '" class="view-details-btn">View Details</a>
                            </div>
                            <!-- Product details -->
                            <div class="card-body text-center">
                                <h5 class="card-title">' . $product['name'] . '
                                    <span class="price-badge">₱ ' . number_format($product['price'], 2) . '</span>
                                </h5>
                            </div>
                        </div>
                    </div>
                    ';
                }
                ?>
            </div>
        </div>

        <!-- Bootstrap JavaScript and dependencies -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>