<?php include("../connection1.php"); ?>
<?php




ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



// ====== PAGINATION SETTINGS ======
$perPage = 10; // 10 products per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $perPage;



// ========== ADD PRODUCT ==========
if (isset($_POST['add_product'])) {
    // Sanitize inputs to avoid SQL issues
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = intval($_POST['price']);

    $product_quantity = $_POST['stock'];
    $status = $_POST['status'];


    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];

        $newImageName = pathinfo($image_name, PATHINFO_FILENAME) . "_" . date('His') . "." . pathinfo($image_name, PATHINFO_EXTENSION);

        $upload_dir = "../image_upload/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        if (move_uploaded_file($tmp_name, $upload_dir . $newImageName)) {
            // Insert into database
            $insertquery = "INSERT INTO products(product_name, description, category, price, product_quantity, image, status) 
                            VALUES ('$product_name','$description','$category','$price','$product_quantity','$newImageName','$status')";

            $result = mysqli_query($conns, $insertquery);
            if ($result) {
                $_SESSION['status'] = "Product added successfully";
                header("Location: product_add_operation.php?msg=Product added successfully");
                exit();
            } else {
                die("DB Error: " . mysqli_error($conns)); // Show exact database error
            }
        } else {
            die("Failed to upload image. Check folder permissions and path.");
        }
    } else {
        die("No image file uploaded.");
    }
}



// ========== UPDATE PRODUCT ========== (put this first)
if (isset($_POST['action']) && $_POST['action'] == 'edit_product') {
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $product_quantity = $_POST['product_quantity'];
    $status = $_POST['status'];

    if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $newImageName = time() . '_' . $image_name;
        move_uploaded_file($tmp_name, "../image_upload/" . $newImageName);
        $query = "UPDATE products SET 
                    product_name='$product_name',
                    description='$description',
                    category='$category',
                    price='$price',
                    product_quantity='$product_quantity',
                    image='$newImageName',
                    status='$status'
                  WHERE id='$id'";
    } else {
        $query = "UPDATE products SET 
                    product_name='$product_name',
                    description='$description',
                    category='$category',
                    price='$price',
                    product_quantity='$product_quantity',
                    status='$status'
                  WHERE id='$id'";
    }

    mysqli_query($conns, $query);
    header("Location:product_add_operation.php"); // redirect to refresh page
    exit();
}



// ========== FETCH ALL PRODUCTS ==========
$result = mysqli_query($conns, "SELECT * FROM products");

// ========== DELETE PRODUCT ==========
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = intval($_GET['id']);
    $deleteQuery = "DELETE FROM products WHERE id = $id";
    $result = mysqli_query($conns, $deleteQuery);
    if ($result) {
        echo "<script>alert('order deleted successfully'); window.location='product_add_operation.php';</script>";
    } else {
        echo "Error : " . mysqli_error($conns);
    }
}



// ========== FETCH ALL PRODUCTS ==========
$sql = "SELECT * FROM products ORDER BY id DESC LIMIT $start,$perPage";
$result = mysqli_query($conns, $sql);

if (!$result) {
    die("Error fetching products: " . mysqli_error($conns));
}

/*==============total products & page=============*/
$totalProductsQuery = mysqli_query($conns, "SELECT COUNT(*) AS total FROM products");
$totalProductsRow = mysqli_fetch_assoc($totalProductsQuery);
$totalProducts = $totalProductsRow['total'];
$totalPages = ceil($totalProducts / $perPage);

// Serial number starts from current page
$sn = $start + 1;


// Show message if redirected after delete
$errorMessage = $_GET['msg'] ?? '';
if ($errorMessage) {
    echo "<script>alert('$errorMessage');</script>";
}
?>

