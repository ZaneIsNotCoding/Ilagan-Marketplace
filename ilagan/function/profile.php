<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: sign_in.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM `form` WHERE user_id = '$remove_id'");
    header('Location: profile.php');
    exit;
}
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
   <link rel="stylesheet" href="css/profile.css">
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
            <a class="logo">Ilagan Market place</a>
            <div class="search-box">
               <input type="search" placeholder="Search Here...">
               <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <div class="icon">
                <a href="cart.php" class="cart"><i class="fa-solid fa-cart-shopping"><?php echo $row_count; ?> </i></a>
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
            <li></li>      
        </ul>
    </nav>
</header>

<br>

<div class="container">
    <div class="box-container">
        <?php
        // Query to fetch user profile based on user_id
        $stmt = $conn->prepare("SELECT * FROM `form` WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $fetch_product = $result->fetch_assoc();
        ?>
        <form action="" method="post">
            <div class="box">
                <h6 class="edit"><a href="profile_edit.php">Edit Profile</a></h6>
                <h1>My Profile</h1>
                <img src="uploadimage/<?php echo $fetch_product['image']; ?>" alt="Profile Image">
                <h4>Username: <?php echo $fetch_product['username']; ?></h4>
                <h4>Name: <?php echo $fetch_product['fname']; ?>  <?php echo $fetch_product['lname']; ?></h4>
                <h4>Email: <?php echo $fetch_product['email']; ?></h4>
                <h4>Number: <?php echo $fetch_product['contact']; ?></h4>
                <h4>Gender: <?php echo $fetch_product['gender']; ?></h4>
                <h4>Age: <?php echo $fetch_product['age']; ?></h4>
            </div>
        </form>
        <?php
        } else {
            echo "<p>No profile found for this user.</p>";
        }
        ?>
    </div>

    <div class="box-container">
        <?php
        // Query to fetch user address based on user_id
        $stmt = $conn->prepare("SELECT * FROM `form` WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $fetch_product = $result->fetch_assoc();
        ?>
        <form action="" method="post">
            <div class="box">
                <h6 class="edit" style="text-align: end;"><a href="editAddress.php">Edit Address</a></h6>
                <h1>My Address</h1>
                <h4>Name: <?php echo $fetch_product['fname']; ?>  <?php echo $fetch_product['lname']; ?></h4>
                <h4>Number: <?php echo $fetch_product['contact']; ?></h4>
                <h4>Barangay: <?php echo $fetch_product['brgy']; ?></h4>
                <h4>Street: <?php echo $fetch_product['street']; ?></h4>
                <h4>City: <?php echo $fetch_product['city']; ?></h4>
                <h4>Province: <?php echo $fetch_product['province']; ?></h4>
                <h4>Zip Code: <?php echo $fetch_product['zipcode']; ?></h4>
            </div>
        </form>
        <?php
        } else {
            echo "<p>No address found for this user.</p>";
        }
        ?>
    </div>
</div>

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

<!-- Custom JS File Link -->
<script src="js/script.js"></script>

</body>
</html>
