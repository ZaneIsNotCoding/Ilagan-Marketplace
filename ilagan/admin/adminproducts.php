<?php

@include __DIR__ . '/../include/db.php';

if(isset($_POST['add_product'])){
   $p_name = $_POST['p_name'];
   $p_description = $_POST['p_description'];
   $p_price = $_POST['p_price'];
   $p_quantity = $_POST['p_quantity'];
   $p_image = $_FILES['p_image']['name'];
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_image_folder = __DIR__ . '/../uploadimage/'.$p_image;

   $insert_query = mysqli_query($conn, "INSERT INTO `products`(name, description,price,quantity, image) VALUES('$p_name',  '$p_description', '$p_price','$p_quantity',  '$p_image')") or die('query failed');

   if($insert_query){
      move_uploaded_file($p_image_tmp_name, $p_image_folder);
      $message[] = 'product add succesfully';
   }else{
      $message[] = 'could not add the product';
   }
};

//update

if(isset($_POST['add_product'])){
    $p_name = $_POST['p_name'];
    $p_description = $_POST['p_description'];
    $p_price = $_POST['p_price'];
    $p_image = $_FILES['p_image']['name'];
    $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
    $p_image_folder = __DIR__ . '/../uploadimage/'.$p_image;
 
    $insert_query = mysqli_query($conn, "INSERT INTO `products`(name, description,price, image) VALUES('$p_name',  '$p_description', '$p_price', '$p_image')") or die('query failed');
 
    if($insert_query){
       move_uploaded_file($p_image_tmp_name, $p_image_folder);
       $message[] = 'product add succesfully';
    }else{
       $message[] = 'could not add the product';
    }
 };
 
 if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_query = mysqli_query($conn, "DELETE FROM `products` WHERE id = $delete_id ") or die('query failed');
    if($delete_query){
       header('location:admin.php');
       $message[] = 'product has been deleted';
    }else{
       header('location:admin.php');
       $message[] = 'product could not be deleted';
    };
 };
 
 if(isset($_POST['update_product'])){
    $update_p_id = $_POST['update_p_id'];
    $update_p_name = $_POST['update_p_name'];
    $update_p_description = $_POST['update_p_description'];
    $update_p_price = $_POST['update_p_price'];
    $update_p_image = $_FILES['update_p_image']['name'];
    $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
    $update_p_image_folder = __DIR__ . '/../uploadimage/'.$update_p_image;
 
    $update_query = mysqli_query($conn, "UPDATE `products` SET name = '$update_p_name', description = ' $update_p_description', price = '$update_p_price', image = '$update_p_image' WHERE id = '$update_p_id'");
 
    if($update_query){
       move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
       $message[] = 'product updated succesfully';
       header('location:admin.php');
    }else{
       $message[] = 'product could not be updated';
       header('location:admin.php');
    }
 
 }

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Ilagan Souviner</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="../css/collect.css">
</head>
<body>
 

<header>


    <a href="collection.php"><img src="../image/imglogo.png" alt="" class="headlogo"></a>

    <nav>    
         <?php
     
         $select_rows = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
         $row_count = mysqli_num_rows($select_rows);

         ?>
     <div class="logo-search">
     
     
         <a href="#" class="logo">Ilagan Market place</span></a>
        


         <div class="dropdown">
         <button class="dropbtn"><a><i class="fa-solid fa-user"></i></i></a></button>
         <div class="dropdown-content">
             <a href="admin.php">Admin</a>
             <a href="adminproducts.php">Producst</a>
             <a href="adminorder.php">Order</a>
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



        <div class="box-container">

            <?php
            
            $select_products = mysqli_query($conn, "SELECT * FROM `products`");
            if(mysqli_num_rows($select_products) > 0){
                while($fetch_product = mysqli_fetch_assoc($select_products)){
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
                    <div class="price">₱<?php echo $fetch_product['price']; ?>   
                           
                    </div>
                     <a href="admin.php?delete=<?php echo $row['product_id']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> delete </a>
                     <a href="admin.php?edit=<?php echo $row['product_id']; ?>" class="option-btn"> <i class="fas fa-edit"></i> update </a>
           

                    <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                    <input type="hidden" name="product_description" value="<?php echo $fetch_product['description']; ?>">
                    <input type="hidden"  name="product_price" value="<?php echo $fetch_product['price']; ?>">
                    <input type="hidden"  name="product_pquantity" value="<?php echo $fetch_product['quantity']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                   
        
                </div>
            </form>

                <?php
                    };
                };
                ?>

        </div>

    </section>
    <section class="edit-form-container">

<?php

if(isset($_GET['edit'])){
   $edit_id = $_GET['edit'];
   $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE product_id = $edit_id");
   if(mysqli_num_rows($edit_query) > 0){
      while($fetch_edit = mysqli_fetch_assoc($edit_query)){
?>

<form action="" method="post" enctype="multipart/form-data">
   <img src="../uploadimage/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
   <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['product_id']; ?>">
   <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['name']; ?>">
   <input type="text" class="box" required name="update_p_description" value="<?php echo $fetch_edit['description']; ?>">
   <input type="number" min="0" class="box" required name="update_p_price" value="<?php echo $fetch_edit['price']; ?>">
   <input type="file" class="box" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">
   <input type="submit" value="update the prodcut" name="update_product" class="btn">
   <input type="reset" value="cancel" product_id="close-edit" class="option-btn">
</form>

<?php
         };
      };
      echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
   };
?>

</section>

</div>

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

<!-- custom js file link  -->
<script src="../js/script.js"></script>

</body>
</html>
