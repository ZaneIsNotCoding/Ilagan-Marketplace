<?php 
session_start();
include 'db.php'; 

if (!isset($_SESSION['user_id'])) {
    header('Location: sign_in.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['save_btn'])) {
    // Define the $username from POST data
    $id = $user_id; // Assuming you have an ID field to identify the record for the user
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['pemail'];
    $number = $_POST['pnumber'];
    $brgy = $_POST['pflat'];
    $street = $_POST['pstreet'];
    $city = $_POST['pcity'];
    $province = $_POST['pcountry'];
    $zipcode = $_POST['pzipcode'];

    // Prepare the SQL update statement dynamically
    $updates = [];
    $params = [];
    $types = "";

    if (!empty($fname)) {
        $updates[] = "fname = ?";
        $params[] = $fname;
        $types .= "s";
    }
    if (!empty($lname)) {
        $updates[] = "lname = ?";
        $params[] = $lname;
        $types .= "s";
    }
    if (!empty($email)) {
        $updates[] = "email = ?";
        $params[] = $email;
        $types .= "s";
    }
    if (!empty($number)) {
        $updates[] = "contact = ?";
        $params[] = $number;
        $types .= "s";
    }
    if (!empty($brgy)) {
        $updates[] = "brgy = ?";
        $params[] = $brgy;
        $types .= "s";
    }
    if (!empty($street)) {
        $updates[] = "street = ?";
        $params[] = $street;
        $types .= "s";
    }
    if (!empty($city)) {
        $updates[] = "city = ?";
        $params[] = $city;
        $types .= "s";
    }
    if (!empty($province)) {
        $updates[] = "province = ?";
        $params[] = $province;
        $types .= "s";
    }
    if (!empty($zipcode)) {
        $updates[] = "zipcode = ?";
        $params[] = $zipcode;
        $types .= "s";
    }

    // If there are updates to be made, proceed with the SQL statement
    if (count($updates) > 0) {
        $sql = "UPDATE `form` SET " . implode(", ", $updates) . " WHERE user_id = ?";
        $params[] = $id;
        $types .= "i";

        // Prepare and bind
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);

        // Execute the statement
        if ($stmt->execute()) {
            echo "
            <div class='order-message-container'>
                <div class='message-container'>
                    <br><br>
                    <h3>New Address!</h3>
                    <div class='customer-details'>
                        <p>Your Name: <span>{$fname} {$lname}</span></p>
                        <p>Your Email: <span>{$email}</span></p>
                        <p>Your number: <span>{$number}</span></p>
                        <p>Your Barangay: <span>{$brgy}</span></p>
                        <p>Your Street: <span>{$street}</span></p>
                        <p>Your city: <span>{$city}</span></p>
                        <p>Your Country: <span>{$province}</span></p>
                        <p>Your Zipcode: <span>{$zipcode}</span></p>
                        <p>(*Go to Address*)</p>
                    </div>
                    <a href='profile.php' class='btn'>Continue</a>
                </div>
            </div>";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "No data provided to update.";
    }

    // Close the connection
    $conn->close();
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
        <form action="editAddress.php" method="post" class="add-product-form">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `form` WHERE user_id = '$user_id'");
            if(mysqli_num_rows($select_products) > 0){
                while($fetch_product = mysqli_fetch_assoc($select_products)){
            ?>
            <input type="hidden" id="id" name="id" value="<?php echo $user_id; ?>">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" value="<?php echo $fetch_product['fname'] ?? ''; ?>">
            <br>
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" value="<?php echo $fetch_product['lname'] ?? ''; ?>">
            <br>
            <label for="pemail">Email:</label>
            <input type="email" id="pemail" name="pemail" value="<?php echo $fetch_product['email'] ?? ''; ?>">
            <br>
            <label for="pnumber">Number:</label>
            <input type="number" id="pnumber" name="pnumber" value="<?php echo $fetch_product['contact'] ?? ''; ?>">
            <br>
            <label for="pflat">Barangay:</label>
            <input type="text" id="pflat" name="pflat" value="<?php echo $fetch_product['brgy'] ?? ''; ?>">
            <br>
            <label for="pstreet">Street:</label>
            <input type="text" id="pstreet" name="pstreet" value="<?php echo $fetch_product['street'] ?? ''; ?>">
            <br>
            <label for="pcity">City:</label>
            <input type="text" id="pcity" name="pcity" value="<?php echo $fetch_product['city'] ?? ''; ?>">
            <br>
            <label for="pcountry">Country:</label>
            <input type="text" id="pcountry" name="pcountry" value="<?php echo $fetch_product['province'] ?? ''; ?>">
            <br>
            <label for="pzipcode">Zipcode:</label>
            <input type="number" id="pzipcode" name="pzipcode" value="<?php echo $fetch_product['zipcode'] ?? ''; ?>">
            <br>
            <input type="submit" value="Update" name="save_btn">
            <?php
                }
            }
            ?>
        </form>
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
                <a href="#"><i class="
