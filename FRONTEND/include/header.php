<?php
include('../connection1.php');

//active slides only fecth 
$result = mysqli_query($conns,"SELECT *FROM carousel_slides WHERE is_active=1 ORDER BY slide_order ASC");

$slides=[];
while($row = mysqli_fetch_assoc($result)){
    $slides[] = $row;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LadyCollection</title>

    <link rel="stylesheet" href="../assets/css/e-com.css">
    <link rel="stylesheet" href="../assets/css/login.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    
  <link rel="stylesheet" href="style.css">
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
                        <a class="nav-link pe-4 active" href="contact.php">Contact Us</a>

                    </li>

                    <!-- Cart Icon -->
                    <li class="nav-item">
                        <a class="nav-link" href="./cart.php">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                    </li>
                    <!--user-->
                    <li class="nav-item">
                        <a class="nav-link" href="account.php">
                            <i class="fa-solid fa-user"></i>
                        </a>
                    </li>

                    <!-- Admin Login -->
                    <li class="nav-item">
                        <a class="nav-link pe-4 text-danger fw-semibold" href="../admin/login.php">
                            <i class="fa-solid fa-user-shield"></i> Admin
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <!--navbar end-->

    <!--carousel start-->
   <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <?php foreach($slides as $index => $slide){ ?>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $index; ?>" <?php if($index==0) echo 'class="active" aria-current="true"'; ?> aria-label="Slide <?php echo $index+1; ?>"></button>
    <?php } ?>
  </div>

  <div class="carousel-inner">
    <?php foreach($slides as $index => $slide){ ?>
      <div class="carousel-item <?php if($index==0) echo 'active'; ?>">
        <img src="../image_upload/<?php echo $slide['image']; ?>" 
     class="d-block mx-auto" 
     alt="Slide <?php echo $index+1; ?>" 
     style="width:100%; height:500px; object-fit:cover;">

        <div class="carousel-caption d-none d-md-block text-<?php echo $slide['position']; ?>">
          <?php if($slide['subtitle']){ ?>
            <h6><?php echo $slide['subtitle']; ?></h6>
          <?php } ?>
          <?php if($slide['title1']){ ?>
            <h4><?php echo $slide['title1']; ?></h4>
          <?php } ?>
          <?php if($slide['title2']){ ?>
            <h2><?php echo $slide['title2']; ?></h2>
          <?php } ?>
          <?php if($slide['button_text']){ ?>
            <a href="#" class="btn btn-primary"><?php echo $slide['button_text']; ?></a>
          <?php } ?>
        </div>
      </div>
    <?php } ?>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>


    <!--carousel end-->