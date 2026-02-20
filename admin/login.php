<?php
session_start();
include('../connection1.php');
include("include/header.php");

$error = "";



if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conns, $query);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);

        if(password_verify($password, $user['password'])){ 
            // ✅ Save admin id in session
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "Email not found!";
    }
}
?>


<div class="text-center mb-3">
    <img src="../image_upload/<?php echo $_SESSION['admin_image'] ?? 'default.png'; ?>" 
         width="80" height="80" 
         style="border-radius:50%; object-fit:cover;">
</div>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4 shadow">
                <h4 class="mb-3">Admin Login</h4>

                <!-- Dark Mode Toggle -->
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="darkToggle">
                    <label class="form-check-label">Dark Mode</label>
                </div>

                <?php if($error) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>

                <form method="post">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                    <p class="mt-2">Not registered? <a href="register.php">Register</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("include/footer.php"); ?>
