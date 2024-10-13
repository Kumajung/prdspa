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
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $is_member = mysqli_real_escape_string($conn, $_POST['is_member']);
        if ($is_member == 1) {
            $sql = " INSERT INTO customers VALUES(NULL,'$first_name','$last_name','$email','$phone_number','$address','$is_member',CURRENT_TIMESTAMP) ";
        } else {
            $sql = " INSERT INTO customers VALUES(NULL,'$first_name','$last_name','$email','$phone_number','$address','$is_member',NULL) ";
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
                    })
                })
            </script>
    <?php
        }
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
                            <i class="fa-regular fa-user"></i> ส่วนจัดลูกค้า
                        </div>
                        <div class="card-body">
                            <div class="form-group row mb-3">
                                <label for="first_name" class="col-sm-3 col-form-label">ชื่อ</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="last_name" class="col-sm-3 col-form-label">นามสกุล</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="email" class="col-sm-3 col-form-label">อีเมล</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="phone_number" class="col-sm-3 col-form-label">เบอร์โทรศัพท์</label>
                                <div class="col-sm-9">
                                    <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="address" class="col-sm-3 col-form-label">ที่อยู่</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="address" id="address"></textarea>
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
                                            <option value="<?php echo $i; ?>"><?php echo $member_array[$i]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="offset-sm-3 col-sm-6 d-grid">
                                    <button type="submit" name="submit" class="btn btn-primary"><i class="fa-regular fa-floppy-disk"></i> บันทึก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered mt-3 text-nowrap" id="dataTable">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">ลำดับ</th>
                            <th scope="col">ชื่อ-นามสกุล</th>
                            <th class="text-center" scope="col">อีเมล</th>
                            <th class="text-center" scope="col">เบอร์โทรศัพท์</th>
                            <th class="text-center" scope="col">ที่อยู่</th>
                            <th class="text-center" scope="col">ประเภทสมาชิก</th>
                            <th class="text-center" scope="col">วันที่เป็นสมาชิก</th>
                            <th scope="col" class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql_customer = " SELECT * FROM customers ORDER BY customer_id ASC ";
                        $result_customer = mysqli_query($conn, $sql_customer);
                        while ($rs_customer = mysqli_fetch_assoc($result_customer)) {
                        ?>
                            <tr>
                                <td class="align-middle text-center"><?php echo $no; ?></td>
                                <td class="align-middle"><?php echo $rs_customer['first_name']; ?>&nbsp;&nbsp;<?php echo $rs_customer['last_name']; ?></td>
                                <td class="align-middle text-center"><?php echo $rs_customer['email']; ?></td>
                                <td class="align-middle text-center"><?php echo $rs_customer['phone_number']; ?></td>
                                <td class="align-middle text-center"><?php echo nl2br($rs_customer['address']); ?></td>
                                <td class="align-middle text-center"><?php echo $member_array[$rs_customer['is_member']]; ?></td>
                                <td class="align-middle text-center">
                                    <?php
                                    if ($rs_customer['is_member'] == 1) {
                                        echo date_times($rs_customer['member_date']);
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </td>
                                <td class="text-center align-middle">
                                    <a class="btn btn-warning" href="customer_edit.php?edit_id=<?php echo $rs_customer['customer_id'] ?>"><i class="fa-regular fa-pen-to-square"></i> แก้ไข</a>
                                    <button class="btn btn-danger" type="button" onclick="deletePos(<?php echo $rs_customer['customer_id'] ?>,'<?php echo $rs_customer['first_name']; ?>&nbsp;&nbsp;<?php echo $rs_customer['last_name']; ?>')"><i class="fa-solid fa-trash"></i> ลบ</button>
                                </td>
                            </tr>
                        <?php
                            $no++;
                        } ?>
                    </tbody>
                </table>
            </div>
            <hr class="featurette-divider">
        </div>
        <!-- FOOTER -->
        <?php require './layout/footer.php'; ?>
    </main>
    <script src="./dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script>
        $('#dataTable').DataTable({
            "oLanguage": {
                "sEmptyTable": "ไม่มีข้อมูลในตาราง",
                "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
                "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 แถว",
                "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "แสดง _MENU_ แถว",
                "sLoadingRecords": "กำลังโหลดข้อมูล...",
                "sProcessing": "กำลังดำเนินการ...",
                "sSearch": "ค้นหา: ",
                "sZeroRecords": "ไม่พบข้อมูล",
                "oPaginate": {
                    "sFirst": "หน้าแรก",
                    "sPrevious": "ก่อนหน้า",
                    "sNext": "ถัดไป",
                    "sLast": "หน้าสุดท้าย"
                },
                "oAria": {
                    "sSortAscending": ": เปิดใช้งานการเรียงข้อมูลจากน้อยไปมาก",
                    "sSortDescending": ": เปิดใช้งานการเรียงข้อมูลจากมากไปน้อย"
                }
            }
        });

        function deletePos(position_id, txt) {
            Swal.fire({
                title: `ยืนยันลบ ${txt}?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ตกลง",
                cancelButtonText: "ยกเลิก"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: "success",
                        title: "ลบข้อมูลสำเร็จ",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = 'customer_delete.php?delete_id=' + position_id;
                    })
                }
            });
        }
    </script>
</body>

</html>