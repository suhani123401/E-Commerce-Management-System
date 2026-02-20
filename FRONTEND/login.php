<?php
session_start();
include('../connection1.php');


if(isset($_SESSION['logged_in'])){
    header('location: payment.php');
    exit();
}



if(isset($_POST['login_btn'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conns->prepare("SELECT user_id, user_name, user_email, user_password FROM users WHERE user_email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows == 1){  // <- num_rows property
        $stmt->bind_result($user_id, $user_name, $user_email, $hashedPassword);
        $stmt->fetch();

        if(password_verify($password, $hashedPassword)){
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_email'] = $user_email;
            $_SESSION['logged_in'] = true;

            header("Location: account.php?login_success=logged in successfully");
            exit();
        } else {
            header("Location: login.php?error=Wrong password");
            exit();
        }
    } else {
        header("Location: login.php?error=Email not found");
        exit();
    }
}
?>


<?php include('include/header.php'); ?>

    <section>
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Login</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="login-form" action="login.php" method="post">
                <p style="color: red;" class="text-center"><?php if(isset($_GET['error'])){ echo $_GET['error']; } ?></p>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" name="login_btn" id="login-btn" value="login">
                </div>
                <div class="form-group">
                    <a id="register-url" class="btn" href="register.php">Don't have account? Register </a>
                </div>
            </form>
        </div>
    </section>


<?php include('include/footer.php'); ?>