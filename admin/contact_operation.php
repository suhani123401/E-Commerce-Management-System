<?php
include("../connection1.php");

/*===============S.N increase============ */
$sn=1;

/* ================= DELETE ITEM ================= */
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    mysqli_query($conns, "DELETE FROM contact WHERE id=$delete_id");
    header("Location: contact_operation.php");
    exit();
}

/* ================= UPDATE ITEM ================= */
if (isset($_POST['update_item'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    mysqli_query(
        $conns,
        "UPDATE contact SET 
            name='$name',
            email='$email',
            message='$message'
         WHERE id=$id"
    );

    header("Location: contact_operation.php");
    exit();
}

/* ================= FETCH ITEMS ================= */
$contact = mysqli_query($conns, "SELECT * FROM contact ORDER BY id DESC");
?>

<?php include_once("../include/header.php"); ?>
<?php include_once("../include/topbar.php"); ?>
<?php include_once("../include/sidebar.php"); ?>

<div class="main-content">
    <main class="mt-1 pt-3">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-list-check me-2"></i>Contact Items List
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover align-middle text-center">
                        <tr>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>

                        <?php while ($row = mysqli_fetch_assoc($contact)) { ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['message']; ?></td>
                                <td>
                                    <a href="javascript:void(0)" onclick="document.getElementById('edit-<?php echo $row['id']; ?>').style.display='table-row'"
                                        class="btn btn-sm btn-primary mb-1">Edit</a>

                                    <a href="?delete_id=<?php echo $row['id']; ?>"
                                        onclick="return confirm('Are you sure to delete this item?')"
                                        class="btn btn-sm btn-danger mb-1">Delete</a>
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
                                                <form method="post" enctype="multipart/form-data" class="row g-2">
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Name</label>
                                                            <input type="text" name="name" class="form-control"
                                                                value="<?php echo $row['name']; ?>" required>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" name="email" class="form-control"
                                                                value="<?php echo $row['email']; ?>" required>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-label">Message</label>
                                                            <input type="text" name="message" class="form-control"
                                                                value="<?php echo $row['message']; ?>" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="submit" name="update_item" class="btn btn-success">Update</button>
                                                            <a href="javascript:void(0)" onclick="document.getElementById('edit-<?php echo $row['id']; ?>').style.display='none'" class="btn btn-secondary">Cancel</a>
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
    </main>
</div>

<?php include_once("../include/footer.php"); ?>