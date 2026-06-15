<?php 
session_start();
include 'db.php'; 

if (!isset($_SESSION['user_id'])) {
    header('Location: sign_in.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$message = array(); // Initialize an array for messages

if(isset($_POST['save_btn'])){
    // Sanitize and get the POST data
    $username = mysqli_real_escape_string($conn, $_POST['pusername']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['pemail']);
    $number = mysqli_real_escape_string($conn, $_POST['pnumber']);
    $gender = mysqli_real_escape_string($conn, $_POST['pgender']);
    $age = mysqli_real_escape_string($conn, $_POST['page']);
    $p_image = $_FILES['pimage']['name'];
    $p_image_tmp_name = $_FILES['pimage']['tmp_name'];
    $p_image_folder = 'uploadimage/'.$p_image;

    // Upload and update data
    $update_query = "UPDATE `form` SET username = '$username', fname = '$fname', lname = '$lname', email = '$email', contact = '$number', gender = '$gender', age = '$age'";
    
    // Check if there is a new image
    if (!empty($p_image)) {
        $update_query .= ", image = '$p_image'";
        move_uploaded_file($p_image_tmp_name, $p_image_folder);
    }

    $update_query .= " WHERE user_id = '$user_id'";

    // Execute query
    $insert_query = mysqli_query($conn, $update_query);

    if($insert_query){
       $message[] = 'Save successfully';
    } else {
       $message[] = 'Could not save profile';
    }
}

// Fetch user data
$select_products = mysqli_query($conn, "SELECT * FROM `form` WHERE user_id = '$user_id'");
$fetch_product = mysqli_fetch_assoc($select_products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/edit.css">
</head>
<body>

<header>
    <a href="collection.php"><img src="image/imglogo.png" alt="" class="headlogo"></a>
    <nav>    
        <?php
        $select_rows = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
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
    <section class="checkout-form">
        <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
            <h6 class="edit"><a href="profile.php">My Profile</a></h6>
            <h3>Profile</h3>
            <input type="file" name="pimage" accept="image/png, image/jpg, image/jpeg" class="box" >
            <input type="text" name="pusername" placeholder="Username" class="box" value="<?php echo $fetch_product['username'] ?? ''; ?>">
            <input type="text" name="fname" placeholder="First Name" class="box" value="<?php echo $fetch_product['fname'] ?? ''; ?>">
            <input type="text" name="lname" placeholder="Last Name" class="box" value="<?php echo $fetch_product['lname'] ?? ''; ?>">
            <input type="email" name="pemail" placeholder="Email" class="box" value="<?php echo $fetch_product['email'] ?? ''; ?>">
            <input type="number" name="pnumber" placeholder="Phone Number" class="box" value="<?php echo $fetch_product['contact'] ?? ''; ?>">
            <input type="date" name="page" placeholder="Birthday" class="box" value="<?php echo $fetch_product['age'] ?? ''; ?>">
            <div class="box">
                <span>Gender</span>
                <select name="pgender">
                    <option <?php if(isset($fetch_product['gender']) && $fetch_product['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                    <option <?php if(isset($fetch_product['gender']) && $fetch_product['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                    <option <?php if(isset($fetch_product['gender']) && $fetch_product['gender'] == 'Unicorn') echo 'selected'; ?>>Unicorn</option>
                </select>
            </div>
            <input type="submit" value="Update" name="save_btn" class="btn">
        </form>

        <!-- Display Messages -->
        <?php foreach ($message as $msg): ?>
            <div class="order-message-container">
                <div class="message-container">
                    <br><br>
                    <h3>Profile!</h3>
                    <div class="customer-details">
                        <p>Your username: <span><?php echo $fetch_product['username'] ?? ''; ?></span></p>
                        <p>Your name: <span><?php echo $fetch_product['fname'] ?? ''; ?> <?php echo $fetch_product['lname'] ?? ''; ?></span></p>
                        <p>Your number: <span><?php echo $fetch_product['contact'] ?? ''; ?></span></p>
                        <p>Your email: <span><?php echo $fetch_product['email'] ?? ''; ?></span></p>
                        <p>Your gender: <span><?php echo $fetch_product['gender'] ?? ''; ?></span></p>
                        <p>Your age: <span><?php echo $fetch_product['age'] ?? ''; ?></span></p>
                        <p>(*Go to profile*)</p>
                    </div>
                    <a href='profile.php' class='btn'>Continue</a>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</div>

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

<!-- Custom JS File Link -->
<script src="js/script.js"></script>
</body>
</html>
