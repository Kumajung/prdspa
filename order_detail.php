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
    <main>
        <div class="container marketing">
            <h1 class="mb-3 py-5">ข้อมูลออเดอร์</h1>
            <div class="card">
                <div class="card-header">
                    <!-- employees_type -->
                    <i class="fa-regular fa-rectangle-list"></i> รายละเอียดออเดอร์
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_GET['view_id'])) {
                        $view_id = mysqli_real_escape_string($conn, $_GET['view_id']);
                        $sql_ord = " SELECT * FROM orders WHERE orders_id = '$view_id' ";
                        $result_ord = mysqli_query($conn, $sql_ord);
                        $num_ord = mysqli_num_rows($result_ord);
                        if ($num_ord === 0) {
                            header("Location:index.php");
                            exit;
                        }
                        $rs_ord = mysqli_fetch_assoc($result_ord);
                    } else {
                        header("Location:index.php");
                        exit;
                    }
                    ?>
                    <div class="form-group row mb-3">
                        <label for="telephone" class="col-sm-3 col-form-label">พนักงาน</label>
                        <div class="col-sm-9 pt-2">
                            <?php
                            $sql = " SELECT employees.*,positions.position_name,positions.commission_rate FROM employees 
                                        INNER JOIN positions USING(position_id) WHERE employee_id = '{$rs_ord['employee_id']}' ";
                            $result = mysqli_query($conn, $sql);
                            $rs = mysqli_fetch_assoc($result);
                            $commission_rate = $rs['commission_rate'];
                            ?>
                            <?php echo $rs['first_name']; ?>&nbsp;&nbsp;<?php echo $rs['last_name']; ?> (<?php echo $rs['position_name']; ?>)
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="last_name" class="col-sm-3 col-form-label">เลขออเดอร์</label>
                        <div class="col-sm-9 pt-2">
                            <?php echo $rs_ord['orders_id']; ?>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="last_name" class="col-sm-3 col-form-label">วันที่ทำรายการ</label>
                        <div class="col-sm-9 pt-2">
                            <?php echo date_times($rs_ord['sale_date']); ?>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="last_name" class="col-sm-3 col-form-label">ลูกค้า</label>
                        <div class="col-sm-9 pt-2">
                            <?php
                            $member_array = ['ลูกค้าไม่เป็นสมาชิก', 'ลูกค้าสมาชิก'];
                            ?>
                            <?php
                            $sql = " SELECT * FROM customers WHERE customer_id = '{$rs_ord['customer_id']}' ";
                            $result = mysqli_query($conn, $sql);
                            $rs = mysqli_fetch_assoc($result);
                            ?>
                            <?php echo $rs['first_name']; ?>&nbsp;&nbsp;<?php echo $rs['last_name']; ?>&nbsp;(<?php echo $member_array[$rs['is_member']]; ?>)
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="telephone" class="col-sm-3 col-form-label">ประเภทออเดอร์</label>
                        <div class="col-sm-9 pt-2">
                            <?php
                            $sql = " SELECT * FROM orders_type WHERE orders_type_id = '{$rs_ord['orders_type_id']}' ";
                            $result = mysqli_query($conn, $sql);
                            $rs = mysqli_fetch_assoc($result);
                            ?>
                            <?php echo $rs['orders_type_name']; ?>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="telephone" class="col-sm-3 col-form-label">รายการออเดอร์ ณ วันที่ทำรายการ</label>
                        <div class="col-sm-9">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm table-hover table-striped text-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center align-middle">ลำดับ</th>
                                            <th class="text-start align-middle">แพ็กเกจ</th>
                                            <th class="text-start align-middle">วันที่มาใช้บริการ</th>
                                            <th class="text-end align-middle">ราคาขาย ณ วันที่ทำรายการ</th>
                                            <th class="text-center align-middle">จำนวน</th>
                                            <th class="text-end align-middle">รวม</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $p_total = 0;
                                        $p_total_all = 0;
                                        $qty_total = 0;
                                        $sql_list = " SELECT * FROM orders_detail WHERE orders_id = '$view_id' ";
                                        $result_list = mysqli_query($conn, $sql_list);
                                        while ($rs_list = mysqli_fetch_assoc($result_list)) {
                                            $p_total += $rs_list['price'];
                                            $qty_total += $rs_list['package_qty'];
                                            $p_total_all += $rs_list['package_qty'] * $rs_list['price'];
                                        ?>
                                            <tr>
                                                <td class="align-middle text-center">1</td>
                                                <td class="align-middle">
                                                    <?php
                                                    $sql_pakage = " SELECT * FROM packages WHERE package_id = '{$rs_list['package_id']}' ";
                                                    $result_pakage = mysqli_query($conn, $sql_pakage);
                                                    $rs_pakage = mysqli_fetch_assoc($result_pakage);
                                                    ?>
                                                    <?php echo $rs_pakage['package_name']; ?>
                                                </td>
                                                <td class="align-middle">
                                                    <?php echo date_times($rs_list['service_date']); ?>
                                                </td>
                                                <td class="align-middle text-end"><?php echo formatNumber($rs_list['price']); ?></td>
                                                <td class="align-middle text-center">
                                                    <?php echo formatNumber($rs_list['package_qty']); ?>
                                                </td>
                                                <td class="align-middle text-end">
                                                    <?php echo formatNumber($rs_list['package_qty'] * $rs_list['price']); ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">รวม</td>
                                            <td class="text-end fw-bold"><?php echo formatNumber($p_total); ?></td>
                                            <td class="text-center fw-bold"><?php echo formatNumber($qty_total); ?></td>
                                            <td class="text-end fw-bold"><?php echo formatNumber($p_total_all); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="telephone" class="col-sm-3 col-form-label">ยอดรวมจากราคาปกติ</label>
                        <div class="col-sm-9 pt-2">
                            <?php echo formatNumber($rs_ord['total_price'] + $rs_ord['discount_price']); ?>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="telephone" class="col-sm-3 col-form-label">ส่วนลด</label>
                        <div class="col-sm-9 pt-2">
                            <?php echo formatNumber($rs_ord['discount_price']); ?>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="telephone" class="col-sm-3 col-form-label">ค่าคอมมิชชั่น <?php echo $commission_rate . "%" ?></label>
                        <div class="col-sm-9 pt-2">
                            <?php echo formatNumber(($rs_ord['total_price'] * $commission_rate) / 100); ?>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="telephone" class="col-sm-3 col-form-label">ยอดรวมสุทธิ</label>
                        <div class="col-sm-9 pt-2">
                        <?php echo formatNumber($rs_ord['total_price']-($rs_ord['total_price'] * $commission_rate) / 100); ?>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="offset-sm-3 col-sm-6">
                            <a href="index.php" class="btn btn-dark" name="back"><i class="fas fa-step-backward"></i> ย้อนกลับ</a>
                        </div>
                    </div>
                </div>
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

        function deletePos(orders_id, txt) {
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
                        window.location.href = 'order_delete.php?delete_id=' + orders_id;
                    })
                }
            });
        }
    </script>



</body>

</html>