<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "e-commerce"; 

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Database connected successfully";
}


if(isset($_POST['public'])) {  // form button name

   $order_id = $_POST['order'];
   $customer = $_POST['customer']; 
   $product = $_POST['product'];
   $quantity = $_POST['quantity'];
   $total_amount = $_POST['total_amount'];
   $order_date = $_POST['order_date'];

  //check for empty
  if(empty($customer_id) || empty($product_id)){
    die("please select customer and product");
  }

   $sql = "INSERT INTO orders (order_id, customer_id, product_id, quantity, total_amount, order_date) 
           VALUES ('$order_id', $customer, $product, $quantity, $total_amount, '$order_date')";

   if (mysqli_query($conn, $sql)) {
       echo "New order added successfully";
   } else {
       echo "Error: " . mysqli_error($conn);
   }

   mysqli_close($conn);
}

?>
