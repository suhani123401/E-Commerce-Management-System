<?php
/*session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: login.php?error=Please login first');
    exit();
}


include('../connection1.php');

if (isset($_POST['place_order'])) {



    //1.get user info and store it in database
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $order_cost = $_SESSION['total'];
    $order_status = "on_hold";
    $user_id = (int)$_SESSION['user_id'];

    $order_date = date('Y-m-d H:i:s');

    $stmt = $conns->prepare("INSERT INTO orders(order_cost,order_status,user_id,user_phone,user_city,user_address,order_date)
                        VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param('isiisss', $order_cost, $order_status, $user_id, $phone, $city, $address, $order_date);

    $stmt->execute();

    //2. issue new order and store order info in database
    $order_id = $stmt->insert_id;

    //3.get products from cart(from session)



   foreach($_SESSION['cart'] as $key =>$value){

    $product = $_SESSION['cart'][$key];
    $product_id = $product['id'];
    $product_name = $product['product_name'];
    $product_price= $product['price'];
    $product_image = $product['image']; 
    $product_quantity = $product['product_quantity'];

    //4. store each single item in order_items database

    $stmt1 = $conns->prepare("INSERT INTO order_items(order_id,product_id,product_name,image,product_price,product_quantity,user_id,order_date)
                    VALUES(?,?,?,?,?,?,?,?)");
    $stmt1->bind_param('iissiiis',$order_id,$product_id,$product_name,$product_image,$product_price,$product_quantity,$user_id,$order_date);
    $stmt1->execute();
 }
   






    //5. remove everything from cart
//check login state 
//if login true (eiter by session,local storage)
//show cart details of logged in user
//else 
//show empty cart details




    //6. inform user whether everything is fine or there is a problem
    header('location: payment.php?order_status="order placed successfully"');

}


session_start();


if (!isset($_SESSION['user_id'])) {
    header('location: login.php?error=Please login first');
    exit();
}


include('../connection1.php');

if(isset($_POST['place_order'])){
 $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $order_cost = $_SESSION['total'];
    $order_status = "on_hold";
 $user_id = (int)$_SESSION['user_id'];

    $order_date = date('Y-m-d H:i:s');    
   $stmt = $conns->prepare("INSERT INTO orders(order_cost,order_status,user_id,user_phone,user_city,user_address,order_date)
                        VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param('isiisss', $order_cost, $order_status, $user_id, $phone, $city, $address, $order_date);

    $stmt->execute();
    $order_id = $stmt->insert_id;


   foreach($_SESSION['cart'] as $key =>$value){

    $product = $_SESSION['cart'][$key];
    $product_id = $product['id'];
    $product_name = $product['product_name'];
    $product_price= $product['price'];
    $product_image = $product['image']; 
    $product_quantity = $product['product_quantity'];
    
    $stmt1 = $conns->prepare("INSERT INTO order_items(order_id,product_id,product_name,image,product_price,product_quantity,user_id,order_date)
                    VALUES(?,?,?,?,?,?,?,?)");
    $stmt1->bind_param('iissiiis',$order_id,$product_id,$product_name,$product_image,$product_price,$product_quantity,$user_id,$order_date);
    $stmt1->execute();
   }
   
 header('location: payment.php?order_status="order placed successfully"');
}
*/
session_start();


if (!isset($_SESSION['user_id'])) {
    header('location: login.php?error=Please login first');
    exit();
}


include('../connection1.php');

if(isset($_POST['place_order'])){
 $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $order_cost = $_SESSION['total'];
    $order_status = "on_hold";
 $user_id = (int)$_SESSION['user_id'];

    $order_date = date('Y-m-d H:i:s');    
   $stmt = $conns->prepare("INSERT INTO orders(order_cost,order_status,user_id,user_phone,user_city,user_address,order_date)
                        VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param('isiisss', $order_cost, $order_status, $user_id, $phone, $city, $address, $order_date);

    $stmt->execute();
    $order_id = $stmt->insert_id;


   foreach($_SESSION['cart'] as $key =>$value){

    $product = $_SESSION['cart'][$key];
    $product_id = $product['id'];
    $product_name = $product['product_name'];
    $product_price= $product['price'];
    $product_image = $product['image']; 
    $product_quantity = $product['product_quantity'];
    
    $stmt1 = $conns->prepare("INSERT INTO order_items(order_id,product_id,product_name,image,product_price,product_quantity,user_id,order_date)
                    VALUES(?,?,?,?,?,?,?,?)");
    $stmt1->bind_param('iissiiis',$order_id,$product_id,$product_name,$product_image,$product_price,$product_quantity,$user_id,$order_date);
    $stmt1->execute();
   }
session_start();


if (!isset($_SESSION['user_id'])) {
    header('location: login.php?error=Please login first');
    exit();
}


include('../connection1.php');

if(isset($_POST['place_order'])){
 $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $order_cost = $_SESSION['total'];
    $order_status = "on_hold";
 $user_id = (int)$_SESSION['user_id'];

    $order_date = date('Y-m-d H:i:s');    
   $stmt = $conns->prepare("INSERT INTO orders(order_cost,order_status,user_id,user_phone,user_city,user_address,order_date)
                        VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param('isiisss', $order_cost, $order_status, $user_id, $phone, $city, $address, $order_date);

    $stmt->execute();
    $order_id = $stmt->insert_id;


   foreach($_SESSION['cart'] as $key =>$value){

    $product = $_SESSION['cart'][$key];
    $product_id = $product['id'];
    $product_name = $product['product_name'];
    $product_price= $product['price'];
    $product_image = $product['image']; 
    $product_quantity = $product['product_quantity'];
    
    $stmt1 = $conns->prepare("INSERT INTO order_items(order_id,product_id,product_name,image,product_price,product_quantity,user_id,order_date)
                    VALUES(?,?,?,?,?,?,?,?)");
    $stmt1->bind_param('iissiiis',$order_id,$product_id,$product_name,$product_image,$product_price,$product_quantity,$user_id,$order_date);
    $stmt1->execute();
   }
   
 header('location: payment.php?order_status="order placed successfully"');
}
}

?>