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
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
        $salary = mysqli_real_escape_string($conn, $_POST['salary']);
        $position_id = mysqli_real_escape_string($conn, $_POST['position_id']);
        $sql = " INSERT INTO employees VALUES(NULL,'$first_name','$last_name','$telephone','$salary','$position_id') ";
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
                                <label for="telephone" class="col-sm-3 col-form-label">เบอร์โทรศัพท์</label>
                                <div class="col-sm-9">
                                    <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="salary" class="col-sm-3 col-form-label">เงินเดือน</label>
                                <div class="col-sm-9">
                                    <input type="number" step="0.01" class="form-control" id="salary" name="salary" placeholder="" autocomplete="off" required>
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
                                            <option value="<?php echo $rs['position_id']; ?>"><?php echo $rs['position_name']; ?></option>
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
                    </ด>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered mt-3 text-nowrap" id="dataTable">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">ลำดับ</th>
                            <th scope="col">ชื่อ-นามสกุล</th>
                            <th class="text-center" scope="col">เบอร์โทรศัพท์</th>
                            <th class="text-center" scope="col">ตำแหน่ง</th>
                            <th class="text-center" scope="col">เงินเดือน</th>
                            <th scope="col" class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql_employees = " SELECT employees.*,positions.position_name FROM employees INNER JOIN positions USING(position_id) ORDER BY employees.employee_id ASC ";
                        $result_employees = mysqli_query($conn, $sql_employees);
                        while ($rs_employees = mysqli_fetch_assoc($result_employees)) {
                        ?>
                            <tr>
                                <td class="align-middle text-center"><?php echo $no; ?></td>
                                <td class="align-middle"><?php echo $rs_employees['first_name']; ?>&nbsp;&nbsp;<?php echo $rs_employees['last_name']; ?></td>
                                <td class="align-middle text-center"><?php echo $rs_employees['telephone']; ?></td>
                                <td class="align-middle text-center"><?php echo number_format($rs_employees['salary'],2); ?></td>
                                <td class="align-middle text-center"><?php echo $rs_employees['position_name']; ?></td>
                                <td class="text-center align-middle">
                                    <a class="btn btn-warning" href="employee_edit.php?edit_id=<?php echo $rs_employees['employee_id'] ?>"><i class="fa-regular fa-pen-to-square"></i> แก้ไข</a>
                                    <button class="btn btn-danger" type="button" onclick="deletePos(<?php echo $rs_employees['employee_id'] ?>,'<?php echo $rs_employees['first_name']; ?>&nbsp;&nbsp;<?php echo $rs_employees['last_name']; ?>')"><i class="fa-solid fa-trash"></i> ลบ</button>
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
                        window.location.href = 'employee_delete.php?delete_id=' + position_id;
                    })
                }
            });
        }
    </script>



</body>

</html>