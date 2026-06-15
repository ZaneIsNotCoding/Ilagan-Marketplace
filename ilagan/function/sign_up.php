<?php
session_start();
require __DIR__ . '/../include/db.php';

if (isset($_POST["submit"])) {
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $contact = $_POST['contact'];
    $mail = $_POST['email'];
    $password = $_POST['pass']; // Plain text password

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO form (fname, lname, contact, email, pass) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $lastname, $contact, $mail, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Successfully registered');</script>";
    } else {
        echo "<script>alert('Registration failed');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="../css/signup.css">
</head>
<body>
    <div class="container">
        <h1>Create an Account</h1>
        <form method="POST">
            <input type="text" name="fname" placeholder="First Name" required>
            <input type="text" name="lname" placeholder="Last Name" required>
            <input type="text" name="contact" placeholder="Contact Number" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="pass" placeholder="Password" required>          
            <button type="submit" name="submit">Register</button>
        </form>
        <p>Already have an account? <a href="sign_in.php">Sign in</a></p>
    </div>
</body>
</html>
