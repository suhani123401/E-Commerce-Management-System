<?php session_start();

// 🔒 Login check FIRST
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit();
}

// ⚡ Define admin name safely
$admin_name = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : "Admin";



require('../connection1.php');
include_once("../include/header.php");
include_once("../include/topbar.php");
include_once("../include/sidebar.php"); ?>

<?php


include("include/header.php");

// Fetch all orders
$orders_result = mysqli_query($conns, "SELECT COUNT(*) as total FROM orders");
$row = mysqli_fetch_assoc($orders_result);
$total_orders = $row['total'];


//Fetch all contact
$orders_result = mysqli_query($conns, "SELECT COUNT(*) as total FROM contact");
$row = mysqli_fetch_assoc($orders_result);
$total_contact = $row['total'];

//Fetch all product
$orders_result = mysqli_query($conns, "SELECT COUNT(*) as total FROM products");
$row = mysqli_fetch_assoc($orders_result);
$total_products = $row['total'];

//Fetch all order items
$orders_result = mysqli_query($conns, "SELECT COUNT(*) as total FROM order_items");
$row = mysqli_fetch_assoc($orders_result);
$total_order_items = $row['total'];
?>




<!--Main content start-->

<main class="mt-1 pt-3">
  <div class="container-flude">
    <!--Cards-->

    <div class="container mt-5">
      <div class="card p-4">
        <h3>Welcome <?php echo $admin_name; ?>!</h3>
        <p>This is your dashboard.</p>



        <div class="row dashboard-counts">
          <div class="col-12">
            <h4 class="fw-bold text-uppercase "> dashbord</h4>
            <p>Statistics of the system</p>
          </div>

          <div class="col-md-3">
            <div class="card">
              <div class="card-body text-center">
                <h6 class="card-title text-uppercase text-muted">total orders</h6>
                <h1><?php echo $total_orders ?></h1>
                <a href="../admin/orders_operation.php" class="card-link link-underline-light">view more</a>

              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card">
              <div class="card-body text-center">
                <h6 class="card-title text-uppercase text-muted">Total Contact</h6>
                <h1><?php echo $total_contact ?></h1>
                <a href="../admin/contact_operation.php" class="card-link link-underline-light">view more</a>

              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card">
              <div class="card-body text-center">
                <h6 class="card-title text-uppercase text-muted">TOTAL PRODUCT</h6>
                <h1><?php echo $total_products ?> </h1>
                <a href="../admin/product_add_operation.php" class="card-link link-underline-light">view more</a>

              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card">
              <div class="card-body text-center">
                <h6 class="card-title text-uppercase text-muted">TOTAL ORDER ITEMS</h6>
                <h1><?php echo $total_order_items ?> </h1>
                <a href="../admin/order_items_operation.php" class="card-link link-underline-light">view more</a>

              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>

</main>

<!--Main content end-->
<script>
  function handleClick(id){
    const form = document.getElementById(id)
    if(form.style.display=='none'){
      form.style.display ='';
    }else{
      form.style.display = 'none'
    }
  }

</script>


<?php include_once("../include/footer.php"); ?>
<?php include("include/footer.php"); ?>