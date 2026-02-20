<?php
include("../connection1.php");

// ====== PAGINATION SETTINGS ======
$perPage = 10; // 15 products per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $perPage;



/* ================= DELETE ITEM ================= */
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    mysqli_query($conns, "DELETE FROM order_items WHERE item_id=$delete_id");
    header("Location: order_items_operation.php");
    exit();
}

/* ================= UPDATE ITEM ================= */
if (isset($_POST['update_item'])) {
    $item_id = $_POST['item_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];

    mysqli_query(
        $conns,
        "UPDATE order_items SET 
            product_name='$product_name',
            product_price='$product_price',
            product_quantity='$product_quantity'
         WHERE item_id=$item_id"
    );

    header("Location: order_items_operation.php");
    exit();
}

/* ================= FETCH ITEMS ================= */
$items = mysqli_query($conns, "SELECT * FROM order_items ORDER BY item_id DESC LIMIT $start,$perPage");

/*==============total order_items  & page=============*/
$totalOrdersQuery = mysqli_query($conns, "SELECT COUNT(*) AS total FROM order_items");
$totalOrdersRow = mysqli_fetch_assoc($totalOrdersQuery);
$totalorders = $totalOrdersRow['total'];
$totalPages = ceil($totalorders / $perPage);

// Serial number starts from current page
$sn = $start + 1;
?>

<?php include_once("../include/header.php"); ?>
<?php include_once("../include/topbar.php"); ?>
<?php include_once("../include/sidebar.php"); ?>

<div class="main-content">
    <main class="mt-1 pt-3">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-list-check me-2"></i>Order Items List
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover align-middle text-center">
                        <tr>
                            <th>S.N</th>
                            <th>Product_name</th>
                            <th>Image</th>
                            <th>Product_price</th>
                            <th>Product_quantity</th>
                            <th>User_Id</th>
                            <th>Action</th>
                        </tr>

                        <?php while ($row = mysqli_fetch_assoc($items)) { ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo $row['product_name']; ?></td>
                                <td><img src="../image_upload/<?php echo $row['image']; ?>" width="50"></td>
                                <td><?php echo $row['product_price']; ?></td>
                                <td><?php echo $row['product_quantity']; ?></td>
                                <td><?php echo $row['user_id']; ?></td>
                                <td>
                                    <a href="javascript:void(0)" onclick="document.getElementById('edit-<?php echo $row['item_id']; ?>').style.display='table-row'"
                                        class="btn btn-sm btn-primary mb-1">Edit</a>

                                    <a href="?delete_id=<?php echo $row['item_id']; ?>"
                                        onclick="return confirm('Are you sure to delete this item?')"
                                        class="btn btn-sm btn-danger mb-1">Delete</a>
                                </td>
                            </tr>

                            <!-- Inline Edit Form -->
                            <tr id="edit-<?php echo $row['item_id']; ?>" style="display:none;">
                                <td colspan="8">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                update the form
                                            </div>
                                            <div class="card-body">
                                                <form method="post" enctype="multipart/form-data" class="row g-2">
                                                    <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Product_name</label>
                                                            <input type="text" name="product_name" class="form-control"
                                                                value="<?php echo $row['product_name']; ?>" required>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-label">Product_price</label>
                                                            <input type="number" name="product_price" class="form-control"
                                                                value="<?php echo $row['product_price']; ?>" required>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-label">Product_quantity</label>
                                                            <input type="number" name="product_quantity" class="form-control"
                                                                value="<?php echo $row['product_quantity']; ?>" required>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-label">Image</label>
                                                            <input type="file" name="image" class="form-control">
                                                        </div>

                                                        <div class="col-md-3">
                                                            <button type="submit" name="update_item" class="btn btn-success">Update</button>
                                                            <a href="javascript:void(0)" onclick="document.getElementById('edit-<?php echo $row['item_id']; ?>').style.display='none'" class="btn btn-secondary">Cancel</a>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination Links -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="order_items_operation.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>

                    </li>
                <?php } ?>
            </ul>
        </nav>
    </main>
</div>

<?php include_once("../include/footer.php"); ?>