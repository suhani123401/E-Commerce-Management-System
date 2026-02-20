<?php
include("../connection1.php");
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ====== PAGINATION SETTINGS ======
$perPage = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $perPage;

// ====== ADD SLIDE ======
if (isset($_POST['add_slide'])) {
    $subtitle = $_POST['subtitle'] ?? '';
    $title1 = $_POST['title1'] ?? '';
    $title2 = $_POST['title2'] ?? '';
    $button_text = $_POST['button_text'] ?? '';
    $position = $_POST['position'] ?? 'center';
    $is_active = $_POST['is_active'] ?? 1;
    $slide_order = $_POST['slide_order'] ?? 0;

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $newImageName = pathinfo($image_name, PATHINFO_FILENAME) . "_" . date('His') . "." . pathinfo($image_name, PATHINFO_EXTENSION);
        $upload_dir = "../image_upload/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        if (move_uploaded_file($tmp_name, $upload_dir . $newImageName)) {
            $insertQuery = "INSERT INTO carousel_slides(image, subtitle, title1, title2, button_text, position, is_active, slide_order)
                            VALUES('$newImageName','$subtitle','$title1','$title2','$button_text','$position','$is_active','$slide_order')";
            $result = mysqli_query($conns, $insertQuery);
            if ($result) {
                header("Location: carousel_admin.php?msg=Slide added successfully");
                exit();
            } else {
                die("DB Error: " . mysqli_error($conns));
            }
        } else {
            die("Failed to upload image.");
        }
    } else {
        die("No image uploaded.");
    }
}

// ====== EDIT SLIDE ======
if (isset($_POST['action']) && $_POST['action'] == 'edit_slide') {
    $id = $_POST['id'];
    $subtitle = $_POST['subtitle'] ?? '';
    $title1 = $_POST['title1'] ?? '';
    $title2 = $_POST['title2'] ?? '';
    $button_text = $_POST['button_text'] ?? '';
    $position = $_POST['position'] ?? 'center';
    $is_active = $_POST['is_active'] ?? 1;
    $slide_order = $_POST['slide_order'] ?? 0;

    if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $newImageName = time() . '_' . $image_name;
        move_uploaded_file($tmp_name, "../image_upload/" . $newImageName);
        $query = "UPDATE carousel_slides SET subtitle='$subtitle', title1='$title1', title2='$title2', button_text='$button_text',
                  position='$position', is_active='$is_active', slide_order='$slide_order', image='$newImageName' WHERE id='$id'";
    } else {
        $query = "UPDATE carousel_slides SET subtitle='$subtitle', title1='$title1', title2='$title2', button_text='$button_text',
                  position='$position', is_active='$is_active', slide_order='$slide_order' WHERE id='$id'";
    }
    mysqli_query($conns, $query);
    header("Location: carousel_admin.php");
    exit();
}

// ====== DELETE SLIDE ======
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = intval($_GET['id']);
    $deleteQuery = "DELETE FROM carousel_slides WHERE id=$id";
    $result = mysqli_query($conns, $deleteQuery);
    if ($result) {
        echo "<script>alert('Slide deleted successfully'); window.location='carousel_admin.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conns);
    }
}

// ====== FETCH SLIDES ======
$sql = "SELECT * FROM carousel_slides ORDER BY slide_order ASC LIMIT $start,$perPage";
$result = mysqli_query($conns, $sql);

$totalSlidesQuery = mysqli_query($conns, "SELECT COUNT(*) AS total FROM carousel_slides");
$totalSlidesRow = mysqli_fetch_assoc($totalSlidesQuery);
$totalSlides = $totalSlidesRow['total'];
$totalPages = ceil($totalSlides / $perPage);

$sn = $start + 1;
$msg = $_GET['msg'] ?? '';
if ($msg) echo "<script>alert('$msg');</script>";
?>

<?php include_once("../include/header.php"); ?>
<?php include_once("../include/topbar.php"); ?>
<?php include_once("../include/sidebar.php"); ?>

