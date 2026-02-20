<?php
session_start();
require('../connection1.php');
include_once("../include/header.php");
include_once("../include/topbar.php");
include_once("../include/sidebar.php");

if (isset($_POST['change_password'])) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if(!isset($_SESSION['user_email'])){
        header('location: login.php?error=Please login first');
        exit();
    }

    $user_email = $_SESSION['user_email'];

    // Check passwords match
    if ($password !== $confirmPassword) {
        header('location: account.php?error=Passwords do not match');
        exit();
    } else if (strlen($password) < 6) {
        header('location: account.php?error=Password must be at least 6 characters');
        exit();
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conns->prepare("UPDATE admin SET password=? WHERE email=?");
        $stmt->bind_param('ss', $hashedPassword, $user_email);

        if ($stmt->execute()) {
            header('location: account.php?message=Password has been updated successfully');
            exit();
        } else {
            header('location: account.php?error=Could not update password');
            exit();
        }
    }
}
?>


<div class="col-lg-4 col-md-5 col-sm-7 mx-auto mt-5">
    <div class="card shadow-sm p-4" style="border-radius: 15px;">
        <div class="card-body">

            <!-- Error / Success Messages -->
            <?php if(isset($_GET['error'])): ?>
                <p class="text-center text-danger fw-bold"><?php echo $_GET['error']; ?></p>
            <?php endif; ?>
            <?php if(isset($_GET['message'])): ?>
                <p class="text-center text-success fw-bold"><?php echo $_GET['message']; ?></p>
            <?php endif; ?>

            <h3 class="text-center mb-3">Change Password</h3>
            <hr class="mx-auto mb-4" style="width: 50%; border-top: 2px solid #007bff;">

            <form action="account.php" id="account-form" method="post" class="d-flex flex-column gap-3">

                <div class="form-group">
                    <label for="account-password" class="form-label fw-semibold">Password</label>
                    <input type="password" class="form-control" id="account-password" name="password" placeholder="Enter new password" required>
                </div>

                <div class="form-group">
                    <label for="account-password-confirm" class="form-label fw-semibold">Confirm Password</label>
                    <input type="password" class="form-control" id="account-password-confirm" name="confirmPassword" placeholder="Confirm new password" required>
                </div>

                <div class="form-group text-center">
                    <input type="submit" name="change_password" class="btn btn-primary w-50" id="change-pass-btn" value="Change Password">
                </div>

            </form>
        </div>
    </div>
</div>
