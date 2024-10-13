<?php
require 'config/connect.php';
require 'config/function.php';
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="i-Spa, Inc.">
    <meta name="generator" content="Hugo 0.122.0">
    <title>SPA</title>
    <link href="./dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="dist/css/carousel.css" rel="stylesheet">
    <link href="dist/css/stlye.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php require 'layout/header.php'; ?>
    <?php
    if (isset($_POST['submit'])) {
        /* mysqli_real_escape_string ป้องกันการโจมตีแบบ SQL Injection (SQL Injection) */
        $edit_id = mysqli_real_escape_string($conn, $_POST['edit_id']);
        $package_name = mysqli_real_escape_string($conn, $_POST['package_name']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $sql = " UPDATE packages SET package_name = '$package_name',
                                     price = '$price'
                                     WHERE package_id = '$edit_id' ";
        $result = mysqli_query($conn, $sql);
        if ($result) {
    ?>
            <script>
                $(() => {
                    Swal.fire({
                        icon: "success",
                        title: 'บันทึกข้อมูลสำเร็จ',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = 'package.php';
                    });
                })
            </script>
    <?php
        }
    }
    if (isset($_GET['edit_id'])) {
        /* mysqli_real_escape_string ป้องกันการโจมตีแบบ SQL Injection (SQL Injection) */
        $edit_id = mysqli_real_escape_string($conn, $_GET['edit_id']);
        $sql_edit = " SELECT * FROM packages WHERE package_id = '$edit_id' ";
        $result_edit = mysqli_query($conn, $sql_edit);
        $rs_edit = mysqli_fetch_assoc($result_edit);
    }
    ?>
    <main>
        <div class="container marketing">
            <h1 class="mb-3 py-5">ข้อมูลแพ็กเกจ</h1>
            <div class="col-md-6 mx-auto mb-3">
                <form id="frm" method="post">
                    <div class="card">
                        <div class="card-header">
                            <!-- employees_type -->
                            <i class="fa-solid fa-gift"></i> ส่วนจัดการแพ็กเกจ
                        </div>
                        <div class="card-body">
                            <div class="form-group row mb-3">
                                <label for="package_name" class="col-sm-3 col-form-label">ชื่อแพ็กเกจ</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="package_name" name="package_name" value="<?php echo $rs_edit['package_name']; ?>" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="price" class="col-sm-3 col-form-label">ราคา</label>
                                <div class="col-sm-9">
                                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo $rs_edit['price']; ?>" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="offset-sm-3 col-sm-6 d-grid">
                                    <input type="hidden" name="edit_id" value="<?php echo $rs_edit['package_id']; ?>">
                                    <button type="submit" name="submit" class="btn btn-warning"><i class="fa-regular fa-floppy-disk"></i> บันทึก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <hr class="featurette-divider">
        </div>
        <!-- FOOTER -->
        <?php require './layout/footer.php'; ?>
    </main>
    <script src="./dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
</body>

</html>