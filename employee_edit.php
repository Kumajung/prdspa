<?php require 'config/connect.php'; ?>
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
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
        $salary = mysqli_real_escape_string($conn, $_POST['salary']);
        $position_id = mysqli_real_escape_string($conn, $_POST['position_id']);
        $sql = " UPDATE employees SET first_name = '$first_name', 
                                      last_name = '$last_name',
                                      telephone = '$telephone',
                                      salary = '$salary',
                                      position_id = '$position_id'
                                      WHERE employee_id = '$edit_id' ";
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
                        window.location.href = 'employee.php';
                    });
                })
            </script>
    <?php
        }
    }
    ?>
    <?php
    if (isset($_GET['edit_id'])) {
        $edit_id = mysqli_real_escape_string($conn, $_GET['edit_id']);
        $sql_edit = " SELECT * FROM employees WHERE employee_id = '$edit_id' ";
        $result_edit = mysqli_query($conn, $sql_edit);
        $num_edit = mysqli_num_rows($result_edit);
        if ($num_edit === 0) {
            header('Location:employee.php');
            exit;
        }
        $rs_edit = mysqli_fetch_assoc($result_edit);
    }
    ?>
    <main>
        <div class="container marketing">
            <h1 class="mb-3 py-5">ข้อมูลพนักงาน</h1>
            <div class="col-md-6 mx-auto mb-3">
                <form id="frm" method="POST">
                    <div class="card">
                        <div class="card-header">
                            <!-- employees_type -->
                            <i class="fa-solid fa-users"></i> ส่วนจัดพนักงาน
                        </div>
                        <div class="card-body">
                            <div class="form-group row mb-3">
                                <label for="first_name" class="col-sm-3 col-form-label">ชื่อ</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $rs_edit['first_name']; ?>" placeholder="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="last_name" class="col-sm-3 col-form-label">นามสกุล</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $rs_edit['last_name']; ?>" placeholder="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="telephone" class="col-sm-3 col-form-label">เบอร์โทรศัพท์</label>
                                <div class="col-sm-9">
                                    <input type="tel" class="form-control" id="telephone" name="telephone" value="<?php echo $rs_edit['telephone']; ?>" placeholder="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="salary" class="col-sm-3 col-form-label">เงินเดือน</label>
                                <div class="col-sm-9">
                                    <input type="number" step="0.01" class="form-control" id="salary" name="salary" value="<?php echo $rs_edit['salary']; ?>" placeholder="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="position_id" class="col-sm-3 col-form-label">ตำแหน่ง</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="position_id" id="position_id">
                                        <?php
                                        $sql = " SELECT * FROM positions ORDER BY position_id ASC ";
                                        $result = mysqli_query($conn, $sql);
                                        while ($rs = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <?php if ($rs['position_id'] == $rs_edit['position_id']) { ?>
                                                <option value="<?php echo $rs['position_id']; ?>" selected><?php echo $rs['position_name']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $rs['position_id']; ?>"><?php echo $rs['position_name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="offset-sm-3 col-sm-6 d-grid">
                                    <input type="hidden" name="edit_id" value="<?php echo $rs_edit['employee_id']; ?>">
                                    <button type="submit" name="submit" class="btn btn-warning"><i class="fa-regular fa-floppy-disk"></i> บันทึก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </ด>
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