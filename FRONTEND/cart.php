<?php
session_start();
include("../connection1.php");

//default safe values
$_SESSION['cart']  = $_SESSION['cart']  ?? [];
$_SESSION['total'] = $_SESSION['total'] ?? 0;



if (isset($_POST['add_to_cart'])) {

    // if user has already added a product to cart
    if (isset($_SESSION['cart'])) {

        $product_array_ids = array_column($_SESSION['cart'], "id");

        // if product has not already been added to cart
        if (!in_array($_POST['product_id'], $product_array_ids)) {
            $product_id = $_POST['product_id'];
            $product_name = $_POST['product_name'];
            $product_price = $_POST['product_price'];
            $product_image = $_POST['product_image'];
            $product_quantity = $_POST['product_quantity'];  // default 1
            $product_stock = $_POST['product_stock'] ?? 0;            // DB stock

            $product_array = array(
                'id' => $product_id,
                'product_name' => $product_name,
                'price' => $product_price,
                'image' => $product_image,
                'stock' => $product_stock,
                'product_quantity' => $product_quantity
            );

            $_SESSION['cart'][$product_id] = $product_array;
        } else {
            // product has already been added
            echo '<script>alert("Product was already added to cart");</script>';
        }
    } else {
        // if this is the first product
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = $_POST['product_quantity'] ?? 1;  // default 1
        $product_stock = $_POST['product_stock'];            // DB stock

        $product_array = array(
            'id' => $product_id,
            'product_name' => $product_name,
            'price' => $product_price,
            'image' => $product_image,
            'stock' => $product_stock,
            'product_quantity' => $product_quantity

        );

        $_SESSION['cart'][$product_id] = $product_array;
    }
    // calculate total
    calculateTotalCart();



    //remove product from cart
} else if (isset($_POST['remove_product'])) {

    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);

   
    // calculate total
    calculateTotalCart();
} else if (isset($_POST['edit_quantity'])) {

    //we get id and quantity from rhe form
    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_stock'];

    //get the product array from the session
    $product_array = $_SESSION['cart'][$product_id];

    //update product quantity
    $product_array['product_quantity'] = $product_quantity;

    //return array back its place
    $_SESSION['cart'][$product_id] = $product_array;

    
    // calculate total
    calculateTotalCart();
} else {
   
}


function calculateTotalCart()
{
    $total = 0;
    foreach ($_SESSION['cart'] as $key => $value) {

        $product = $_SESSION['cart'][$key];
        $price = $product['price'];
        $quantity = $product['product_quantity'];
        $total = $total + ($price * $quantity);
    }
    $_SESSION['total'] = $total;
}
?>



<?php include('include/header.php'); ?>

    <style>
        .edit-btn {
            color: #fb774b;
            text-decoration: none;
            font-size: 15px;
            background-color: #fff;
            border: none;

        }

        .cart-total {
            display: flex;
            justify-content: flex-end;
        }

        .cart-total table {
            width: 100%;
            max-width: 500px;
            border-top: 3px solid #fb774b;
        }

        td:last-child {
            text-align: right;
        }

        th:last-child {
            text-align: right;
        }

        .btn {
            background: linear-gradient(135deg, #ff7eb3, #ff758c);
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            border: none;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s ease;
            margin-top: 15px;
        }

        .btn:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }
    </style>

    <!--CART-->
    <section class="cart container my-5 py-5">
        <div class="container mt-5">
            <h2 class="font-weight-bolde">Your Cart</h2>
        </div>

        <table class="mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>

            <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="../image_upload/<?php echo $value['image']; ?>" alt="">
                            <div>
                                <p><?php echo $value['product_name']; ?></p>
                                <small><span>Rs </span><?php echo isset($value['price']) ? $value['price'] : '0'; ?></small>

                                <br>
                                <form method="POST" action="cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $value['id']; ?>">
                                    <input type="submit" name="remove_product" class="remove-btn" value="remove">
                                </form>
                            </div>
                        </div>
                    </td>
                    <td>

                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $value['id']; ?>">
                            <input type="number" name="product_stock" class="stock" value="<?php echo $value['product_quantity'] ?? 1; ?>">
                            <input type="submit" class="edit-btn" value="edit" name="edit_quantity">
                        </form>
                    </td>

                    <td>
                        <span class="currency">Rs</span>
                        <span class="product-price"><?php echo $value['product_quantity'] * $value['price'] ?></span>
                    </td>
                </tr>
            <?php } ?>
        </table>


        <div class="cart-total">
            <table>
               
                <tr>
                    <td>Total</td>
                    <td>Rs <?php echo $_SESSION['total']; ?></td>
                </tr>
            </table>
        </div>

        <div class="checkout-container" style="width:30px">
            <form method="POST" action="checkout.php">
                <input type="submit" class="btn checkout-btn" value="checkout" name="checkout">
            </form>
        </div>
    </section>

<?php include('include/footer.php'); ?>