<div class="main-content">
    <main class="mt-1 pt-3">
        <div class="container-fluid">

            <button onclick="toggleForm('slide_add_form')" class="btn btn-primary mb-3">Add Slide</button>

            <div class="col-md-12" id="slide_add_form" style="display:none;">
                <div class="card">
                    <div class="card-header">Add New Slide</div>
                    <div class="card-body">
                        <form method="post" action="carousel_admin.php" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Slide Image</label>
                                    <input type="file" class="form-control" name="image" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Subtitle</label>
                                    <input type="text" class="form-control" name="subtitle">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Title 1</label>
                                    <input type="text" class="form-control" name="title1">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Title 2</label>
                                    <input type="text" class="form-control" name="title2">
                                </div>
                               
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Text Position</label>
                                    <select class="form-control" name="position">
                                        <option value="start">Start</option>
                                        <option value="center" selected>Center</option>
                                        <option value="end">End</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Active</label>
                                    <select class="form-control" name="is_active">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Slide Order</label>
                                    <input type="number" class="form-control" name="slide_order" value="0">
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" name="add_slide" class="btn btn-success">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Slides Table -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white fw-bold">Slide List</div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle">
                        <tr>
                            <th>S.N</th>
                            <th>Image</th>
                            <th>Subtitle</th>
                            <th>Title1</th>
                            <th>Title2</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Action</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><img src="../image_upload/<?php echo $row['image']; ?>" width="50"></td>
                                <td><?php echo $row['subtitle']; ?></td>
                                <td><?php echo $row['title1']; ?></td>
                                <td><?php echo $row['title2']; ?></td>
            
                                <td><?php echo $row['position']; ?></td>
                                <td><?php echo $row['is_active'] ? 'Active' : 'Inactive'; ?></td>
                                <td><?php echo $row['slide_order']; ?></td>
                                <td>
                                    <a href="javascript:void(0)" onclick="toggleForm('edit-<?php echo $row['id']; ?>')" class="btn btn-sm btn-primary mb-1">Edit</a>
                                    <a href="carousel_admin.php?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger mb-1">Delete</a>
                                </td>
                            </tr>

                            <!-- Edit Form -->
                            <tr id="edit-<?php echo $row['id']; ?>" style="display:none;  border: 2px solid #007bff; border-radius:10px;">
                                <td colspan="10">
                                    <form method="post" action="carousel_admin.php" enctype="multipart/form-data">
                                        <input type="hidden" name="action" value="edit_slide">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <div class="row">
                                            <!-- Slide Image -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Slide Image</label>
                                                <input type="file" class="form-control" name="image">
                                            </div>

                                            <!-- Subtitle -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Subtitle</label>
                                                <input type="text" class="form-control" name="subtitle" value="<?php echo $row['subtitle']; ?>">
                                            </div>

                                            <!-- Title 1 -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Title 1</label>
                                                <input type="text" class="form-control" name="title1" value="<?php echo $row['title1']; ?>">
                                            </div>

                                            <!-- Title 2 -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Title 2</label>
                                                <input type="text" class="form-control" name="title2" value="<?php echo $row['title2']; ?>">
                                            </div>

                                        
                                        

                                            <!-- Text Position -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Text Position</label>
                                                <select class="form-control" name="position">
                                                    <option value="start" <?php if ($row['position'] == 'start') echo 'selected'; ?>>Start</option>
                                                    <option value="center" <?php if ($row['position'] == 'center') echo 'selected'; ?>>Center</option>
                                                    <option value="end" <?php if ($row['position'] == 'end') echo 'selected'; ?>>End</option>
                                                </select>
                                            </div>

                                            <!-- Active Status -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Active</label>
                                                <select class="form-control" name="is_active">
                                                    <option value="1" <?php if ($row['is_active']) echo 'selected'; ?>>Active</option>
                                                    <option value="0" <?php if (!$row['is_active']) echo 'selected'; ?>>Inactive</option>
                                                </select>
                                            </div>

                                            <!-- Slide Order -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Slide Order</label>
                                                <input type="number" class="form-control" name="slide_order" value="<?php echo $row['slide_order']; ?>">
                                            </div>

                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>

                        <?php } ?>
                    </table>

                    <!-- Pagination -->
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                    <a class="page-link" href="carousel_slides.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>

                </div>
            </div>

        </div>
    </main>
</div>

<script>
    function toggleForm(id) {
        const el = document.getElementById(id);
        if (el.style.display === "none") el.style.display = "block";
        else el.style.display = "none";
    }
</script>

<?php include_once("../include/footer.php"); ?>