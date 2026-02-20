<?php
include("../connection1.php");

/*====================== PAGINATION SETTINGS ==========================*/ 
$perPage=10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page-1) * $perPage; 

/* ================= DELETE ORDER ================= */
if (isset($_GET['delete_id'])) {
  $delete_id = $_GET['delete_id'];
  mysqli_query($conns, "DELETE FROM orders WHERE order_id=$delete_id");
  header("Location: orders_operation.php");
  exit();
}

/* ================= UPDATE ORDER ================= */
if (isset($_POST['update_order'])) {
  $order_id = $_POST['order_id'];
  $order_status = $_POST['order_status'];

  mysqli_query(
    $conns,
    "UPDATE orders SET order_status='$order_status' WHERE order_id=$order_id"
  );

  header("Location: orders_operation.php");
  exit();
}

/* ================= FETCH ORDERS ================= */
$orders = mysqli_query($conns, "SELECT * FROM orders ORDER BY order_id DESC LIMIT $start,$perPage");

/*==============total order_items  & page=============*/
$totalOrdersQuery = mysqli_query($conns, "SELECT COUNT(*) AS total FROM orders");
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
        <i class="bi bi-list-check me-2"></i>Order List
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover align-middle text-center">
            <tr>
              <th>S.N</th>
              <th>Order_Cost</th>
              <th>Order_Status</th>
              <th>User_ID</th>
              <th>User_Phone</th>
              <th>User_City</th>
              <th>User_Address</th>
              <th>Order_Date</th>
              <th>Action</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($orders)) { ?>
              <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $row['order_cost']; ?></td>
                <td><?php echo $row['order_status']; ?></td>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['user_phone']; ?></td>
                <td><?php echo $row['user_city']; ?></td>
                <td><?php echo $row['user_address']; ?></td>
                <td><?php echo $row['order_date']; ?></td>
                <td>
                  <a href="javascript:void(0)" onclick="document.getElementById('edit-<?php echo $row['order_id']; ?>').style.display='table-row'"
                    class="btn btn-sm btn-primary mb-1">Edit</a>

                  <a href="?delete_id=<?php echo $row['order_id']; ?>"
                    onclick="return confirm('Are you sure to delete this item?')"
                    class="btn btn-sm btn-danger mb-1">Delete</a>
                </td>
              </tr>

              <!-- Inline Edit Form -->
              <tr id="edit-<?php echo $row['order_id']; ?>" style="display:none;">
                <td colspan="8">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header">
                        update the form
                      </div>
                      <div class="card-body">
                        <form method="post" class="row g-2">
                          <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">

                          <div class="col-md-4">
                            <label>Status</label>
                            <select name="order_status" class="form-select" required>
                              <option value="pending" <?= ($row['order_status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                              <option value="completed" <?= ($row['order_status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                            </select>
                          </div>

                          <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" name="update_order" class="btn btn-success">Update</button>
                            <a href="javascript:void(0)" onclick="document.getElementById('edit-<?php echo $row['order_id']; ?>').style.display='none'" class="btn btn-secondary ms-2">Cancel</a>
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
