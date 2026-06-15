<?php
session_start();
require __DIR__ . '/../include/db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: sign_in.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];

    // Check if the product exists
    $stmt = $conn->prepare("SELECT * FROM `products` WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Check if the product is already in the user's cart
        $stmt = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $result_cart = $stmt->get_result();

        if ($result_cart->num_rows > 0) {
            $message = 'Product already added to cart';
        } else {
            // Insert product into cart
            $stmt = $conn->prepare("INSERT INTO `cart` (user_id, product_id, name, description, price, pquantity, image, quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iisssiss", $user_id, $product_id, $product['name'], $product['description'], $product['price'], $product['quantity'], $product['image'], $product_quantity);
            
            $product_quantity = 1; // Default quantity

            if ($stmt->execute()) {
                $message = 'Product added to cart successfully';
            } else {
                $message = 'Failed to add product to cart';
            }
        }
    } else {
        $message = 'Product does not exist';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/collect.css">
</head>
<body>

<header>
    <img src="../image/imglogo.png" alt="" class="headlogo">
    <nav>
        <?php
        $select_rows = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('Query failed');
        $row_count = mysqli_num_rows($select_rows);
        ?>
        <div class="logo-search">
            <a href="#" class="logo">Ilagan Marketplace</a>
            <div class="search-box">
                <input type="search" placeholder="Search Here...">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <div class="icon">
                <a href="cart.php" class="cart"><i class="fa-solid fa-cart-shopping"></i><span><?php echo $row_count; ?></span></a>
            </div>

            <div class="dropdown">
                <button class="dropbtn"><a><i class="fa-solid fa-user"></i></a></button>
                <div class="dropdown-content">
                    <a href="profile.php">My Account</a>
                    <a href="store_order.php">My Purchase</a>
                    <a href="sign_in.php">Logout</a>
                </div>
            </div>
        </div>
        <ul>
            <li><a href="#"></a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <section class="products">
        <h1 class="heading">Latest Products</h1>
        <div class="box-container">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`");
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_products)) {
            ?>
            <form action="" method="post">
                <div class="box">
                    <img src="../uploadimage/<?php echo $fetch_product['image']; ?>" alt="">
                    <h3><?php echo $fetch_product['name']; ?></h3>
                    <h4><?php echo $fetch_product['description']; ?></h4>
                    <div class="stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-regular fa-star-half-stroke"></i>
                    </div>
                    <h4><?php echo $fetch_product['quantity']; ?> left</h4>
                    <div class="price">₱<?php echo $fetch_product['price']; ?></div>

                    <input type="hidden" name="product_id" value="<?php echo $fetch_product['product_id']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                    <input type="hidden" name="product_description" value="<?php echo $fetch_product['description']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                    <input type="hidden" name="product_pquantity" value="<?php echo $fetch_product['quantity']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                    <input type="submit" class="btn" value="Add to Cart" name="add_to_cart">
                </div>
            </form>
            <?php
                }
            }
            ?>
        </div>
    </section>
</div>

<div class="footer">
    <div class="container">
        <div class="row">
            <h3>Ilagan Marketplace</h3>
            <p>FOLLOW US</p>
            <div class="social-links">
                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
            </div>
        </div>

        <div class="row">
            <h3>CUSTOMER SERVICE</h3>
            <ul>
                <li><a href="#">Help Center</a></li>
                <li><a href="#">Payment Method</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>

        <div class="row">
            <h3>ABOUT Ilagan Marketplace</h3>
            <ul>
                <li>About us</li>
                <li>Ilagan Marketplace Policy</li>
            </ul>
        </div>
    </div>
</div>

<!-- custom js file link -->
<script src="../js/script.js"></script>

</body>
</html>
