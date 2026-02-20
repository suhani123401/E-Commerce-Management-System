<?php

session_start();
include('../connection1.php');


//if user has already registered, then take user to account page
 if (isset($_SESSION['logged_in'])) {
    header('location: account.php');
    exit();
}

if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];


    //if passwords dont match
    if ($password !== $confirmpassword) {
        header('location: register.php?error=passwords dont match');
        exit();
    }

    //if password is less than 6 char
    else if (strlen($password) < 6) {
        header('location: register.php?error=password must be at least 6 characters');
        exit();


        //if there is no error
    } else {

        //check whether there is a user with this email or not
        $stmt1 = $conns->prepare("SELECT  count(*) FROM users WHERE user_email=?");
        $stmt1->bind_param('s', $email);
        $stmt1->execute();
        $stmt1->bind_result($num_rows);
        $stmt1->store_result();
        $stmt1->fetch();


        //if there is a user already registered with this email
        if ($num_rows != 0) {
            header('location: register.php?error=user with this email already exists');
            exit();
        } else {

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            //create a new user
            $stmt = $conns->prepare("INSERT INTO users (user_name,user_email,user_password) VALUES (?,?,?)");

            $stmt->bind_param('sss', $name, $email, $hashedPassword);

            if ($stmt->execute()) {
                $id = $stmt->insert_id;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;
                $_SESSION['logged_in'] = true;
                header('location: account.php?register_success=You registered successfully');

                //account could not be created
            } else {
                header('location: register.php?error=Could not create an account at the moment');
                exit();
            }
        }
    }
    
} 



?>



<?php include('include/header.php'); ?>

    <!---regrister-->
    <section>
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Register</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="register-form" action="register.php" method="post">
                <p style="color: red;"><?php if (isset($_GET['error'])) {
                                            echo $_GET['error'];
                                        } ?></p>
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" id="register-name" name="name" placeholder="Register_Name">
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" class="form-control" id="register-email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="">Confirm Password</label>
                    <input type="password" class="form-control" id="register-confirm-password" name="confirmpassword" placeholder="confirmPassword" required>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" id="register-btn" name="register" value="Register">
                </div>
                <div class="form-group">
                    <a id="login-url" class="btn" href="login.php">Do you have an account? Login </a>
                </div>
            </form>
        </div>
    </section>

<?php include('include/footer.php'); ?>