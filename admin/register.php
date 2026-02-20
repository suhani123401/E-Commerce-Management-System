<?php
session_start();
require('../connection1.php');
include("include/header.php");


$error = "";
$success = "";

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // check if email already exists
    $check = mysqli_query($conns,"SELECT * FROM admin WHERE email='$email'");
    if(mysqli_num_rows($check) > 0){
        $error = "Email already exists!";
    } else {
        $query = mysqli_query($conns,"INSERT INTO admin (username,email,password) VALUES ('$username','$email','$password')");
        if($query){
            $success = "Admin registered successfully! <a href='login.php'>Login Now</a>";
        } else {
            $error = "Something went wrong!";
        }
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4 shadow">
                <h4 class="mb-3">Admin Register</h4>

                <!-- Dark Mode Toggle -->
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="darkToggle">
                    <label class="form-check-label">Dark Mode</label>
                </div>

                <?php if($error) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>
                <?php if($success) echo '<div class="alert alert-success">'.$success.'</div>'; ?>

                <form method="post">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
                    <p class="mt-2">Already registered? <a href="login.php">Login</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("include/footer.php"); ?>
