<?php 
session_start();
include('../connection1.php');
include_once("../include/header.php");
include_once("../include/topbar.php");
include_once("../include/sidebar.php");


// 🔒 Login check
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Fetch current admin info
$result = mysqli_query($conns, "SELECT * FROM admin WHERE id = $admin_id LIMIT 1");
if($result && mysqli_num_rows($result) > 0){
    $admin = mysqli_fetch_assoc($result);
} else {
    die("Admin info not found");
}

// Handle profile image upload
if(isset($_FILES['profile_image']) && $_FILES['profile_image']['name'] != ''){
    $image_name = $_FILES['profile_image']['name'];
    $tmp_name = $_FILES['profile_image']['tmp_name'];

    // Rename image to avoid duplicates
    $image_new_name = time().'_'.$image_name;
    $upload_dir = "../image_upload/";

    // Create folder if not exists
    if(!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    // Move uploaded file
    if(move_uploaded_file($tmp_name, $upload_dir.$image_new_name)){
        // Update database
        $query = "UPDATE admin SET profile_image='$image_new_name' WHERE id=$admin_id";
        mysqli_query($conns, $query);

        // Refresh admin array to get new image
        $result = mysqli_query($conns, "SELECT * FROM admin WHERE id = $admin_id LIMIT 1");
        $admin = mysqli_fetch_assoc($result);
    } else {
        echo "<div class='alert alert-danger'>Image upload failed!</div>";
    }
}
?>

<div class="container mt-5">
  <div class="card shadow-sm border-0" style="max-width: 400px; margin:auto; border-radius: 15px;">
    
    <div class="card-body text-center p-4">
      
      <!-- Profile Image -->
      <div class="mb-3">
        <img src="../image_upload/<?php echo !empty($admin['profile_image']) ? $admin['profile_image'] : 'default.png'; ?>" 
             alt="Profile Image" class="rounded-circle img-fluid" style="width: 120px; height:120px; object-fit:cover; border:4px solid #007bff;">
      </div>

      <!-- Admin Name -->
      <h3 class="mb-1 fw-bold"><?php echo $admin['username']; ?></h3>

      <!-- Admin Email -->
      <p class="text-muted mb-3"><?php echo $admin['email']; ?></p>

      <!-- Upload Form -->
      <form action="" method="post" enctype="multipart/form-data" class="d-flex flex-column align-items-center gap-2">
        <input class="form-control form-control-sm" type="file" name="profile_image" accept="image/*" required>
        <button type="submit" class="btn btn-primary btn-sm mt-2 w-50">Update Picture</button>
      </form>

    
    </div>
    
  </div>
</div>


<?php include_once("../include/footer.php"); ?>
