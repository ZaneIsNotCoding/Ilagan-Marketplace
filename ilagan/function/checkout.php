<?php
session_start(); // Start the session
@include 'db.php';

if(isset($_GET['delete_all'])){
   // Make sure to sanitize your input
   $delete_id = mysqli_real_escape_string($conn, $_GET['delete_all']);
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = $delete_id ");
   header('location:cart.php');
}

if(isset($_POST['order_btn'])){
   // Sanitize input data to prevent SQL injection
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = mysqli_real_escape_string($conn, $_POST['number']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $flat = mysqli_real_escape_string($conn, $_POST['flat']);
   $street = mysqli_real_escape_string($conn, $_POST['street']);
   $city = mysqli_real_escape_string($conn, $_POST['city']);
   $country = mysqli_real_escape_string($conn, $_POST['country']);
   $pin_code = mysqli_real_escape_string($conn, $_POST['pin_code']);
   
   // Retrieve the user ID from session
   $user_id = $_SESSION['user_id']; // Replace 'user_id' with your actual session variable

   // Query to get cart items for the logged-in user
   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = $user_id");
   $price_total = 0;
   $product_name = []; // Initialize as an array

   if(mysqli_num_rows($cart_query) > 0){
      while($product_item = mysqli_fetch_assoc($cart_query)){
         $product_name[] = $product_item['name'] .' ('. $product_item['quantity'] .') ';
         $product_price = $product_item['price'] * $product_item['quantity'];
         $price_total += $product_price;
      }
   }

   $total_product = implode(', ', $product_name);

   // Insert order details into 'pay' table
   $detail_query = mysqli_query($conn, "INSERT INTO `pay` (user_id, name, number, email, method, flat, street, city, country, zipcode, price, totalprice) VALUES ('$user_id', '$name', '$number', '$email', '$method', '$flat', '$street', '$city', '$country', '$pin_code', '$total_product', '$price_total')") or die(mysqli_error($conn));

   if($detail_query){
      // Update the product quantities in the 'products' table
      $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = $user_id");
      while($cart_item = mysqli_fetch_assoc($cart_query)){
         $product_id = $cart_item['product_id']; // Assumes you have a product_id in the cart table
         $cart_quantity = $cart_item['quantity'];
         $update_product_quantity = mysqli_query($conn, "UPDATE `products` SET quantity = quantity - $cart_quantity WHERE product_id = $product_id") or die(mysqli_error($conn));
      }

      echo "
      <div class='order-message-container'>
      <div class='message-container'>
         <br>
         <br>
         <h3>Thank you for shopping!</h3>
         <div class='order-detail'>
            <span>".$total_product."</span>
            <span class='total'> Total: ₱".number_format($price_total, 2, '.', ',')."</span>
         </div>
         <div class='customer-details'>
            <p> Your name: <span>".$name."</span> </p>
            <p> Your number: <span>".$number."</span> </p>
            <p> Your email: <span>".$email."</span> </p>
            <p> Your address: <span>".$flat.", ".$street.", ".$city.", ".$country." - ".$pin_code."</span> </p>
            <p> Your payment mode: <span>".$method."</span> </p>
            <p>(*pay when product arrives*)</p>
         </div>
            <a href='cart.php?delete_all' class='delete-btn'> <i class='fas fa-trash'></i> Continue Shopping </a>
         </div>
      </div>
      ";
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

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/collect.css">

</head>
<body>

<header>
   <a href="collection.php"><img src="image/imglogo.png" alt="" class="headlogo"></a>
   <nav>
   <?php
   // Ensure you have the user_id to fetch the cart
   if(isset($_SESSION['user_id'])){
      $user_id = $_SESSION['user_id'];
      $select_rows = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = $user_id") or die('query failed');
      $row_count = mysqli_num_rows($select_rows);
   } else {
      $row_count = 0;
   }
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
</header>

<div class="container">
<section class="checkout-form" style="background:white;">
   <h1 class="heading">Complete Your Order</h1>
   <form action="" method="post">
      <div class="display-order">

        <?php
            if(isset($_SESSION['user_id'])){
               $user_id = $_SESSION['user_id'];
               $select_products = mysqli_query($conn, "SELECT * FROM `form` WHERE user_id = $user_id");
               if(mysqli_num_rows($select_products) > 0){
                  while($fetch_product = mysqli_fetch_assoc($select_products)){
         ?>

         <?php
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = $user_id");
            $total = 0;
            $grand_total = 0;
            if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
               $total_price = $fetch_cart['price'] * $fetch_cart['quantity'];
               $grand_total = $total += $total_price;
               ?>
               <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
               <?php
            }
            }else{
               echo "<div class='display-order'><span>Your cart is empty!</span></div>";
            }
         ?>
         <span class="grand-total">Grand Total: ₱<?= number_format($grand_total, 2, '.', ','); ?>/-</span>
      </div>
      <div class="flex">
         <div class="inputBox">
            <span>Your Name</span>
            <input type="text" placeholder="Enter your name" name="name" value="<?php echo $fetch_product['fname'] ?? ''; ?>" value="<?php echo $fetch_product['lname'] ?? ''; ?>" >
         </div>
         <div class="inputBox">
            <span>Contact</span>
            <input type="text" placeholder="number" name="number" required value="<?php echo $fetch_product['contact'] ?? ''; ?>">
         </div>
         <div class="inputBox">
            <span>Your Email</span>
            <input type="email" placeholder="email" name="email" value="<?php echo $fetch_product['email'] ?? ''; ?>">
         </div>
         <div class="inputBox">
            <span>Payment Method</span>
            <select name="method">
               <option value="cash on delivery" selected>Cash on Delivery</option>
               <option value="credit card">Credit Card</option>
               <option value="card">Credit Card</option>
               <option value="paypal">Paypal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Address Line 1</span>
            <input type="text" placeholder="Brgy" name="flat" required value="<?php echo $fetch_product['brgy'] ?? ''; ?>">
         </div>
         <div class="inputBox">
            <span>Street</span>
            <input type="text" placeholder="Street" name="street" required value="<?php echo $fetch_product['street'] ?? ''; ?>">
         </div>
         <div class="inputBox">
            <span>City</span>
            <input type="text" placeholder="City" name="city" required value="<?php echo $fetch_product['city'] ?? ''; ?>">
         </div>
         <div class="inputBox">
            <span>Province</span>
            <input type="text" placeholder="Province" name="country" required value="<?php echo $fetch_product['province'] ?? ''; ?>">
         </div>
         <div class="inputBox">
            <span>Zipcode</span>
            <input type="text" placeholder="e.g. 123456" name="pin_code" required value="<?php echo $fetch_product['zipcode'] ?? ''; ?>">
         </div>
      </div>
      <input type="submit" value="Order Now" name="order_btn" class="btn">
      </form>
   <?php
               }
            }
         }
         ?>
</section>
</div>

<br>

<div class="footer">
   <div class="contanier">
      <div class="row">
         <h3>Ilagan Marketplace</span></h3>
         <p>FOLLOW US</p>
         <div class="social-links">
            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
         </div>
      </div>

      <div class="row">
         <h3>COSTUMER SERVICE</h3>
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

<script src="js/script.js"></script>
</body>
</html>
