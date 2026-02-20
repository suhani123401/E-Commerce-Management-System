<?php


session_start();

if (!empty($_SESSION['cart'])) {

    //let user in


    //send user to home page
} else {
    header('location: home.php');
}

?>









    <style>
        /*checkout*/
        #checkout-form {
            width: 100%;
            max-width: 40rem;
            /*desktop max width*/
            margin: 50px auto;
            padding: 40px;
            text-align: center;
            border: 1px solid #fb774b;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            background-color: #fff;
        }

        /* Style inputs */
        #checkout-form input.form-control {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        /* Style submit button */
        #checkout-form input#checkout-btn {
            width: 100%;
            background-color: #fb774b;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        #checkout-form input#checkout-btn:hover {
            background-color: #e0663c;
        }

        /* Style register link */

        #checkout-form #checkout:hover {
            text-decoration: underline;
        }

        hr {
            text-align: center;
            width: 30%;
        }

        /* Responsive tweak */
        @media (max-width: 500px) {
            #checkout-form {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <a href="../admin/place_order.php"></a>
    <?php include('include/header.php'); ?>

    



    <!--Checkout-->
    <section>
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Check Out</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="checkout-form" method="POST" action="./place_order.php">
                <?php if (isset($_GET['message'])): ?>
                    <p class="text-center text-danger">
                        <?php echo htmlspecialchars($_GET['message']); ?>
                        <br>
                        <a href="login.php" class="btn btn-primary mt-2">Login</a>
                    </p>
                <?php endif; ?>
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="">Name</label>
                        <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Register_Name">
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="">Email</label>
                        <input type="email" class="form-control" id="checkout-email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="">Phone</label>
                        <input type="number" class="form-control" id="checkout-phone" name="phone" placeholder="Phone" required>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="">City</label>
                        <input type="text" class="form-control" id="checkout-city" name="city" placeholder="city" required>
                    </div>
                    <div class="form-group col-12 mb-3">
                        <label for="">Address</label>
                        <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Address" required>
                    </div>
                    <div class="form-group col-12 mb-3 d-grid">
                        <p>Total amount: $<?php echo $_SESSION['total']; ?></p>
                        <input type="submit" class="btn" id="checkout-btn" name="place_order" value="Place Order">
                    </div>
                </div>

            </form>
        </div>
    </section>





<?php include('include/footer.php'); ?>