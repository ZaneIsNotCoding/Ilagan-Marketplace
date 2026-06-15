<?php
session_start();
@include __DIR__ . '/../include/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: sign_in.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['update_update_btn'])){
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");
   header('location:cart.php');
   exit;
}

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'");
   header('location:cart.php');
   exit;
}

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart`");
   header('location:cart.php');
   exit;
}

// Function to check if any product has 0 stock left
function anyProductOutOfStock($conn) {
   $result = mysqli_query($conn, "SELECT * FROM `cart` WHERE pquantity <= 0");
   return mysqli_num_rows($result) > 0;
}

$select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
$grand_total = 0;
$product_out_of_stock = anyProductOutOfStock($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shopping Cart</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="../css/style.css">
   <link rel="stylesheet" href="../css/collect.css">
</head>
<body>

<header>
   <a href="collection.php"><img src="../image/imglogo.png" alt="" class="headlogo"></a>
   <nav>    
      <?php
      $select_rows = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      $row_count = mysqli_num_rows($select_rows);
      ?>
      <div class="logo-search">
         <a href="#" class="logo">Ilagan Market place</a>
         <div class="search-box">
            <input type="search" placeholder="Search Here...">
            <i class="fa-solid fa-magnifying-glass"></i>
         </div>
         <div class="icon">
            <a href="cart.php" class="cart"><i class="fa-solid fa-cart-shopping"></i><span><?php echo $row_count; ?></span> </a>
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
</header>

<div class="container">
   <section class="shopping-cart">
      <h1 class="heading">Shopping Cart</h1>
      <table>
         <thead>
            <tr>
               <th>Image</th>
               <th>Name</th>
               <th>Price</th>
               <th>Product Left</th>
               <th>Quantity</th>
               <th>Total Price</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php 
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
            $grand_total = 0;
            if(mysqli_num_rows($select_cart) > 0){
               while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            ?>
            <tr>
               <td><img src="../uploadimage/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
               <td><?php echo $fetch_cart['name']; ?></td>
               <td>₱<?php echo number_format($fetch_cart['price']); ?>/-</td>
               <td><?php echo number_format($fetch_cart['pquantity']); ?></td>
               <td>
                  <form action="" method="post">
                     <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                     <input type="number" name="update_quantity" min="1" value="<?php echo $fetch_cart['quantity']; ?>">
                     <input type="submit" value="Update" name="update_update_btn">
                  </form>   
               </td>
               <td>₱<?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</td>
               <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('Remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> Remove</a></td>
            </tr>
            <?php
               $grand_total += $sub_total;  
               }
            }
            ?>
            <tr class="table-bottom">
               <td><a href="collection.php" class="option-btn" style="margin-top: 0;">Continue Shopping</a></td>
               <td></td>
               <td colspan="3">Grand Total</td>
               <td>₱<?php echo $grand_total; ?>/-</td>
               <td><a href="cart.php?delete_all" onclick="return confirm('Are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> Delete All </a></td>
            </tr>
         </tbody>
      </table>
      <div class="checkout-btn">
         <?php if (!$product_out_of_stock): ?>
            <a href="checkout.php" class="btn">Checkout</a>
         <?php else: ?>
            <span class="btn disabled">No Stock Left</span>
         <?php endif; ?>
      </div>
   </section>
</div>

<br>

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

<!-- Custom JS File Link -->
<script src="../js/script.js"> document.querySelectorAll('.qty-btn-plus, .qty-btn-minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.input-qty');
            let value = parseInt(input.value);
            if (this.classList.contains('qty-btn-plus')) {
                input.value = value + 1;
            } else if (this.classList.contains('qty-btn-minus') && value > 1) {
                input.value = value - 1;
            }
        });
    });</script>

</body>
</html>