<?php include_once("../include/header.php"); ?>
<?php include_once("../include/topbar.php"); ?>
<?php include_once("../include/sidebar.php"); ?>
<div class="main-content">


    <main class="mt-1 pt-3">
        <div class="container-fluid">
            <div class="row dashboard-counts">

                <button onclick="handleClick('product_add_form')" style="background-color: #007bff;color:white;padding:10px 20px;border:none;border-radius:6px;font-size:16px;font-weight:600;cursor:pointer;">Add Product</button>
                <div class="col-md-12" id="product_add_form" style="display: none;">
                    <div class="card">
                        <div class="card-header">
                            Fill the form
                        </div>
                        <div class="card-body">
                            <form method="post" action="product_add_operation.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Product_name</label>
                                        <input type="text" class="form-control" name="product_name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Description</label>
                                        <input type="text" class="form-control" name="description" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">category</label>
                                        <input type="text" class="form-control" name="category" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Price</label>
                                        <input type="number" class="form-control" id="price" name="price" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Stock</label>
                                        <input type="number" class="form-control" id="stock" name="stock" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Total_Amount</label>
                                        <input type="number" class="form-control" id="total_amount" name="total_amount" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">category_Image</label>
                                        <input type="file" class="form-control" name="image" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">InActive</option>

                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" name="add_product" class="btn btn-success">Submit</button>
                                        <button type="reset" class="btn btn-secondary">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>






        <br>
        <br>
        <br>
        <div class="card shadow-sm mb-4" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-list-check me-2"></i>Product List
            </div>
            <div class="card-body">
                <div class="table-responsive" id="product-tab-pane">
                    <table class="table table-striped table-bordered table-hover align-middle text-center">
                        <tr>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo $row['product_name']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php echo $row['category']; ?></td>
                                <td><?php echo $row['price']; ?></td>
                                <td><?php echo $row['product_quantity']; ?></td>
                                <td><img src="../image_upload/<?php echo $row['image']; ?>" width="50"></td>
                                <td><?php echo $row['status']; ?></td>
                                <td>
                                    <a href="javascript:void(0)" onclick="document.getElementById('edit-<?php echo $row['id']; ?>').style.display='table-row'" style="padding:5px 12px; background-color:#007bff; color:white; border-radius:4px; text-decoration:none; font-size:14px; margin-right:5px;">Edit</a> |

                                    <a href="product_add_operation.php?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')" style="padding:5px 12px; background-color:#dc3545; color:white; border-radius:4px; text-decoration:none; font-size:14px; margin-left:5px;">Delete</a>

                                </td>
                            </tr>

                            <!-- Inline Edit Form -->
                            <tr id="edit-<?php echo $row['id']; ?>" style="display:none;">
                                <td colspan="8">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                update the form
                                            </div>
                                            <div class="card-body">
                                                <form method="post" action="product_add_operation.php" enctype="multipart/form-data">
                                                    <input type="hidden" name="action" value="edit_product">
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Product_name</label>
                                                            <input type="text" class="form-control" name="product_name" value="<?php echo $row['product_name']; ?>" required>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Description</label>
                                                            <input type="text" class="form-control" name="description" value="<?php echo $row['description']; ?>" required>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Category</label>
                                                            <input type="text" class="form-control" name="category" value="<?php echo $row['category']; ?>" required>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Price</label>
                                                            <input type="number" class="form-control" name="price" value="<?php echo $row['price']; ?>" required>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Stock</label>
                                                            <input type="number" class="form-control" name="stock" value="<?php echo $row['product_quantity']; ?>" required>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Image</label>
                                                            <input type="file" class="form-control" name="image">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Status</label>
                                                            <select name="status" class="form-control" required>
                                                                <option value="active" <?php if ($row['status'] == 'active') echo 'selected'; ?>>Active</option>
                                                                <option value="inactive" <?php if ($row['status'] == 'inactive') echo 'selected'; ?>>InActive</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-primary">UPDATE</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

        
                    <!-- Pagination Links -->
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php for($i=1;$i<=$totalPages;$i++) { ?>
                                <li class="page-item <?php if($i==$page) echo 'active'; ?>">
                                    <a class="page-link" href="product_add_operation.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>

                

    </main>
</div>

<script>
    // Function to calculate total
    function calculateTotal() {
        const price = parseFloat(document.getElementById("price").value) || 0;
        const stock = parseFloat(document.getElementById("stock").value) || 0;

        document.getElementById("total_amount").value = price * stock;
    }

    // Listen for changes on price & quantity
    document.getElementById("price").addEventListener("input", calculateTotal);
    document.getElementById("stock").addEventListener("input", calculateTotal);
</script>


<?php
include_once("../include/footer.php");
?>
