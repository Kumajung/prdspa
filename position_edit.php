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
    <link rel="icon" type="image/png" href="dist/favicon/favicon-48x48.png" sizes="48x48" />
    <link rel="icon" type="image/svg+xml" href="dist/favicon/favicon.svg" />
    <link rel="shortcut icon" href="dist/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="dist/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="dist/favicon/site.webmanifest" />
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
    <main>
        <div class="container marketing">
            <h1 class="mb-3 py-5">ข้อมูลตำแหน่งพนักงาน</h1>
            <div class="col-lg-6 col-md-12 mx-auto mb-3">
                <?php

                if (isset($_POST['submit'])) {
                    /* mysqli_real_escape_string ป้องกันการโจมตีแบบ SQL Injection (SQL Injection) */
                    $edit_id = mysqli_real_escape_string($conn, $_POST['edit_id']);
                    $position_name = mysqli_real_escape_string($conn, $_POST['position_name']);
                    $commission_rate = mysqli_real_escape_string($conn, $_POST['commission_rate']);
                    $sql_edit = " UPDATE positions SET position_name = '$position_name',
                                                       commission_rate = '$commission_rate'
                                                       WHERE position_id = '$edit_id' ";
                    $result_edit = mysqli_query($conn, $sql_edit);
                    if ($result_edit) {
                ?>
                        <script>
                            $(() => {
                                Swal.fire({
                                    icon: "success",
                                    title: 'แก้ไขข้อมูลสำเร็จ',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.href = 'position.php';
                                })
                            })
                        </script>
                <?php
                    }
                }

                if (isset($_GET['edit_id'])) {
                    /* mysqli_real_escape_string ป้องกันการโจมตีแบบ SQL Injection (SQL Injection) */
                    $edit_id = mysqli_real_escape_string($conn, $_GET['edit_id']);
                    $sql = " SELECT * FROM positions WHERE position_id = '$edit_id' ";
                    $result = mysqli_query($conn, $sql);
                    $num = mysqli_num_rows($result);
                    if ($num === 0) {
                        header("Location:position.php");
                        exit;
                    }
                    $rs = mysqli_fetch_assoc($result);
                }else{
                    header("Location:position.php");
                    exit;
                }
                ?>
                <form id="frm" method="POST">
                    <div class="card">
                        <div class="card-header">
                            <!-- employees_type -->
                            <i class="fa-solid fa-list-check"></i> ส่วนจัดการตำแหน่งพนักงาน
                        </div>
                        <div class="card-body">
                            <div class="form-group row mb-3">
                                <label for="position_name" class="col-sm-3 col-form-label">ชื่อประเภทพนักงาน</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="position_name" name="position_name" value="<?php echo $rs['position_name']; ?>" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="commission_rate" class="col-sm-3 col-form-label">คอมมิชชั่น</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="commission_rate" name="commission_rate" value="<?php echo $rs['commission_rate']; ?>" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="offset-sm-3 col-sm-9">
                                    <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>">
                                    <button type="submit" class="btn btn-primary" name="submit"><i class="far fa-save"></i> บันทึกข้อมูล</button>
                                    <button type="reset" class="btn btn-warning re_frm"><i class="fas fa-redo"></i> รีเซ็ท</button>
                                    <a href="position.php" class="btn btn-dark" name="back"><i class="fas fa-step-backward"></i> ย้อนกลับ</a>
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