<?php

/*
not paid
shipped
delivered
*/

include('../connection1.php');
include('include/header.php');

if (isset($_POST['order_details_btn']) && isset($_POST['order_id'])) {

    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $stmt = $conns->prepare("SELECT * FROM order_items WHERE order_id = ? ");

    $stmt->bind_param('i', $order_id);

    $stmt->execute();

    $order_details = $stmt->get_result();

    $order_total_price = calculateTotalOrderPrice($order_details);

} else {
    header('location: account.php');
    exit();
}


function calculateTotalOrderPrice($order_details)
{
    $total = 0;

    foreach($order_details as $row){
       $product_price = $row['product_price'];
       $product_quantity = $row['product_quantity'];

       $total = $total + ($product_price * $product_quantity);
    }
  
    return $total;
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link rel="stylesheet" href="style.css">
    <style>
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
</head>

<body>


    <!--navbar start-->
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container-fluid">
            <a class="navbar-brand pe-5" href="#">LadyCollection</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">

                    <li class="nav-item">
                        <a class="nav-link  pe-4" href="home.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link pe-4" href="shop.php">Shop</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link pe-4" href="#">Blog</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link pe-4 active" href="contact.php">Contact Us</a>

                    </li>

                    <!-- Cart Icon -->
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                    </li>
                    <!--user-->
                    <li class="nav-item">
                        <a class="nav-link" href="account.php">
                            <i class="fa-solid fa-user"></i>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
    <!--navbar end-->



    <!--Order details-->
    <section id="orders" class="order container my-5 py-5">
        <div class="container mt-5">
            <h2 class="font-weight-bolde">Your Cart</h2>
        </div>

        <table class="mt-5 pt-5 mx-auto ">
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>


            </tr>
            <?php foreach ($order_details as $row) {  ?>
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="../image_upload/<?php echo $row['image']; ?>" alt="">
                            <div>
                                <p class="mt-3"><?php echo $row['product_name'];  ?></p>
                            </div>
                        </div>


                    </td>
                    <td>
                        <span><?php echo $row['product_price'];  ?></span>
                    </td>
                    <td>
                        <span><?php echo $row['product_quantity'];  ?></span>
                    </td>

                </tr>

            <?php } ?>



        </table>
       
        <?php 
            if($order_status == "not paid"){?>
                <form action="payment.php" style="float: right;" method="post">
                    <input type="hidden" name="order_total_price" value="<?php echo $order_total_price; ?>">
                    <input type="hidden" name="order_status" value="<?php echo $order_status; ?>">
                    <input type="submit" name="order_pay_btn" class="btn btn-primary" value="Pay Now">
                </form>
            <?php } ?>
        
       
    </section>



    <!-- Footer -->
    <footer class="footer-section bg-dark text-white mt-5 pt-5 pb-4">
        <div class="container">
            <div class="row">

                <!-- Logo + About -->
                <div class="footer-one col-lg-3 col-md-6 col-sm-12 mb-4">
                    <h1>LadyCollection</h1>
                    <p class="pt-3">We provide the best products for the most affordable prices.</p>
                </div>

                <!-- Featured Links -->
                <div class="footer-one col-lg-3 col-md-6 col-sm-12 mb-4">
                    <h5 class="pb-2">Featured</h5>
                    <ul class="footer-links">
                        <li><a href="#">Men</a></li>
                        <li><a href="#">Women</a></li>
                        <li><a href="#">Boys</a></li>
                        <li><a href="#">Girls</a></li>
                    </ul>
                </div>

                <!-- Contact Section -->
                <div class="footer-one col-lg-3 col-md-6 col-sm-12 mb-4">
                    <h5 class="pb-2">Contact Us</h5>
                    <p><strong>Address:</strong> 1234 Street, City</p>
                    <p><strong>Phone:</strong> 123 456 789</p>
                    <p><strong>Email:</strong> info@gmail.com</p>
                </div>

                <!-- Social + Copyright -->
                <div class="footer-one col-lg-3 col-md-6 col-sm-12 mb-4 text-center">
                    <h5 class="pb-2">Follow Us</h5>

                    <div class="footer-social mb-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>

                    <p class="copyright">© eCommerce 2025 All Rights Reserved</p>
                </div>

            </div>
        </div>
    </footer>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
<?php include('include/footer.php'); ?>