
<?php
session_start();
include('../connection1.php');


/*=================Login check=============*/
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}


/*=====================Logout===================*/
if (isset($_GET['logout'])) {
    if (isset($_SESSION['logged_in'])) {
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        header('location: login.php');
        exit();
    }
}

/*====================change password=============*/
if (isset($_POST['change_password'])) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $user_email = $_SESSION['user_email'];

    //if passwords  match
    if ($password !== $confirmPassword) {
        header('location: account.php?error=passwords dont match');
        exit();

        //if password is less than 6 char
    } else if (strlen($password) < 6) {
        header('location: account.php?error=password must be at least 6 characters');
        exit();

        //no error or update error
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conns->prepare("UPDATE users SET user_password=? WHERE user_email=?");
        $stmt->bind_param('ss', $hashedPassword, $user_email);

        if ($stmt->execute()) {
            header('location: account.php?message=password has been updated successfully');
        } else {
            header('location: account.php?message=could not updated password');
        }
    }
}



//get order

if (isset($_SESSION['logged_in'])) {
   $user['user_id'] = $_SESSION['user_id'] ;
    $stmt = $conns->prepare("SELECT * FROM orders where order_id=? ");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $orders = $stmt->get_result();
}


?>



<?php
include('include/header.php');
?>
    <style>
        /* ======================= Account Section ======================= */

        /* Section spacing and background */
        section.my-5.py-5 {
            padding: 50px 0;
            background-color: #f9f9f9;
        }

        /* Container layout */
        .row.container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;

            flex-wrap: wrap;
            gap: 30px;
        }

        .text-center {
            flex: 1;
            min-width: 280px;
        }


        /* Left: Account info */
        .text-center h3 {
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .text-center hr {
            width: 50px;
            border: 2px solid #007bff;
            margin: 10px auto 20px auto;
        }

        /* Account info box */
        .account-info {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .account-info p {
            font-size: 16px;
            margin-bottom: 12px;
            color: #555;
        }

        .account-info span {
            font-weight: 600;
            color: #000;
            margin-left: 10px;
        }

        /* Links */
        #order-btn,
        #logout-btn {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        #order-btn:hover,
        #logout-btn:hover {
            text-decoration: underline;
        }

        /* Right: Change Password Form */
        #account-form {
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
            padding: 25px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        #account-form h3 {
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        #account-form hr {
            width: 50px;
            border: 2px solid #007bff;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        /* Submit Button */
        #change-pass-btn {
            background-color: #007bff;
            color: #fff;
            padding: 10px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            width: 100%;
            transition: 0.3s ease;
        }

        #change-pass-btn:hover {
            background-color: #0056b3;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .row.container {
                flex-direction: column;
            }

            #account-form {
                margin-top: 30px;
            }
        }


        /*Order*/

        /* Section spacing and background */
        section.order {
            padding: 50px 0;
            background-color: #f8f9fa;
        }

        /* Section title */
        section.order h2 {
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 40px;
        }

        /* Table styling */
        section.order table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        section.order th,
        section.order td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: #555;
        }

        section.order th {
            background-color: #007bff;
            color: #fff;
            font-weight: 600;
        }

        /* Product info styling */
        .product-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .product-info img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        /* Date styling */
        section.order td span {
            font-weight: 500;
            color: #333;
        }

        /* Button styling */
        section.order .btn {
            display: block;
            margin: 20px auto 0;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        section.order .btn:hover {
            background-color: #0056b3;
        }

        /* Responsive for mobile */
        @media (max-width: 768px) {
            .product-info {
                flex-direction: column;
                text-align: center;
            }

            section.order th,
            section.order td {
                padding: 10px;
            }

            section.order .btn {
                width: 100%;
            }
        }
    </style>




 


    <!---account-->
    <section class="my-5 py-5">
        <div class="row container mx-auto">
            <div class="text-center mt-3 pt-3 col-lg-6 col-md-12 col-sm-12">
                <p class="text-center" style="color:green;"><?php if (isset($_GET['register_success'])) {
                                                                echo $_GET['register_success'];
                                                            } ?></p>
                <p class="text-center" style="color:green;"><?php if (isset($_GET['login_success'])) {
                                                                echo $_GET['login_success'];
                                                            } ?></p>

                <h3 class="font-weight-bold">
                    Account info
                </h3>
                <hr class="mx-auto">
                <div class="account-info">
                    <p>Name<span><?php if (isset($_SESSION['user_name'])) {
                                        echo $_SESSION['user_name'];
                                    } ?></span></p>
                    <p>Email<span><?php if (isset($_SESSION['user_email'])) {
                                        echo $_SESSION['user_email'];
                                    } ?></span></p>
                   
                    <p><a href="account.php?logout=1" id="logout-btn">LogOut</a></p>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12">
                <form action="account.php" id="account-form" method="post">
                    <p class="text-center" style="color:red;"><?php if (isset($_GET['error'])) {
                                                                    echo $_GET['error'];
                                                                } ?></p>
                    <p class="text-center" style="color:green;"><?php if (isset($_GET['message'])) {
                                                                    echo $_GET['message'];
                                                                } ?></p>

                    <h3>Change Password</h3>
                    <hr class="mx-auto">
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control" id="account-password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="">Confirm Password</label>
                        <input type="password" class="form-control" id="account-password-confirm" name="confirmPassword" placeholder="ConfirmPassword" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="change_password" class="btn" id="change-pass-btn" value="change password">
                    </div>
                </form>
            </div>

        </div>
    </section>











    



<?php include('include/footer.php'); ?>
















































<!--<!--Orders-->
  <!--<section id="orders" class="order container my-5 py-5">
        <div class="container mt-5">
            <h2 class="font-weight-bolde">Your Cart</h2>
        </div>

        <table class="mt-5 pt-5">
            <tr>
                <th>Order id</th>
                <th>Order cost</th>
                <th>Order status</th>
                <th>Order date</th>
                <th>Order details</th>
                                                                
            </tr>
            <?php while ($row = $orders->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <!--<div class="product-info">
                            <img src="./images/feature1.jpg" alt="">
                            <div>
                                <p class="mt-3"><?php echo $row['order_id']; ?></p>
                            </div>
                        </div>
                        
                      <span><?php echo $row['order_id']; ?></span>
                    </td>
                    <td>
                        <span><?php echo $row['order_cost']; ?></span>
                    </td>
                    <td>
                        <span><?php echo $row['order_status']; ?></span>
                    </td>

                    <td>
                        <span><?php echo $row['order_date']; ?></span>
                    </td>

                    <td>
                        <form method="POST" action="order_details.php">
                               <input type="hidden" value="<?php echo $row['order_status'];?>" name="order_status">
                            <input type="hidden" value="<?php echo $row['order_id'];?>" name="order_id">
                            <input type="submit" name="order_details_btn" class="btn" value="details">
                        </form>
                    </td>
                    
                </tr>

            <?php } ?>
        </table>
       
    </section>

-->