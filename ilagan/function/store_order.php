<?php
session_start(); // Ensure session is started
include __DIR__ . '/../include/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: sign_in.php'); // Redirect to login page if not logged in
    exit();
}

// Process removal of an order
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM `ordered` WHERE id = '$remove_id'");
    header('Location: store_order.php');
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user id

?>

<!DOCTYPE html>
<html>
<head>
<title>User</title>
    <link rel="stylesheet" href="../css/display.css">
    <link rel="stylesheet" href="../css/collect.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .nav-tabs {
            display: flex;
            border-bottom: 1px solid #ddd;
            background:white;
            
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
            color: blue;
        }
        .nav-tabs a:visited {
            border-bottom: 2px solid red;
            color: red;
        }
    </style>
</head>
<body>

<header>
    <a href="collection.php"><img src="../image/imglogo.png" alt="" class="headlogo"></a>
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
                <button class="dropbtn"><a><i class="fa-solid fa-user"></i></i></a></button>
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
        <a href="store_order.php">All</a>
        <a href="store_order_pay.php">To pay</a>
        <a href="store_order_receive.php">To Recieve</a>
        <a href="store_order_completed.php">Completed</a>
    </div>
</header>

<div class="box-container">

    <?php
    // Select orders for the logged-in user
    $select_products = mysqli_query($conn, "SELECT * FROM `completed` WHERE user_id = '$user_id'");
    if (mysqli_num_rows($select_products) > 0) {
        while ($fetch_product = mysqli_fetch_assoc($select_products)) {
    ?>
        <form action="" method="post">
            <br>
            <div class="box">
                <div class="message-container">
                    <br>
                    <br>
                    <h2>Thank you for shopping!</h2>
                    <div class='order-detail'>
                    
                    </div>
                    <div class="customer-details">
                        <p>name: <span><?php echo $fetch_product['name']; ?></span></p>
                        <p>number: <span><?php echo $fetch_product['number']; ?></span></p>
                        <p>email: <span><?php echo $fetch_product['email']; ?></span></p>
                        <p>address: <span><?php echo $fetch_product['zipcode'] .', '. $fetch_product['flat'] . ', ' . $fetch_product['street'] . ', ' . $fetch_product['city'] . ', ' . $fetch_product['country']; ?></span></p>
                        <span class='total'>Total: ₱ <?php echo $fetch_product['totalprice']; ?></span>
                        <p>payment mode: <span><?php echo $fetch_product['method']; ?></span></p>
                        <p>(*pay when product arrives*)</p>
                    </div>
                    <a  class='btn'>Thank you for shopping!</a>
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

<br>
<br>
<br>
<br>
<div class="footer">
    <div class="contanier">
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
