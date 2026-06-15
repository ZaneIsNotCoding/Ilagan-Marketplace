<?php
session_start(); // Ensure session is started
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: sign_in.php'); // Redirect to login page if not logged in
    exit();
}

// Process delivery of an order
if (isset($_POST['deliver'])) {
    $delivery_id = $_POST['delivery_id'];
    
    // Get order details from the 'deliveryship' table
    $query = "SELECT * FROM `deliveryship` WHERE id = '$delivery_id'";
    $result = mysqli_query($conn, $query);
    $order = mysqli_fetch_assoc($result);

    if ($order) {
        // Insert order details into the 'completed' table
        $insert_query = "INSERT INTO `receive` (user_id, name, number, email, method, flat, street, city, country, zipcode, totalprice)
                         VALUES ('{$order['user_id']}', '{$order['name']}', '{$order['number']}', '{$order['email']}', 
                                 '{$order['method']}', '{$order['flat']}', '{$order['street']}', '{$order['city']}', 
                                 '{$order['country']}', '{$order['zipcode']}', '{$order['totalprice']}')";
        mysqli_query($conn, $insert_query);

        // Delete order from the 'deliveryship' table
        mysqli_query($conn, "DELETE FROM `deliveryship` WHERE id = '$delivery_id'");

        header('Location: admindeliveryship.php'); // Redirect to refresh the page
        exit();
    }
}

$user_id = $_SESSION['user_id']; // Get the logged-in user id
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/display.css">
    <link rel="stylesheet" href="css/collect.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .nav-tabs {
            display: flex;
            border-bottom: 1px solid #ddd;
            background: white;
        }
        .nav-tabs a {
            flex: 1;
            text-align: center;
            padding: 10px;
            text-decoration: none;
            color: black;
            border-bottom: 2px solid transparent;
        }
        .nav-tabs a:hover {
            border-bottom: 2px solid red;
            color: red;
        }
    </style>
</head>
<body>

<header>
    <a href="collection.php"><img src="image/imglogo.png" alt="" class="headlogo"></a>
    <nav>
        <?php
        $select_rows = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('Query failed');
        $row_count = mysqli_num_rows($select_rows);
        ?>
        <div class="logo-search">
            <a href="#" class="logo">Ilagan Market place</a>
            <div class="search-box">
                <input type="search" placeholder="Search Here...">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div class="icon">
                <a href="cart.php" class="cart"><i class="fa-solid fa-cart-shopping"></i><span><?php echo $row_count; ?></span></a>
            </div> 
            <div class="dropdown">
                <button class="dropbtn"><i class="fa-solid fa-user"></i></button>
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
    
    <div class="nav-tabs">
        <a href="admindelivery.php">Orders</a>
        <a href="admindeliveryship.php" class="active">To Be Shipped</a>
        <a href="admindeliverycomplete.php">Completed</a>
    </div>
</header>

<div class="box-container">

    <?php
    // Select orders to be shipped
    $select_products = mysqli_query($conn, "SELECT * FROM `deliveryship`");
    if (mysqli_num_rows($select_products) > 0) {
        while ($fetch_product = mysqli_fetch_assoc($select_products)) {
    ?>
        <form action="admindeliveryship.php" method="post">
            <br>
            <div class="box">
                <div class="message-container">
                    <br>
                    <br>
                    <h2>Ready for Delivery!</h2>
                    <div class='order-detail'></div>
                    <div class="customer-details">
                        <p>Name: <span><?php echo $fetch_product['name']; ?></span></p>
                        <p>Number: <span><?php echo $fetch_product['number']; ?></span></p>
                        <p>Email: <span><?php echo $fetch_product['email']; ?></span></p>
                        <p>Address: <span><?php echo $fetch_product['zipcode'] . ', ' . $fetch_product['flat'] . ', ' . $fetch_product['street'] . ', ' . $fetch_product['city'] . ', ' . $fetch_product['country']; ?></span></p>
                        <span class='total'>Total: ₱ <?php echo $fetch_product['totalprice']; ?></span>
                        <p>Payment Mode: <span><?php echo $fetch_product['method']; ?></span></p>
                        <p>(*pay when product arrives*)</p>
                    </div>
                    <input type="hidden" name="delivery_id" value="<?php echo $fetch_product['id']; ?>">
                    <button type="submit" name="deliver">Deliver</button>
                </div>
            </div>
        </form>
    <?php
        }
    } else {
        echo "<p>No orders found.</p>";
    }
    ?>

</div>

<br><br><br><br>
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

</body>
</html>
