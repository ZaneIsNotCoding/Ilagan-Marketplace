<?php
session_start();
require __DIR__ . '/../include/db.php';

if (isset($_POST["submit"])) {
    $mail = $_POST["email"];
    $password = $_POST['pass'];
 
    if (!empty($mail) && !empty($password) && !is_numeric($mail)) {
     
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT user_id, pass FROM form WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $stored_password = $row['pass'];
            $id = $row['user_id'];
            
            // Verify the password
            if ($password === $stored_password) {
                // Password is correct, start a session
                session_regenerate_id();
                $_SESSION["Login"] = true;
                $_SESSION["user_id"] = $id;         
                header("Location: collection.php");
                exit;
            } else {
                echo "<script>alert('Wrong password');</script>";
            }
        } else {
            echo "<script>alert('User not registered');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Please enter valid email and password');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/sign_in.css">
</head>
<body>
   <div class="container">
    <h1>Login</h1>
    <form method="POST">
      <input type="email" name="email" placeholder="example@gmail.com" required>
      <input type="password" name="pass" placeholder="Password" required>
      <button type="submit" name="submit">Login</button>
    </form>
    <p>New to Ilagan Marketplace? <a href="sign_up.php">Sign up</a></p>
   </div>
</body>
</html>
