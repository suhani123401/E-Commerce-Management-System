<?php
session_start();
include('../connection1.php');
include('include/header.php');

// using function

function get_products_by_category($conns, $category)
{
  $stmt = $conns->prepare("SELECT * FROM products WHERE category = ?");
  if (!$stmt) {
    die("Prepare failed: " . $conns->error);
  }
  $stmt->bind_param("s", $category); //s-string ho
  $stmt->execute();
  return $stmt->get_result();
}

// fetch all categories

$lipstick_products = get_products_by_category($conns, 'lipstick');
$dress_products = get_products_by_category($conns, 'dress');
$shoes_products = get_products_by_category($conns, 'shoes');
?>








  <!--Brand-->
  <section id="brand" class="container py-4">
    <h1 class="text-center mb-5 fw-bold">Brand COLLECTION</h1>
    <div class="row m-0 text-center">

      <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
        <img class="brand-img" src="./images/brand5.jpg" alt="brand image">
      </div>

      <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
        <img class="brand-img" src="./images/brand2.jpg" alt="brand image">
      </div>

      <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
        <img class="brand-img" src="./images/brand3.webp" alt="brand image">
      </div>

      <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
        <img class="brand-img" src="./images/brand4.jpg" alt="brand image">
      </div>

    </div>
  </section>

  <!--dress coloction-->
  <div class="container">
    <h1 class="text-center mb-5 fw-bold">Dress COLLECTION</h1>
    <div class="row g-4">
      <?php while ($row = $dress_products->fetch_assoc()) { ?>
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
          <div class="card border-0 shadow-sm">
            <img src="../image_upload/<?php echo $row['image']; ?>" class="card-img-top" alt="Product Image">
            <div class="rating mb-2 d-flex justify-content-center">
              <span style="color: gold; font-size: 18px;">&#9733;</span>
              <span style="color: gold; font-size: 18px;">&#9733;</span>
              <span style="color: gold; font-size: 18px;">&#9733;</span>
              <span style="color: gold; font-size: 18px;">&#9734;</span>
              <span style="color: gold; font-size: 18px;">&#9734;</span>
            </div>
            <div class="card-body text-center">
              <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
              <h3 class="card-title"><?php echo $row['product_quantity']; ?></h3>
              <p class="card-text">
                <small><del class="text-muted"><?php echo $row['price']; ?></del></small>
              </p>
              <form action="single_product.php" method="GET">
                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="buy-btn">Details</button>
              </form>

            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>


  <!--lipstick collection-->
  <div class="container">
    <h1 class="text-center mb-5 fw-bold">Lipstick COLLECTION</h1>
    <div class="row g-4">
      <?php while ($row = $lipstick_products->fetch_assoc()) { ?>
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
          <div class="card border-0 shadow-sm">
            <img src="../image_upload/<?php echo $row['image']; ?>" class="card-img-top" alt="Product Image">
            <div class="rating mb-2 d-flex justify-content-center">
              <span style="color: gold; font-size: 18px;">&#9733;</span>
              <span style="color: gold; font-size: 18px;">&#9733;</span>
              <span style="color: gold; font-size: 18px;">&#9733;</span>
              <span style="color: gold; font-size: 18px;">&#9734;</span>
              <span style="color: gold; font-size: 18px;">&#9734;</span>
            </div>
            <div class="card-body text-center">
              <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
              <h3 class="card-title"><?php echo $row['product_quantity']; ?></h3>
              <p class="card-text">
                <small><del class="text-muted"><?php echo $row['price']; ?></del></small>
              </p>
              <form action="single_product.php" method="GET">
                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="buy-btn">Details</button>
              </form>

            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>


  <!--shoe collection-->
  <div class="container">
    <h1 class="text-center mb-5 fw-bold">Shoes COLLECTION</h1>
    <div class="row g-4">
      <?php while ($row = $shoes_products->fetch_assoc()) { ?>
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
          <div class="card border-0 shadow-sm">
            <img src="../image_upload/<?php echo $row['image']; ?>" class="card-img-top" alt="Product Image">
            <div class="rating mb-2 d-flex justify-content-center">
              <span style="color: gold; font-size: 18px;">&#9733;</span>
              <span style="color: gold; font-size: 18px;">&#9733;</span>
              <span style="color: gold; font-size: 18px;">&#9733;</span>
              <span style="color: gold; font-size: 18px;">&#9734;</span>
              <span style="color: gold; font-size: 18px;">&#9734;</span>
            </div>
            <div class="card-body text-center">
              <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
              <h3 class="card-title"><?php echo $row['product_quantity']; ?></h3>
              <p class="card-text">
                <small><del class="text-muted"><?php echo $row['price']; ?></del></small>
              </p>
              <form action="single_product.php" method="GET">
                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="buy-btn">Details</button>
              </form>

            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>








  

  <script>
    // Back to Top functionality
    let btn = document.getElementById('backToTop');
    window.onscroll = function() {
      if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
        btn.style.display = "block";
      } else {
        btn.style.display = "none";
      }
    };
    btn.onclick = function() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    };


    function popup(popup_name) {
      let get_popup = document.getElementById(popup_name);
      if (get_popup.style.display === "flex") {
        get_popup.style.display = "none";
      } else {
        get_popup.style.display = "flex";
      }
    }
  </script>

  <?php include('include/footer.php'); ?>
