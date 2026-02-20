<?php

require_once('../connection1.php');

if (isset($_GET['product_id'])) {

    $product_id = $_GET['product_id'];
    $stmt = $conns->prepare("SELECT * FROM products WHERE id= ?");
    if (!$stmt) {
        die("Prepare failed: " . $conns->error);
    }
    $stmt->bind_param("s", $product_id); //s-string ho
    $stmt->execute();
    $product = $stmt->get_result();
} else {
    header('location: home.php');
}

?>




<?php include('include/header.php'); ?>

    <style>
        .small-img-group {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .small-img-col {
            flex-basis: 25%;
            cursor: pointer;
        }

        .small-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .product-details {
            padding: 20px;
            font-family: 'Arial', sans-serif;
        }

        /* Category text */
        .product-details .category {
            font-size: 14px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Product title */
        .product-details .product-title {
            font-size: 28px;
            font-weight: 600;
            color: #333;
        }

        /* Price */
        .product-details .product-price {
            font-size: 24px;
            font-weight: 700;
            color: #ff4d4f;
            /* red accent color */
            margin-bottom: 15px;
        }

        /* Quantity input and button */
        .purchase-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        input {
            width: 50px;
            border-radius: 5px;
            text-align: center;
        }

        .buy-btn {
            padding: 8px 20px;
            background-color: #ff4d4f;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.2s;
        }

        .buy-btn:hover {
            background-color: white;
            transform: scale(1.05);
        }

        /* Details section */
        .details-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
        }

        .product-description {
            font-size: 15px;
            color: #555;
            line-height: 1.6;
        }
    </style>

    <section class="single_product my-5 pt-5">
        <div class="container">
            <div class="row mt-5">
                <?php while ($row = $product->fetch_assoc()) { ?>


                    <div class="col-lg-5 col-md-6 col-sm-12">
                        <img class="img-fluid w-100 pb-1" src="../image_upload/<?php echo $row['image']; ?>" alt="">
                        <div class="small-img-group">
                            <div class="small-img-col">
                                <img src="../image_upload/<?php echo $row['image']; ?>" width="100" class="small-img" alt="">
                            </div>
                            <div class="small-img-col">
                                <img src="../image_upload/<?php echo $row['image']; ?>" width="100" class="small-img" alt="">
                            </div>
                            <div class="small-img-col">
                                <img src="../image_upload/<?php echo $row['image']; ?>" width="100" class="small-img" alt="">
                            </div>
                            <div class="small-img-col">
                                <img src="../image_upload/<?php echo $row['image']; ?>" width="100" class="small-img" alt="">
                            </div>
                        </div>
                    </div>



                    <div class="col-lg-6 col-md-12 col-12">
                        <h6>Men/shoes</h6>
                        <h3 class="py-4"><?php echo $row['product_name']; ?></h3>
                        <h2><?php echo $row['price']; ?></h2>

                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="product_image" value="<?php echo $row['image']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?> ">
                            <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                            <input type="number" name="product_quantity" value="1" min="1">
                            <button class="buy-btn" type="submit" name="add_to_cart">Add To Cart</button>
                        </form>

                        <h4 class="mt-5 mb-5">Product Details</h4>
                        <span><?php echo $row['description']; ?></span>
                    </div>
            </div>
        </div>


    <?php } ?>
    </section>








<?php include('include/footer.php'); ?>