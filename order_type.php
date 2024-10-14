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
    <?php
    if (isset($_POST['submit'])) {
        /* mysqli_real_escape_string ป้องกันการโจมตีแบบ SQL Injection (SQL Injection) */
        $orders_type_name = mysqli_real_escape_string($conn, $_POST['orders_type_name']);
        $sql = " INSERT INTO orders_type VALUES(NULL,'$orders_type_name') ";
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
            <h1 class="mb-3 py-5">ข้อมูลประเภทออเดอร์</h1>
            <div class="col-md-6 mx-auto mb-3">
                <form id="frm" method="POST">
                    <div class="card">
                        <div class="card-header">
                            <!-- employees_type -->
                            <i class="fa-solid fa-list-check"></i> ส่วนจัดการประเภทออเดอร์
                        </div>
                        <div class="card-body">
                            <div class="form-group row mb-3">
                                <label for="orders_type_name" class="col-sm-3 col-form-label">ประเภทออเดอร์</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="orders_type_name" name="orders_type_name" placeholder="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="offset-sm-3 col-sm-9">
                                    <button type="submit" class="btn btn-primary" name="submit"><i class="far fa-save"></i> บันทึกข้อมูล</button>
                                    <button type="reset" class="btn btn-warning re_frm"><i class="fas fa-redo"></i> รีเซ็ท</button>
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
                            <th scope="col">ประเภทออเดอร์</th>
                            <th scope="col" class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql_ordt = " SELECT * FROM orders_type ORDER BY orders_type_id ASC ";
                        $result_ordt = mysqli_query($conn, $sql_ordt);
                        while ($rs_ordt = mysqli_fetch_assoc($result_ordt)) {
                        ?>
                            <tr>
                                <td class="align-middle text-center"><?php echo $no; ?></td>
                                <td class="align-middle"><?php echo $rs_ordt['orders_type_name']; ?></td>
                                <td class="text-center align-middle">
                                    <a class="btn btn-warning" href="order_type_edit.php?edit_id=<?php echo $rs_ordt['orders_type_id'] ?>"><i class="fa-regular fa-pen-to-square"></i> แก้ไข</a>
                                    <button class="btn btn-danger" type="button" onclick="deletePos(<?php echo $rs_ordt['orders_type_id'] ?>,'<?php echo $rs_ordt['orders_type_name']; ?>')"><i class="fa-solid fa-trash"></i> ลบ</button>
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

        function deletePos(orders_type_id, txt) {
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
                        window.location.href = 'order_type_delete.php?delete_id=' + orders_type_id;
                    })
                }
            });
        }
    </script>



</body>

</html>