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
    <?php
    if (isset($_POST['submit'])) {
        /* mysqli_real_escape_string ป้องกันการโจมตีแบบ SQL Injection (SQL Injection) */
        $edit_id = mysqli_real_escape_string($conn, $_POST['edit_id']);
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $is_member = mysqli_real_escape_string($conn, $_POST['is_member']);
        if ($is_member == 1) {
            $sql = " UPDATE customers SET first_name = '$first_name',
                                          last_name = '$last_name',
                                          email = '$email',
                                          phone_number = '$phone_number',
                                          address = '$address',
                                          is_member = '$is_member',
                                          member_date = CURRENT_TIMESTAMP
                                          WHERE customer_id = '$edit_id' ";
        } else {
            $sql = " UPDATE customers SET first_name = '$first_name',
                                          last_name = '$last_name',
                                          email = '$email',
                                          phone_number = '$phone_number',
                                          address = '$address',
                                          is_member = '$is_member',
                                          member_date = NULL
                                          WHERE customer_id = '$edit_id' ";
        }
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
                    }).then(()=>{
                        window.location.href = 'customer.php';
                    })
                })
            </script>
    <?php
        }
    }

    /* Edit */
    if (isset($_GET['edit_id'])) {
        $edit_id = mysqli_real_escape_string($conn, $_GET['edit_id']);
        $sql_edit = " SELECT * FROM customers WHERE customer_id = '$edit_id' ";
        $result_edit = mysqli_query($conn, $sql_edit);
        $num_edit = mysqli_num_rows($result_edit);
        if($num_edit === 0){
            header("Location:customer.php");
            exit;
        }
        $rs_edit = mysqli_fetch_assoc($result_edit);
    }else{
        header("Location:customer.php");
        exit;
    }
    ?>
    <main>
        <div class="container marketing">
            <h1 class="mb-3 py-5">ข้อมูลลูกค้า</h1>
            <div class="col-md-6 mx-auto mb-3">
                <form id="frm" method="post">
                    <div class="card">
                        <div class="card-header">
                            <!-- employees_type -->
                            <i class="fa-regular fa-user"></i> ส่วนจัดการลูกค้า
                        </div>
                        <div class="card-body">
                            <div class="form-group row mb-3">
                                <label for="first_name" class="col-sm-3 col-form-label">ชื่อ</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $rs_edit['first_name']; ?>" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="last_name" class="col-sm-3 col-form-label">นามสกุล</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $rs_edit['last_name']; ?>" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="email" class="col-sm-3 col-form-label">อีเมล</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $rs_edit['email']; ?>" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="phone_number" class="col-sm-3 col-form-label">เบอร์โทรศัพท์</label>
                                <div class="col-sm-9">
                                    <input type="tel" class="form-control" id="phone_number" name="phone_number" value="<?php echo $rs_edit['phone_number']; ?>" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="address" class="col-sm-3 col-form-label">ที่อยู่</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="address" id="address" rows="5"><?php echo $rs_edit['address']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="is_member" class="col-sm-3 col-form-label">ประเภทสมาชิก</label>
                                <div class="col-sm-9">
                                    <?php
                                    $member_array = ['ลูกค้าไม่เป็นสมาชิก', 'ลูกค้าสมาชิก'];
                                    ?>
                                    <select class="form-control" name="is_member" id="is_member">
                                        <?php for ($i = 0; $i < count($member_array); $i++) { ?>
                                            <?php if($i == $rs_edit['is_member']){?>
                                                <option value="<?php echo $i; ?>" selected><?php echo $member_array[$i]; ?></option>
                                            <?php }else{?>
                                                <option value="<?php echo $i; ?>"><?php echo $member_array[$i]; ?></option>
                                            <?php }?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="offset-sm-3 col-sm-9">
                                    <input type="hidden" name="edit_id" value="<?php echo $rs_edit['customer_id']; ?>">
                                    <button type="submit" class="btn btn-primary" name="submit"><i class="far fa-save"></i> บันทึกข้อมูล</button>
                                    <button type="reset" class="btn btn-warning re_frm"><i class="fas fa-redo"></i> รีเซ็ท</button>
                                    <a href="customer.php" class="btn btn-dark" name="back"><i class="fas fa-step-backward"></i> ย้อนกลับ</a>
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